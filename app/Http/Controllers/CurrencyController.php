<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Currency as CurrencyResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Events\UpdateEvent;
class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return [
            "status" => 1,
            "data" => $currencies
        ];
    }

    public function store(Request $request)
    {
        $response = Http::get('https://api.monobank.ua/bank/currency');
        $currencies = json_decode($response->body(), true);
        foreach ($currencies as $currency){
            Currency::create($currency);
        }
        return 'successfully imported Currencies data';
    }

    public function show(Currency $currency)
    {
        return [
            "status" => 1,
            "data" =>$currency
        ];
    }

    public function update(Request $request, Currency $currency)
    {
        $response = Http::get('https://api.monobank.ua/bank/currency');
        $currencies = json_decode($response->body(), true);
        $updatedCurrency = [];
        foreach ($currencies as $k => $currency){
            $data = Currency::where('currencyCodeA', $currency['currencyCodeA'])
                ->where('currencyCodeB', $currency['currencyCodeB']);
            if($data->exists()) {
                $oldData = $data->first();
                $check = array_diff($oldData->toArray(), $currency);
                if($check != []) {
                    $oldData->update($currency);
                    $updatedCurrency[] = $currency;
                }
            }
        }
        broadcast(new UpdateEvent('The currencies was updated', $updatedCurrency));
        return [
            "status" => 200,
            "data" => $updatedCurrency,
            "msg" => "Currencies were updated successfully"
        ];
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return [
            "status" => 1,
            "data" => $currency,
            "msg" => "Currency deleted successfully"
        ];
    }
}
