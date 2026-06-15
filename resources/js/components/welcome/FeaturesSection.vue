<script setup>
import { Shield, Calendar, UserCheck, BarChart3, Clock, MapPin } from 'lucide-vue-next';

const features = [
    {
        title: 'Safety First',
        description: 'Defensive driving techniques from certified instructors in modern, well-maintained vehicles.',
        icon: Shield,
    },
    {
        title: 'Flexible Scheduling',
        description: 'Book lessons at your convenience with morning, afternoon, evening, and weekend slots.',
        icon: Calendar,
    },
    {
        title: 'Personalized Instruction',
        description: 'One-on-one training tailored to your learning style and pace with patient instructors.',
        icon: UserCheck,
    },
    {
        title: 'Track Progress',
        description: 'Monitor your improvement with detailed progress reports and skill assessments.',
        icon: BarChart3,
    },
    {
        title: 'Quick Results',
        description: 'Most students complete training and get licensed within 4-6 weeks.',
        icon: Clock,
    },
    {
        title: 'Convenient Locations',
        description: 'Multiple training locations across the city for easy access to lessons.',
        icon: MapPin,
    },
];
</script>

<template>
    <section id="features" class="border-b border-gray-100 bg-gray-50/50 py-20 dark:border-gray-800 dark:bg-gray-900/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">WHY CHOOSE US</p>
                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    Built for Your Success
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    We provide the best learning experience for new drivers
                </p>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="feature in features"
                    :key="feature.title"
                    class="rounded-2xl border border-gray-100 bg-white p-8 transition-all hover:border-gray-200 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
                >
                    <div class="mb-5 inline-flex size-12 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                        <component :is="feature.icon" class="size-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                        {{ feature.title }}
                    </h3>
                    <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                        {{ feature.description }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
