<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    orders: Object,
});

const deleteOrder = (orderId) => {
    if (confirm("この注文を削除しますか？")) {
        Inertia.delete(route("orders.destroy", orderId));
    }
};
</script>

<template>
    <Head title="購買履歴" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購買履歴
            </h2>
        </template>

        <section class="container px-4 mx-auto">
            <div class="flex flex-col mt-6">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                    >
                        <div
                            class="overflow-hidden border border-gray-200 md:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500"
                                        >
                                            <div
                                                class="flex items-center gap-x-3"
                                            >
                                                <span>商品名</span>
                                            </div>
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                        >
                                            <span>値段</span>
                                        </th>

                                        <th
                                            scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                        >
                                            <span>購入日</span>
                                        </th>

                                        <th
                                            scope="col"
                                            class="relative py-3.5 px-4"
                                        >
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr v-for="order in orders">
                                        <td
                                            class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap"
                                        >
                                            <div
                                                class="inline-flex items-center gap-x-3"
                                            >
                                                <div
                                                    class="flex items-center gap-x-2"
                                                >
                                                    <img
                                                        class="object-cover w-10 h-10 rounded-full"
                                                        :src="
                                                            '/images/' +
                                                            order.stock.imgpath
                                                        "
                                                        alt=""
                                                    />
                                                    <div>
                                                        <h2
                                                            class="font-medium text-gray-800"
                                                        >
                                                            {{
                                                                order.stock.name
                                                            }}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-12 py-4 text-sm text-gray-700 whitespace-nowrap"
                                        >
                                            {{ order.stock.fee }}円
                                        </td>
                                        <td
                                            class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap"
                                        >
                                            {{ order.formatted_created_at }}
                                        </td>

                                        <td
                                            class="px-4 py-4 text-sm whitespace-nowrap"
                                        >
                                            <div
                                                class="flex items-center gap-x-6"
                                            >
                                                <button
                                                    @click="
                                                        deleteOrder(order.id)
                                                    "
                                                    class="text-gray-500 transition-colors duration-200 hover:text-red-500 focus:outline-none"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="w-5 h-5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a
                    href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 rtl:-scale-x-100"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"
                        />
                    </svg>

                    <span> previous </span>
                </a>

                <div class="items-center hidden lg:flex gap-x-3">
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-blue-500 rounded-md bg-blue-100/60"
                        >1</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >2</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >3</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >...</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >12</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >13</a
                    >
                    <a
                        href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                        >14</a
                    >
                </div>

                <a
                    href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                >
                    <span> Next </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 rtl:-scale-x-100"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                        />
                    </svg>
                </a>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
