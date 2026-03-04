<script setup>
import { Link } from '@inertiajs/vue3';
import { Moon, Sun } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { useAppearance } from '@/composables/useAppearance';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
    auth: {
        type: Object,
        default: () => ({}),
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
    <header class="container mx-auto px-4 py-6 lg:px-8 lg:py-8">
        <nav class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
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
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        Codriver
                    </h1>
                    <p class="text-xs text-gray-600 dark:text-gray-300">
                        Platform
                    </p>
                </div>
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
                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                    >
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                    >
                        Get Started
                    </Link>
                </template>
            </div>
        </nav>
    </header>
</template>
