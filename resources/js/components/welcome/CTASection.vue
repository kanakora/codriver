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
    <section class="py-16 lg:py-24">
        <div class="container mx-auto px-4 lg:px-8">
            <div
                class="rounded-3xl bg-gradient-to-r from-blue-600 to-blue-700 p-8 lg:p-16"
            >
                <div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-16">
                    <div>
                        <h2 class="text-3xl font-bold text-white lg:text-4xl">
                            Ready to Start Your Driving Journey?
                        </h2>
                        <p class="mt-4 text-lg text-blue-100">
                            Join thousands of successful drivers who started
                            their journey with DriveSafe. Book your first lesson
                            today!
                        </p>
                        <div class="mt-8">
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="inline-flex items-center rounded-lg bg-white px-8 py-4 text-lg font-semibold text-blue-600 transition-colors hover:bg-gray-100"
                            >
                                Enroll Now
                                <svg
                                    class="ml-2 h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"
                                    />
                                </svg>
                            </Link>
                            <Link
                                v-else
                                :href="route('login')"
                                class="inline-flex items-center rounded-lg bg-white px-8 py-4 text-lg font-semibold text-blue-600 transition-colors hover:bg-gray-100"
                            >
                                Sign In to Continue
                            </Link>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="rounded-xl bg-white/10 p-6 backdrop-blur-sm"
                        >
                            <div class="text-4xl font-bold text-white">
                                100%
                            </div>
                            <div class="mt-2 text-sm text-blue-100">
                                Satisfaction Rate
                            </div>
                        </div>
                        <div
                            class="rounded-xl bg-white/10 p-6 backdrop-blur-sm"
                        >
                            <div class="text-4xl font-bold text-white">
                                24/7
                            </div>
                            <div class="mt-2 text-sm text-blue-100">
                                Support Available
                            </div>
                        </div>
                        <div
                            class="rounded-xl bg-white/10 p-6 backdrop-blur-sm"
                        >
                            <div class="text-4xl font-bold text-white">5.0</div>
                            <div class="mt-2 text-sm text-blue-100">
                                Average Rating
                            </div>
                        </div>
                        <div
                            class="rounded-xl bg-white/10 p-6 backdrop-blur-sm"
                        >
                            <div class="text-4xl font-bold text-white">30+</div>
                            <div class="mt-2 text-sm text-blue-100">
                                Modern Vehicles
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
