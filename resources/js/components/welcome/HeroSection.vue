<script setup>
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ArrowRight, CheckCircle, TrendingUp, Award, Users } from 'lucide-vue-next';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <section class="relative min-h-dvh overflow-hidden bg-emerald-50 dark:bg-gray-950">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,var(--tw-gradient-stops))] from-emerald-300/40 via-emerald-50 to-white dark:from-emerald-900/40 dark:via-gray-950 dark:to-gray-950"></div>
        <div class="dot-pattern-light absolute inset-0 opacity-[0.04] dark:hidden"></div>
        <div class="dot-pattern-dark absolute inset-0 opacity-[0.03] hidden dark:block"></div>

        <div class="relative mx-auto max-w-7xl px-4 pt-32 sm:px-6 lg:px-8 lg:pt-40">
            <div class="mx-auto max-w-4xl text-center">
                <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-emerald-300 bg-emerald-100 px-4 py-1.5 text-sm font-medium text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                    <CheckCircle class="size-4" />
                    Certified Instructors &bull; 98% Pass Rate
                </div>

                <h1 class="text-balance text-5xl font-bold leading-tight tracking-tight text-gray-900 sm:text-6xl lg:text-7xl xl:text-8xl dark:text-white">
                    Master the Road with
                    <span class="bg-linear-to-r from-emerald-600 to-emerald-500 bg-clip-text text-transparent dark:from-emerald-400 dark:to-emerald-300">Confidence</span>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-balance text-lg leading-relaxed text-gray-600 sm:text-xl dark:text-gray-400">
                    Professional driving lessons tailored to your pace. Get your license faster with certified instructors and modern teaching methods.
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="group inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-lg font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all hover:bg-emerald-500 hover:shadow-emerald-500/30 hover:-translate-y-0.5 dark:bg-emerald-500 dark:shadow-emerald-500/25 dark:hover:bg-emerald-400"
                    >
                        Start Your Driving Journey
                        <ArrowRight class="size-5 transition-transform group-hover:translate-x-0.5" />
                    </Link>
                    <a
                        href="#features"
                        class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 px-8 py-4 text-lg font-semibold text-emerald-800 transition-all hover:bg-emerald-100 dark:border-white/10 dark:text-white/80 dark:hover:border-white/20 dark:hover:bg-white/5 dark:hover:text-white"
                    >
                        View Courses
                    </a>
                </div>

                <div class="mt-16 grid grid-cols-3 gap-8 border-t border-emerald-200 pt-10 dark:border-white/10">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-700 sm:text-4xl dark:text-white">2,500+</div>
                        <div class="mt-1.5 flex items-center justify-center gap-1.5 text-sm text-emerald-600 dark:text-gray-500">
                            <Users class="size-4" />
                            Students Trained
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-700 sm:text-4xl dark:text-white">98%</div>
                        <div class="mt-1.5 flex items-center justify-center gap-1.5 text-sm text-emerald-600 dark:text-gray-500">
                            <TrendingUp class="size-4" />
                            Pass Rate
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-700 sm:text-4xl dark:text-white">15+</div>
                        <div class="mt-1.5 flex items-center justify-center gap-1.5 text-sm text-emerald-600 dark:text-gray-500">
                            <Award class="size-4" />
                            Years Experience
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-px bg-linear-to-r from-transparent via-emerald-400/30 to-transparent dark:via-emerald-500/20"></div>
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
