<script setup>
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ArrowRight } from 'lucide-vue-next';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <section class="relative overflow-hidden bg-emerald-50 py-20 dark:bg-gray-950">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-emerald-300/30 via-transparent to-transparent dark:from-emerald-900/30"></div>
        <div class="dot-pattern-light absolute inset-0 opacity-[0.04] dark:hidden"></div>
        <div class="dot-pattern-dark absolute inset-0 opacity-[0.02] hidden dark:block"></div>

        <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl dark:text-white">
                Ready to Start Your Driving Journey?
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-400">
                Join thousands of successful drivers who started their journey with Codriver. Book your first lesson today!
            </p>

            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="group inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:-translate-y-0.5 dark:bg-emerald-500 dark:shadow-emerald-500/25 dark:hover:bg-emerald-400"
                >
                    Enroll Now
                    <ArrowRight class="size-5 transition-transform group-hover:translate-x-0.5" />
                </Link>
                <Link
                    v-else
                    :href="route('login')"
                    class="group inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:-translate-y-0.5 dark:bg-emerald-500 dark:shadow-emerald-500/25 dark:hover:bg-emerald-400"
                >
                    Sign In to Continue
                    <ArrowRight class="size-5 transition-transform group-hover:translate-x-0.5" />
                </Link>
                <Link
                    :href="route('contact')"
                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 px-8 py-4 text-lg font-semibold text-emerald-800 transition-all hover:bg-emerald-100 dark:border-white/10 dark:text-white/80 dark:hover:border-white/20 dark:hover:bg-white/5 dark:hover:text-white"
                >
                    Contact Us
                </Link>
            </div>

            <div class="mt-16 grid grid-cols-2 gap-6 sm:grid-cols-4">
                <div class="rounded-xl border border-emerald-200 p-6 dark:border-white/10">
                    <div class="text-3xl font-bold text-emerald-700 dark:text-white">100%</div>
                    <div class="mt-1 text-sm text-emerald-600 dark:text-gray-500">Satisfaction Rate</div>
                </div>
                <div class="rounded-xl border border-emerald-200 p-6 dark:border-white/10">
                    <div class="text-3xl font-bold text-emerald-700 dark:text-white">24/7</div>
                    <div class="mt-1 text-sm text-emerald-600 dark:text-gray-500">Support Available</div>
                </div>
                <div class="rounded-xl border border-emerald-200 p-6 dark:border-white/10">
                    <div class="text-3xl font-bold text-emerald-700 dark:text-white">5.0</div>
                    <div class="mt-1 text-sm text-emerald-600 dark:text-gray-500">Average Rating</div>
                </div>
                <div class="rounded-xl border border-emerald-200 p-6 dark:border-white/10">
                    <div class="text-3xl font-bold text-emerald-700 dark:text-white">30+</div>
                    <div class="mt-1 text-sm text-emerald-600 dark:text-gray-500">Modern Vehicles</div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.dot-pattern-light {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23059869' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.dot-pattern-dark {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>
