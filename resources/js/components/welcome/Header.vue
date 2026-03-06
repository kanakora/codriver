<script setup>
import { Link } from '@inertiajs/vue3';
import { Moon, Sun, Menu } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { useAppearance } from '@/composables/useAppearance';
import { ref } from 'vue';
import AppLogo from '../AppLogo.vue';

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
const isMobileMenuOpen = ref(false);

const toggleDarkMode = () => {
    const newAppearance =
        resolvedAppearance.value === 'dark' ? 'light' : 'dark';
    updateAppearance(newAppearance);
};

const menuItems = [
    { name: 'Home', route: 'home' },
    { name: 'Duty Calculator', route: 'dashboard' },
    { name: 'Insurance', route: 'dashboard' },
    { name: 'About Us', route: 'dashboard' },
    { name: 'Contact Us', route: 'dashboard' },
];
</script>

<template>
    <header class="container mx-auto px-4 py-6 lg:px-8 lg:py-8">
        <nav class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2 bg-white rounded-xl pl-2 pr-4 py-1.5 border">
                <AppLogo />
            </div>

            <!-- Desktop Navigation Menu -->
            <div class="hidden md:flex items-center space-x-6 bg-white rounded-2xl py-2 px-3 border">
                <Link
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="route(item.route)"
                    class="text-sm font-medium text-gray-700 transition-colors hover:text-green-600 dark:text-gray-200 dark:hover:text-green-400 px-2 py-1.5 rounded-lg"
                    :class="route().current(item.route) ? 'text-green-600 font-semibold bg-green-100 border-green-200 border' : 'hover:bg-green-50'"
                >
                    {{ item.name }}
                </Link>
            </div>

            <!-- Right side buttons -->
            <div class="flex items-center space-x-4">
                <!-- Dark mode toggle -->
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

                <!-- Auth buttons (desktop) -->
                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="hidden md:inline-block rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-700"
                    >
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="hidden md:inline-block rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="hidden md:inline-block rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-700"
                    >
                        Get Started
                    </Link>
                </template>

                <!-- Mobile menu button -->
                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="md:hidden rounded-lg border border-gray-300 bg-white p-2.5 text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <Menu class="h-5 w-5" />
                </button>
            </div>
        </nav>

        <!-- Mobile Navigation Menu -->
        <div
            v-if="isMobileMenuOpen"
            class="md:hidden mt-4 rounded-lg border border-gray-200 bg-white p-4 shadow-lg dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="flex flex-col space-y-3">
                <Link
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="route(item.route)"
                    class="text-sm font-medium text-gray-700 transition-colors hover:text-green-600 dark:text-gray-200 dark:hover:text-green-400"
                    @click="isMobileMenuOpen = false"
                >
                    {{ item.name }}
                </Link>
                
                <!-- Mobile auth buttons -->
                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-700 text-center"
                        @click="isMobileMenuOpen = false"
                    >
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 text-center"
                        @click="isMobileMenuOpen = false"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-700 text-center"
                        @click="isMobileMenuOpen = false"
                    >
                        Get Started
                    </Link>
                </template>
            </div>
        </div>
    </header>
</template>