<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    stocks: Object,
});
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
                    <div v-for="stock in stocks.data" :key="stock.id">
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

                            <div class="flex items-end gap-2">
                                <span class="font-bold text-gray-800 lg:text-lg"
                                    >￥{{ stock.fee }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <!-- product - end -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
