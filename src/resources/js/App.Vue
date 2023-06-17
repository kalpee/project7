<template>
    <div>{{ hello }}</div>
</template>

<script lang="ts">
import { ref } from "vue";
export default {
    setup() {
        const hello = ref("Hello Project7");

        return {
            hello,
        };
    },
};
</script>
