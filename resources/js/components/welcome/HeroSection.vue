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
    <main class="container mx-auto px-4 py-12 lg:px-8 lg:py-24">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="space-y-8">
                <div class="space-y-4">
                    <div
                        class="inline-flex items-center rounded-full bg-blue-100 px-4 py-1.5 text-sm font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"
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
                        class="text-4xl font-bold tracking-tight text-gray-900 lg:text-5xl xl:text-6xl dark:text-white"
                    >
                        Master the Road with
                        <span class="text-blue-600 dark:text-blue-400"
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
                        class="rounded-lg bg-blue-600 px-8 py-4 text-center text-lg font-semibold text-white shadow-lg shadow-blue-500/20 transition-colors hover:bg-blue-700"
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
                            class="text-3xl font-bold text-blue-600 dark:text-blue-400"
                        >
                            2,500+
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Students Trained
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-blue-600 dark:text-blue-400"
                        >
                            98%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Pass Rate
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-blue-600 dark:text-blue-400"
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
                    <div
                        class="aspect-[4/3] bg-gradient-to-br from-blue-500 to-blue-600"
                    >
                        <div
                            class="absolute inset-0 flex items-center justify-center p-8"
                        >
                            <div class="w-full max-w-md space-y-6">
                                <div
                                    class="rounded-xl bg-white/10 p-6 backdrop-blur-sm"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <div class="text-sm text-white/80">
                                                Current Course
                                            </div>
                                            <div
                                                class="text-2xl font-bold text-white"
                                            >
                                                Beginner Driving
                                            </div>
                                        </div>
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20"
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
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div
                                            class="mb-2 flex justify-between text-sm text-white/80"
                                        >
                                            <span>Progress</span>
                                            <span>65%</span>
                                        </div>
                                        <div
                                            class="h-2 overflow-hidden rounded-full bg-white/20"
                                        >
                                            <div
                                                class="h-full w-2/3 rounded-full bg-white"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div
                                        class="rounded-xl bg-white/10 p-4 backdrop-blur-sm"
                                    >
                                        <div class="text-sm text-white/80">
                                            Lessons
                                        </div>
                                        <div
                                            class="text-2xl font-bold text-white"
                                        >
                                            12/20
                                        </div>
                                    </div>
                                    <div
                                        class="rounded-xl bg-white/10 p-4 backdrop-blur-sm"
                                    >
                                        <div class="text-sm text-white/80">
                                            Hours
                                        </div>
                                        <div
                                            class="text-2xl font-bold text-white"
                                        >
                                            36
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute -right-6 -bottom-6 h-32 w-32 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 opacity-20 blur-3xl"
                ></div>
                <div
                    class="absolute -top-6 -left-6 h-32 w-32 rounded-full bg-gradient-to-r from-blue-400 to-cyan-400 opacity-20 blur-3xl"
                ></div>
            </div>
        </div>
    </main>
</template>
