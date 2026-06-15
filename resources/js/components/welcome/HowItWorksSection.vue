<script setup>
import { UserPlus, Calendar, Car, BadgeCheck } from 'lucide-vue-next';

const steps = [
    {
        number: '01',
        title: 'Sign Up',
        description: 'Sign up and create an account with us to gain access to training materials made by our instructors.',
        icon: UserPlus,
    },
    {
        number: '02',
        title: 'Schedule Your Lessons',
        description: 'Choose convenient time slots that fit your schedule. Morning, evening, and weekend options available.',
        icon: Calendar,
    },
    {
        number: '03',
        title: 'Learn with Expert Instructors',
        description: 'Receive one-on-one instruction in modern vehicles equipped with dual controls for safety.',
        icon: Car,
    },
    {
        number: '04',
        title: 'Get Your License',
        description: 'Take your road test with confidence. Our students have a 98% first-time pass rate.',
        icon: BadgeCheck,
    },
];
</script>

<template>
    <section class="border-b border-gray-100 bg-white py-20 dark:border-gray-800 dark:bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">HOW IT WORKS</p>
                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    Four Simple Steps
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    From beginner to licensed driver in just 4 steps
                </p>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="(step, index) in steps"
                    :key="step.number"
                    class="relative text-center"
                >
                    <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-emerald-50 dark:bg-emerald-900/20">
                        <component :is="step.icon" class="size-7 text-emerald-600 dark:text-emerald-400" />
                    </div>

                    <div v-if="index < steps.length - 1" class="absolute top-8 left-[calc(50%+2.5rem)] hidden h-0.5 w-[calc(100%-5rem)] bg-gray-200 lg:block dark:bg-gray-800"></div>

                    <div class="mt-6">
                        <div class="inline-flex size-8 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">
                            {{ step.number }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ step.title }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
