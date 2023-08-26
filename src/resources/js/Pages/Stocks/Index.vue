<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    stocks: Object,
});

const addToCart = async (stockId) => {
    try {
        const response = await axios.post("/carts/add", { stock_id: stockId });
        // 追加後の通知やレスポンス処理
        console.log(response.data.message);
    } catch (error) {
        // エラーハンドリング
        console.error("Error adding to cart:", error);
    }
};
</script>

<template>
    <Head title="商品一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧
            </h2>
        </template>

        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
                <div
                    class="grid gap-x-4 gap-y-8 sm:grid-cols-2 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <!-- product - start -->
                    <div v-for="stock in props.stocks.data" :key="stock.id">
                        <a
                            href="#"
                            class="group relative mb-2 block h-80 overflow-hidden rounded-lg bg-gray-100 lg:mb-3"
                        >
                            <img
                                :src="'/images/' + stock.imgpath"
                                loading="lazy"
                                alt="Photo by Rachit Tank"
                                class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110"
                            />
                        </a>

                        <div>
                            <a
                                href="#"
                                class="hover:gray-800 mb-1 text-gray-500 transition duration-100 lg:text-lg"
                                >{{ stock.name }}</a
                            >

                            <div class="flex justify-between items-end gap-2">
                                <span class="font-bold text-gray-800 lg:text-lg"
                                    >￥{{ stock.fee }}</span
                                >
                                <button
                                    @click="addToCart(stock.id)"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded"
                                >
                                    カートに追加
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- product - end -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
