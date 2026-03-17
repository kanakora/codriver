<script setup>
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <main class="container mx-auto px-4 py-12 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="space-y-8">
                <div class="space-y-4">
                    <div
                        class="inline-flex items-center rounded-full bg-green-100 px-4 py-1.5 text-sm font-medium text-green-700 dark:bg-green-900/30 dark:text-green-300"
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
                        Certified Instructors • 98% Pass Rate
                    </div>
                    <h1
                        class="title-header text-4xl font-bold tracking-tight text-gray-900 lg:text-5xl xl:text-6xl dark:text-white"
                    >
                        Master the Road with
                        <span class="text-green-600 dark:text-green-400"
                            >Confidence</span
                        >
                    </h1>
                    <p
                        class="text-lg text-gray-600 lg:text-xl dark:text-gray-300"
                    >
                        Professional driving lessons tailored to your pace. Get
                        your license faster with our certified instructors and
                        modern teaching methods.
                    </p>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-green-600 px-8 py-4 text-center text-lg font-semibold text-white shadow-lg shadow-green-500/20 transition-colors hover:bg-green-700"
                    >
                        Start Your Driving Journey
                    </Link>
                    <a
                        href="#features"
                        class="rounded-lg border border-gray-300 bg-white px-8 py-4 text-center text-lg font-semibold text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                    >
                        View Courses
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-6 pt-4">
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-green-600 dark:text-green-400"
                        >
                            2,500+
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Students Trained
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-green-600 dark:text-green-400"
                        >
                            98%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Pass Rate
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-green-600 dark:text-green-400"
                        >
                            15+
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Years Experience
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                    <img
                        src="../../../img/hero-driver.jpg"
                        alt="Hero Image"
                        class="rounded-xl"
                    />
                </div>
            </div>
        </div>
    </main>
</template>
