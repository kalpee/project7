<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    stock: Object,
});

const form = ref({ ...props.stock });
const imagePreview = ref(`/images/${props.stock.imgpath}`);

const updateStock = () => {
    const formData = new FormData();
    formData.append("name", form.value.name);
    formData.append("detail", form.value.detail);
    formData.append("fee", form.value.fee);
    formData.append("imgpath", form.value.imgpath);

    Inertia.post(`/stocks/${form.value.id}/update`, formData);
};

const handleImageUpload = (event) => {
    form.value.imgpath = event.target.files[0];

    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

const deleteStock = () => {
    if (window.confirm("本当にこの商品を削除しますか？")) {
        Inertia.post(`/stocks/${form.value.id}/delete`, {
            _method: "DELETE",
        });
    }
};

watch(form, () => {
    imagePreview.value = `/images/${form.value.imgpath}`;
});
</script>

<template>
    <Head title="商品詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品詳細
            </h2>
        </template>

        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                    <img
                        alt="ecommerce"
                        class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                        :src="imagePreview"
                    />
                    <form
                        class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0"
                        @submit.prevent="updateStock"
                        enctype="multipart/form-data"
                    >
                        <div>
                            <label
                                for="name"
                                class="mb-2 inline-block text-sm text-gray-800 sm:text-base"
                                >商品名</label
                            >
                            <input
                                name="name"
                                type="text"
                                id="name"
                                v-model="stock.name"
                                required
                                class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring"
                            />
                        </div>
                        <div class="my-3 sm:col-span-2">
                            <label
                                for="detail"
                                class="mb-2 inline-block text-sm text-gray-800 sm:text-base"
                                >詳細</label
                            >
                            <textarea
                                name="detail"
                                id="detail"
                                v-model="stock.detail"
                                required
                                class="h-64 w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring"
                            ></textarea>
                        </div>

                        <div>
                            <label
                                for="fee"
                                class="mb-2 inline-block text-sm text-gray-800 sm:text-base"
                                >価格</label
                            >
                            <input
                                name="fee"
                                type="number"
                                id="fee"
                                v-model="stock.fee"
                                required
                                class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring"
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <label
                                for="imgpath"
                                class="mt-4 mb-2 inline-block text-sm text-gray-800 sm:text-base"
                                >画像</label
                            >
                            <input
                                name="imgpath"
                                type="file"
                                id="imgpath"
                                @input="handleImageUpload"
                                class="w-full py-2"
                            />
                        </div>
                        <div class="flex justify-between">
                            <button
                                type="button"
                                @click="deleteStock"
                                class="flex ml-auto text-white bg-red-500 border-0 my-5 py-2 px-6 focus:outline-none hover:bg-red-600 rounded"
                            >
                                削除
                            </button>
                            <button
                                type="submit"
                                class="flex ml-auto text-white bg-indigo-500 border-0 my-5 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                            >
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
