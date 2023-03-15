<template>
    <table class="min-w-full text-left text-sm font-light">
        <thead class="border-b font-medium dark:border-neutral-500">
        <tr>
            <th scope="col" class="px-6 py-4">#</th>
            <th scope="col" class="px-6 py-4">First</th>
            <th scope="col" class="px-6 py-4">Last</th>
            <th scope="col" class="px-6 py-4">Handle</th>
        </tr>
        </thead>
        <tbody>
        <tr
            class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
            <td class="whitespace-nowrap px-6 py-4 font-medium">1</td>
            <td class="whitespace-nowrap px-6 py-4">Mark</td>
            <td class="whitespace-nowrap px-6 py-4">Otto</td>
            <td class="whitespace-nowrap px-6 py-4">@mdo</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {

    data() {
        return {
            items: [],
            itemToAdd: ''
        }
    },

    mounted() {
        const channel = Echo.channel('update-channel');
        channel.listen('UpdateEvent', (e) => {
                this.items = e.data;
                console.log('salam');
                console.log(e.data);
            })
    },

    name: "currency-list"
}
</script>

<style scoped>

</style>
