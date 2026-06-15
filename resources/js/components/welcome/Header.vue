<script setup>
import { Link } from '@inertiajs/vue3';
import { Moon, Sun, Menu, X } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { useAppearance } from '@/composables/useAppearance';
import { ref, onMounted, onUnmounted, computed } from 'vue';
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

const { resolvedAppearance, updateAppearance } = useAppearance();
const isMobileMenuOpen = ref(false);
const isScrolled = ref(false);
const SCROLL_THRESHOLD = 60;

const toggleDarkMode = () => {
    updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
};

const menuItems = [
    { name: 'Home', route: 'home' },
    { name: 'Duty Calculator', route: 'dashboard' },
    { name: 'Insurance', route: 'dashboard' },
    { name: 'About Us', route: 'dashboard' },
    { name: 'Contact Us', route: 'contact' },
];

let ticking = false;

const onScroll = () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            isScrolled.value = window.scrollY > SCROLL_THRESHOLD;
            ticking = false;
        });
        ticking = true;
    }
};

onMounted(() => {
    isScrolled.value = window.scrollY > SCROLL_THRESHOLD;
    window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});
</script>

<template>
    <header
        :class="[
            'fixed top-0 right-0 left-0 z-50 transition-all duration-500',
            isScrolled
                ? 'bg-white/80 backdrop-blur-xl dark:bg-gray-950/80'
                : 'bg-transparent',
        ]"
    >
        <div
            :class="[
                'mx-auto flex items-center justify-between transition-all duration-500',
                isScrolled
                    ? 'max-w-5xl px-6 py-3'
                    : 'max-w-7xl px-4 py-4 sm:px-6 lg:py-5',
            ]"
        >
            <Link :href="route('home')" class="flex items-center gap-2 shrink-0">
                <AppLogo />
            </Link>

            <nav class="hidden items-center gap-8 md:flex">
                <Link
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="route(item.route)"
                    :class="[
                        'text-sm font-medium transition-colors',
                        isScrolled
                            ? 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'
                            : 'text-gray-700 hover:text-gray-900 dark:text-white/70 dark:hover:text-white',
                    ]"
                >
                    {{ item.name }}
                </Link>
            </nav>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    @click="toggleDarkMode"
                    :class="[
                        'relative flex size-9 items-center justify-center rounded-lg transition-colors overflow-hidden',
                        isScrolled
                            ? 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'
                            : 'text-gray-700 hover:bg-gray-900/5 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-white',
                    ]"
                    :aria-label="resolvedAppearance === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
                >
                    <Sun
                        :class="[
                            'size-4 absolute transition-all duration-500',
                            resolvedAppearance === 'light' ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 rotate-90 scale-75',
                        ]"
                    />
                    <Moon
                        :class="[
                            'size-4 absolute transition-all duration-500',
                            resolvedAppearance === 'dark' ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 -rotate-90 scale-75',
                        ]"
                    />
                </button>

                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        :class="[
                            'hidden rounded-lg px-4 py-2 text-sm font-medium transition-all md:inline-block',
                            isScrolled
                                ? 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100'
                                : 'bg-white text-gray-900 hover:bg-gray-100',
                        ]"
                    >
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link
                    :href="route('login')"
                    :class="[
                        'hidden rounded-lg px-4 py-2 text-sm font-medium transition-colors md:inline-block',
                        isScrolled
                            ? 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'
                            : 'text-gray-700 hover:text-gray-900 dark:text-white/70 dark:hover:text-white',
                    ]"
                >
                    Log in
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    :class="[
                        'hidden rounded-lg px-4 py-2 text-sm font-medium transition-all md:inline-block',
                        isScrolled
                            ? 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100'
                            : 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100',
                    ]"
                    >
                        Get Started
                    </Link>
                </template>

                <button
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    :class="[
                        'flex size-9 items-center justify-center rounded-lg transition-colors md:hidden',
                        isScrolled
                            ? 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'
                            : 'text-gray-700 hover:bg-gray-900/5 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-white',
                    ]"
                >
                    <Menu v-if="!isMobileMenuOpen" class="size-5" />
                    <X v-else class="size-5" />
                </button>
            </div>
        </div>

        <div
            v-if="isMobileMenuOpen"
            :class="[
                'mx-auto rounded-2xl border p-4 shadow-2xl backdrop-blur-xl transition-all duration-500 md:hidden',
                isScrolled
                    ? 'max-w-5xl border-gray-200 bg-white/95 dark:border-gray-800 dark:bg-gray-900/95'
                    : 'max-w-7xl border-gray-200 bg-white/95 dark:border-white/10 dark:bg-gray-900/95',
            ]"
        >
            <div class="flex flex-col gap-2">
                <Link
                    v-for="item in menuItems"
                    :key="item.name"
                    :href="route(item.route)"
                    :class="[
                        'rounded-lg px-4 py-2.5 text-sm font-medium transition-colors',
                        isScrolled
                            ? 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'
                            : 'text-gray-700 hover:bg-gray-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-white',
                    ]"
                    @click="isMobileMenuOpen = false"
                >
                    {{ item.name }}
                </Link>

                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        :class="[
                            'mt-2 rounded-lg px-4 py-2.5 text-center text-sm font-medium transition-all',
                            isScrolled
                                ? 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100'
                                : 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100',
                        ]"
                        @click="isMobileMenuOpen = false"
                    >
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <hr :class="['my-2', isScrolled ? 'border-gray-200 dark:border-gray-800' : 'border-gray-200 dark:border-white/10']" />
                    <Link
                        :href="route('login')"
                        :class="[
                            'rounded-lg px-4 py-2.5 text-center text-sm font-medium transition-colors',
                            isScrolled
                                ? 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'
                                : 'text-gray-700 hover:bg-gray-100 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-white',
                        ]"
                        @click="isMobileMenuOpen = false"
                    >
                        Log in
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        :class="[
                            'mt-1 rounded-lg px-4 py-2.5 text-center text-sm font-medium transition-all',
                            isScrolled
                                ? 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100'
                                : 'bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100',
                        ]"
                        @click="isMobileMenuOpen = false"
                    >
                        Get Started
                    </Link>
                </template>
            </div>
        </div>
    </header>
</template>
