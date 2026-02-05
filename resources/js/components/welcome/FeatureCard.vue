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
        class="rounded-2xl bg-white p-8 shadow-lg transition-transform hover:-translate-y-1 dark:bg-gray-800"
    >
        <div
            class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30"
        >
            <slot name="icon" />
        </div>
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
            {{ title }}
        </h3>
        <p class="text-gray-600 dark:text-gray-300">
            {{ description }}
        </p>
    </div>
</template>
