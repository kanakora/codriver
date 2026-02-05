<script setup>
import { Check, X, Car, Shield, Clock, Award } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const plans = [
    {
        name: 'Beginner Course',
        description: 'Perfect for first-time drivers',
        price: '$499',
        duration: '6 weeks',
        popular: false,
        features: [
            '10 hours of driving instruction',
            'Classroom theory sessions',
            'Basic vehicle controls',
            'Parking practice',
            'Highway introduction',
            'Mock road test',
        ],
        icon: Car,
        color: 'bg-blue-600',
    },
    {
        name: 'Intermediate Package',
        description: 'Most popular choice',
        price: '$799',
        duration: '8 weeks',
        popular: true,
        features: [
            '20 hours of driving instruction',
            'All Beginner Course features',
            'Defensive driving techniques',
            'Night driving practice',
            'Emergency maneuvers',
            'Advanced parking (parallel, angle)',
            'Free road test booking',
        ],
        icon: Shield,
        color: 'bg-emerald-600',
    },
    {
        name: 'Advanced Mastery',
        description: 'Complete driver training',
        price: '$1,199',
        duration: '12 weeks',
        popular: false,
        features: [
            '30 hours of driving instruction',
            'All Intermediate Package features',
            'Extreme weather driving',
            'Commercial vehicle basics',
            'Accident avoidance systems',
            'One-on-one coaching',
            'Lifetime refresher sessions',
        ],
        icon: Award,
        color: 'bg-purple-600',
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
    <section class="bg-white py-16 lg:py-24 dark:bg-gray-900">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-12 text-center lg:mb-16">
                <h2
                    class="text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white"
                >
                    Choose Your Learning Path
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Flexible packages designed for every skill level and budget
                </p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="plan in plans"
                    :key="plan.name"
                    :class="[
                        'relative rounded-2xl p-8',
                        plan.popular
                            ? 'ring-2 ring-emerald-500 dark:ring-emerald-400'
                            : 'border border-gray-200 dark:border-gray-800',
                    ]"
                >
                    <!-- Popular badge -->
                    <div
                        v-if="plan.popular"
                        class="absolute -top-3 left-1/2 -translate-x-1/2"
                    >
                        <span
                            class="rounded-full bg-emerald-600 px-6 py-1.5 text-sm font-bold text-white"
                        >
                            MOST POPULAR
                        </span>
                    </div>

                    <!-- Plan header -->
                    <div class="mb-8 text-center">
                        <div
                            :class="[
                                plan.color,
                                'inline-flex h-16 w-16 items-center justify-center rounded-full',
                            ]"
                        >
                            <component
                                :is="plan.icon"
                                class="h-8 w-8 text-white"
                            />
                        </div>
                        <h3
                            class="mt-6 text-2xl font-bold text-gray-900 dark:text-white"
                        >
                            {{ plan.name }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ plan.description }}
                        </p>
                        <div class="mt-6">
                            <div
                                class="text-5xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ plan.price }}
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ plan.duration }} program
                            </div>
                        </div>
                    </div>

                    <!-- Features list -->
                    <div class="mb-8 space-y-4">
                        <div
                            v-for="feature in plan.features"
                            :key="feature"
                            class="flex items-start"
                        >
                            <Check
                                class="mr-3 h-5 w-5 shrink-0 text-emerald-500"
                            />
                            <span class="text-gray-700 dark:text-gray-300">{{
                                feature
                            }}</span>
                        </div>
                    </div>

                    <!-- CTA button -->
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        :class="[
                            'w-full rounded-lg p-4 text-center font-bold transition-colors',
                            plan.popular
                                ? 'bg-emerald-600 text-white hover:bg-emerald-700'
                                : 'bg-blue-600 text-white hover:bg-blue-700',
                        ]"
                    >
                        {{
                            plan.popular
                                ? 'Get Started Today'
                                : 'Choose This Plan'
                        }}
                    </Link>
                    <Link
                        v-else
                        :href="route('login')"
                        :class="[
                            'w-full rounded-lg py-4 text-center font-bold transition-colors',
                            plan.popular
                                ? 'bg-emerald-600 text-white hover:bg-emerald-700'
                                : 'bg-blue-600 text-white hover:bg-blue-700',
                        ]"
                    >
                        Sign In to Enroll
                    </Link>
                </div>
            </div>

            <div
                class="mt-16 rounded-2xl bg-linear-to-r from-blue-600 to-blue-700 p-8"
            >
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <h3 class="text-2xl font-bold text-white">
                            Not sure which plan is right for you?
                        </h3>
                        <p class="mt-2 text-blue-100">
                            Schedule a free consultation with one of our
                            instructors. We'll assess your current skills and
                            recommend the perfect training plan.
                        </p>
                    </div>
                    <div class="text-center lg:text-right">
                        <Link
                            :href="route('register')"
                            v-if="canRegister"
                            class="inline-flex items-center rounded-lg bg-white px-8 py-4 text-lg font-bold text-blue-600 transition-colors hover:bg-gray-100"
                        >
                            <Clock class="mr-2 h-5 w-5" />
                            Book Free Consultation
                        </Link>
                        <Link
                            :href="route('login')"
                            v-else
                            class="inline-flex items-center rounded-lg bg-white px-8 py-4 text-lg font-bold text-blue-600 transition-colors hover:bg-gray-100"
                        >
                            Sign In to Schedule
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
