<script setup>
import { UserPlus, Calendar, Car, BadgeCheck } from 'lucide-vue-next';

const steps = [
    {
        number: '01',
        title: 'Sign Up & Assessment',
        description:
            'Create your account and complete a quick driving assessment to determine your starting level.',
        icon: UserPlus,
        color: 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
    },
    {
        number: '02',
        title: 'Schedule Your Lessons',
        description:
            'Choose convenient time slots that fit your schedule. Morning, evening, and weekend options available.',
        icon: Calendar,
        color: 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400',
    },
    {
        number: '03',
        title: 'Learn with Expert Instructors',
        description:
            'Receive one-on-one instruction in modern vehicles equipped with dual controls for safety.',
        icon: Car,
        color: 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
    },
    {
        number: '04',
        title: 'Get Your License',
        description:
            'Take your road test with confidence. Our students have a 98% first-time pass rate.',
        icon: BadgeCheck,
        color: 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400',
    },
];
</script>

<template>
    <section class="bg-gray-50 py-16 lg:py-24 dark:bg-gray-900/50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-12 text-center lg:mb-16">
                <h2
                    class="text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white"
                >
                    How It Works
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Get from beginner to licensed driver in four simple steps
                </p>
            </div>

            <div class="relative">
                <!-- Connecting line for desktop -->
                <div
                    class="absolute top-12 right-0 left-0 hidden h-0.5 bg-gradient-to-r from-blue-500 via-emerald-500 to-amber-500 lg:block"
                ></div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="step in steps"
                        :key="step.number"
                        class="relative rounded-2xl bg-white p-8 text-center dark:bg-gray-800"
                    >
                        <!-- Step number with background -->
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-white bg-gradient-to-br from-blue-600 to-blue-700 text-lg font-bold text-white dark:border-gray-900"
                            >
                                {{ step.number }}
                            </div>
                        </div>

                        <!-- Icon -->
                        <div class="mb-6 flex justify-center">
                            <div
                                :class="[
                                    step.color,
                                    'inline-flex h-16 w-16 items-center justify-center rounded-2xl',
                                ]"
                            >
                                <component :is="step.icon" class="h-8 w-8" />
                            </div>
                        </div>

                        <!-- Content -->
                        <h3
                            class="mb-4 text-xl font-bold text-gray-900 dark:text-white"
                        >
                            {{ step.title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    Most students complete their training and get licensed
                    within
                    <span class="font-bold text-blue-600 dark:text-blue-400"
                        >4-6 weeks</span
                    >.
                </p>
                <div
                    class="mt-6 inline-flex items-center rounded-full bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 text-white"
                >
                    <Calendar class="mr-2 h-5 w-5" />
                    <span class="font-medium"
                        >Flexible scheduling available</span
                    >
                </div>
            </div>
        </div>
    </section>
</template>
