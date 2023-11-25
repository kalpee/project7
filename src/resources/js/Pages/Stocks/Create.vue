<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const form = ref({
    name: "",
    detail: "",
    fee: "",
    imgpath: null,
});

const submit = () => {
    const formData = new FormData();
    formData.append("name", form.value.name);
    formData.append("detail", form.value.detail);
    formData.append("fee", form.value.fee);
    formData.append("imgpath", form.value.imgpath);

    Inertia.post("/stocks/store", formData);
};
</script>

<template>
    <Head title="商品登録" />

    <AuthenticatedLayout>
        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
                <!-- form - start -->
                <form
                    @submit.prevent="submit"
                    enctype="multipart/form-data"
                    class="mx-auto grid max-w-screen-md gap-4 sm:grid-cols-2"
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
                            v-model="form.name"
                            required
                            class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label
                            for="detail"
                            class="mb-2 inline-block text-sm text-gray-800 sm:text-base"
                            >詳細</label
                        >
                        <textarea
                            name="detail"
                            id="detail"
                            v-model="form.detail"
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
                            v-model="form.fee"
                            required
                            class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label
                            for="imgpath"
                            class="mb-2 inline-block text-sm text-gray-800 sm:text-base"
                            >画像</label
                        >
                        <input
                            name="imgpath"
                            type="file"
                            id="imgpath"
                            @input="form.imgpath = $event.target.files[0]"
                            class="w-full py-2"
                        />
                    </div>

                    <div
                        class="flex items-center justify-between sm:col-span-2"
                    >
                        <button
                            type="submit"
                            class="inline-block rounded-lg bg-indigo-500 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-indigo-300 transition duration-100 hover:bg-indigo-600 focus-visible:ring active:bg-indigo-700 md:text-base"
                        >
                            登録
                        </button>
                    </div>
                </form>
                <!-- form - end -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
