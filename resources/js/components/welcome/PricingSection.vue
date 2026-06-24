<script setup>
import { Check, Car, Shield, Award } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const plans = [
    {
        name: 'Beginner Course',
        description: 'Perfect for first-time drivers',
        price: 'FREE',
        duration: '6 hours',
        popular: false,
        features: [
            '6 hours of driving instruction',
            'Classroom theory sessions',
            'Basic vehicle controls',
            'Parking practice',
            'Highway introduction',
            'Mock road test',
        ],
        icon: Car,
    },
    {
        name: 'Intermediate Package',
        description: 'Most popular choice',
        price: 'Ksh. 9',
        duration: '24 hours',
        popular: true,
        features: [
            '24 hours of driving instruction',
            'All Beginner Course features',
            'Defensive driving techniques',
            'Night driving practice',
            'Emergency maneuvers',
            'Advanced parking (parallel, angle)',
            'Free road test booking',
        ],
        icon: Shield,
    },
    {
        name: 'Advanced Mastery',
        description: 'Complete driver training',
        price: 'Ksh. 99',
        duration: '1 Month',
        popular: false,
        features: [
            '1 Month of driving instruction',
            'All Intermediate Package features',
            'Extreme weather driving',
            'Commercial vehicle basics',
            'Accident avoidance systems',
            'One-on-one coaching',
            'Lifetime refresher sessions',
        ],
        icon: Award,
    },
];

const props = defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <section id="pricing" class="border-b border-gray-100 bg-white py-20 dark:border-gray-800 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">PRICING</p>
                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    Choose Your Learning Path
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Flexible packages designed for every skill level and budget
                </p>
            </div>

            <div class="mt-16 grid gap-8 lg:grid-cols-3">
                <div
                    v-for="plan in plans"
                    :key="plan.name"
                    :class="[
                        'relative rounded-2xl border bg-white p-8 dark:bg-gray-900',
                        plan.popular
                            ? 'border-emerald-500 ring-1 ring-emerald-500 dark:border-emerald-400'
                            : 'border-gray-200 dark:border-gray-800',
                    ]"
                >
                    <div
                        v-if="plan.popular"
                        class="absolute -top-3 left-1/2 -translate-x-1/2"
                    >
                        <span class="rounded-full bg-emerald-600 px-4 py-1 text-xs font-semibold text-white">
                            MOST POPULAR
                        </span>
                    </div>

                    <div class="mb-6 inline-flex size-12 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                        <component :is="plan.icon" class="size-6 text-emerald-600 dark:text-emerald-400" />
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ plan.name }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ plan.description }}</p>

                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">{{ plan.price }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">/{{ plan.duration }}</span>
                    </div>

                    <ul class="mt-8 space-y-3">
                        <li
                            v-for="feature in plan.features"
                            :key="feature"
                            class="flex items-start gap-3 text-sm"
                        >
                            <Check class="mt-0.5 size-4 shrink-0 text-emerald-500" />
                            <span class="text-gray-600 dark:text-gray-300">{{ feature }}</span>
                        </li>
                    </ul>

                    <Link
                        :href="canRegister ? route('register') : route('login')"
                        :class="[
                            'mt-8 flex w-full items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold transition-all',
                            plan.popular
                                ? 'bg-emerald-600 text-white hover:bg-emerald-500'
                                : 'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700',
                        ]"
                    >
                        {{ canRegister ? 'Get Started' : 'Sign In to Enroll' }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
