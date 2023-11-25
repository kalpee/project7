<script setup>
import { ref, onMounted, computed, nextTick } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps(["carts"]);

const showModal = ref(false);

const toggleModal = () => {
    showModal.value = !showModal.value;

    if (showModal.value) {
        nextTick().then(() => {
            card.mount("#card-element");
        });
    } else {
        card.unmount();
    }
};

// Stripe 関連
let stripe, elements, card;

onMounted(async () => {
    await nextTick();
    stripe = Stripe(import.meta.env.VITE_STRIPE_KEY);
    elements = stripe.elements();
    card = elements.create("card");
});

const initiatePayment = async () => {
    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: "card",
        card: card,
    });

    if (error) {
        console.error(error);
        // エラーハンドリング
    } else {
        Inertia.post("/carts/payment", {
            paymentMethodId: paymentMethod.id,
            total_amount: cartTotal.value,
        });
    }
};

const increaseQuantity = (cartItem) => {
    cartItem.quantity++;
    updateQuantityInDb(cartItem);
};

const decreaseQuantity = (cartItem) => {
    if (cartItem.quantity > 1) {
        cartItem.quantity--;
        updateQuantityInDb(cartItem);
    }
};

const updateQuantityInDb = (cartItem) => {
    Inertia.post(`/carts/${cartItem.id}/update-quantity`, {
        quantity: cartItem.quantity,
    });
};

const cartTotal = computed(() => {
    return props.carts.reduce((total, cart) => {
        if (cart.stock && cart.stock.fee && cart.quantity) {
            return total + cart.stock.fee * cart.quantity;
        }
        return total;
    }, 0);
});

const deleteFromCart = (cartId) => {
    if (confirm("カートからこの商品を削除しますか？")) {
        Inertia.post(`/carts/${cartId}/delete`);
    }
};
</script>

<template>
    <Head title="カート" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                カート
            </h2>
        </template>

        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="mx-auto max-w-screen-lg px-4 md:px-8">
                <div
                    class="mb-5 flex flex-col sm:mb-8 sm:divide-y sm:border-t sm:border-b"
                >
                    <!-- product - start -->
                    <div
                        v-for="cart in props.carts"
                        :key="cart.id"
                        class="py-5 sm:py-8"
                    >
                        <div class="flex flex-wrap gap-4 sm:py-2.5 lg:gap-6">
                            <div class="sm:-my-2.5">
                                <a
                                    href="#"
                                    class="group relative block h-40 w-24 overflow-hidden rounded-lg bg-gray-100 sm:h-56 sm:w-40"
                                >
                                    <img
                                        :src="'/images/' + cart.stock.imgpath"
                                        loading="lazy"
                                        alt="Photo by Thái An"
                                        class="h-full w-full object-cover object-center transition duration-200 group-hover:scale-110"
                                    />
                                </a>
                            </div>

                            <div class="flex flex-1 flex-col justify-between">
                                <div>
                                    <a
                                        href="#"
                                        class="mb-1 inline-block text-lg font-bold text-gray-800 transition duration-100 hover:text-gray-500 lg:text-xl"
                                        >{{ cart.stock.name }}</a
                                    >
                                </div>

                                <div>
                                    <span
                                        class="mb-1 block font-bold text-gray-800 md:text-lg"
                                        >{{ cart.stock.fee }}円</span
                                    >
                                </div>
                            </div>

                            <div
                                class="flex w-full justify-between border-t pt-4 sm:w-auto sm:border-none sm:pt-0"
                            >
                                <div class="flex flex-col items-start gap-2">
                                    <div
                                        class="flex h-12 w-20 overflow-hidden rounded border"
                                    >
                                        <input
                                            :value="cart.quantity"
                                            class="w-full px-4 py-2 outline-none ring-inset ring-indigo-300 transition duration-100 focus:ring"
                                        />

                                        <div
                                            class="flex flex-col divide-y border-l"
                                        >
                                            <button
                                                @click="increaseQuantity(cart)"
                                                class="flex w-6 flex-1 select-none items-center justify-center bg-white leading-none transition duration-100 hover:bg-gray-100 active:bg-gray-200"
                                            >
                                                +
                                            </button>
                                            <button
                                                @click="decreaseQuantity(cart)"
                                                class="flex w-6 flex-1 select-none items-center justify-center bg-white leading-none transition duration-100 hover:bg-gray-100 active:bg-gray-200"
                                            >
                                                -
                                            </button>
                                        </div>
                                    </div>

                                    <button
                                        @click="deleteFromCart(cart.id)"
                                        class="select-none text-sm font-semibold text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700"
                                    >
                                        カートから削除
                                    </button>
                                </div>

                                <div class="ml-4 pt-3 sm:pt-2 md:ml-8 lg:ml-16">
                                    <span
                                        class="block font-bold text-gray-800 md:text-lg"
                                        >{{
                                            cart.stock.fee * cart.quantity
                                        }}円</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product - end -->
                </div>

                <!-- totals - start -->
                <div class="flex flex-col items-end gap-4">
                    <div class="w-full rounded-lg bg-gray-100 p-4 sm:max-w-xs">
                        <div
                            class="flex items-start justify-between gap-4 text-gray-800"
                        >
                            <span class="text-lg font-bold">合計</span>

                            <span class="flex flex-col items-end">
                                <span class="text-lg font-bold"
                                    >{{ cartTotal }}円</span
                                >
                            </span>
                        </div>
                    </div>

                    <button
                        @click="toggleModal"
                        class="inline-block rounded-lg bg-indigo-500 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-indigo-300 transition duration-100 hover:bg-indigo-600 focus-visible:ring active:bg-indigo-700 md:text-base"
                    >
                        購入する
                    </button>
                </div>
                <!-- totals - end -->
                <!-- modal - start -->
                <div
                    v-if="showModal"
                    class="fixed z-10 inset-0 overflow-y-auto bg-gray-600 bg-opacity-70"
                >
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="bg-white p-4 rounded-lg w-2/3">
                            <h2 class="text-lg font-semibold">
                                カード情報を入力してください
                            </h2>
                            <!-- カード情報のフォーム -->
                            <form
                                class="mt-4"
                                @submit.prevent="initiatePayment"
                            >
                                <div id="card-element">
                                    <!-- Stripe.jsがカード情報をここに挿入 -->
                                </div>

                                <div
                                    class="mt-4 sm:flex sm:items-center sm:-mx-2"
                                >
                                    <button
                                        type="button"
                                        @click="toggleModal"
                                        class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40"
                                    >
                                        閉じる
                                    </button>

                                    <button
                                        type="submit"
                                        class="w-full px-4 py-2 mt-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"
                                    >
                                        購入する
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- modal - end -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
