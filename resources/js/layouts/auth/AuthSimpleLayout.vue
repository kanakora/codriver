<script setup>
import { Link } from '@inertiajs/vue3';
import { Moon, Sun } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { useAppearance } from '@/composables/useAppearance';
import AppLogo from '@/components/AppLogo.vue';

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
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <!-- Header -->
        <header class="container mx-auto px-4 py-6 lg:px-8 lg:py-8">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <Link
                        :href="route('home')"
                        class="flex items-center space-x-2 rounded-xl border bg-white dark:bg-gray-800 py-1.5 pr-4 pl-2"
                    >
                        <AppLogo />
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
        <main class="container mx-auto px-4 lg:px-8 flex flex-col flex-1 justify-center">
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md">
                    <div
                        class="rounded-2xl border bg-white p-8 lg:p-10 dark:bg-gray-800"
                    >
                        <div class="mb-8 text-center">
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
