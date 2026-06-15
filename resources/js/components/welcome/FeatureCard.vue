<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div
        class="rounded-2xl border border-gray-100 bg-white p-8 transition-all hover:border-gray-200 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
    >
        <div
            class="mb-5 inline-flex size-12 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20"
        >
            <slot name="icon" />
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
            {{ title }}
        </h3>
        <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            {{ description }}
        </p>
    </div>
</template>
