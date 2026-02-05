<script setup>
import { Link } from '@inertiajs/vue3';
import { Moon, Sun } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { useAppearance } from '@/composables/useAppearance';

defineProps({
    title: {
        type: String,
        default: null,
    },
    description: {
        type: String,
        default: null,
    },
});

const { appearance, resolvedAppearance, updateAppearance } = useAppearance();

const toggleDarkMode = () => {
    const newAppearance =
        resolvedAppearance.value === 'dark' ? 'light' : 'dark';
    updateAppearance(newAppearance);
};
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-950"
    >
        <!-- Header -->
        <header class="container mx-auto px-4 py-6 lg:px-8 lg:py-8">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <Link
                        :href="route('home')"
                        class="flex items-center space-x-2"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600"
                        >
                            <svg
                                class="h-6 w-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h1
                                class="text-xl font-bold text-gray-900 dark:text-white"
                            >
                                DriveSafe
                            </h1>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                Driving School
                            </p>
                        </div>
                    </Link>
                </div>
                <div class="flex items-center space-x-4">
                    <button
                        @click="toggleDarkMode"
                        class="rounded-lg border border-gray-300 bg-white p-2.5 text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                        :aria-label="
                            resolvedAppearance === 'dark'
                                ? 'Switch to light mode'
                                : 'Switch to dark mode'
                        "
                    >
                        <Sun
                            v-if="resolvedAppearance === 'light'"
                            class="h-5 w-5"
                        />
                        <Moon v-else class="h-5 w-5" />
                    </button>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-12 lg:px-8 lg:py-24">
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md">
                    <div
                        class="rounded-2xl bg-white p-8 shadow-2xl lg:p-10 dark:bg-gray-800"
                    >
                        <div class="mb-8 text-center">
                            <div
                                class="mb-4 inline-flex items-center rounded-full bg-blue-100 px-4 py-1.5 text-sm font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"
                            >
                                <svg
                                    class="mr-2 h-4 w-4"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Secure Authentication
                            </div>
                            <h1
                                class="text-3xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ title }}
                            </h1>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ description }}
                            </p>
                        </div>
                        <slot />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
