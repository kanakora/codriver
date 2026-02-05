<script setup>
import { Quote, Star } from 'lucide-vue-next';

const testimonials = [
    {
        name: 'Sarah Johnson',
        course: 'Beginner Driving Course',
        rating: 5,
        quote: 'The instructors were incredibly patient and professional. I passed my test on the first try thanks to their thorough training.',
        location: 'Los Angeles, CA',
        avatarColor: 'bg-pink-500',
    },
    {
        name: 'Michael Chen',
        course: 'Defensive Driving',
        rating: 5,
        quote: 'As someone who was nervous about highway driving, the defensive driving course gave me the confidence I needed. Highly recommended!',
        location: 'New York, NY',
        avatarColor: 'bg-blue-500',
    },
    {
        name: 'Jessica Williams',
        course: 'Advanced Maneuvers',
        rating: 5,
        quote: 'The one-on-one instruction helped me master parallel parking and other tricky maneuvers. Worth every penny!',
        location: 'Chicago, IL',
        avatarColor: 'bg-emerald-500',
    },
];
</script>

<template>
    <section class="bg-white py-16 lg:py-24 dark:bg-gray-900">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-12 text-center lg:mb-16">
                <h2
                    class="text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white"
                >
                    What Our Students Say
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Join thousands of satisfied drivers who have mastered the
                    road with DriveSafe
                </p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="testimonial in testimonials"
                    :key="testimonial.name"
                    class="rounded-2xl bg-gray-50 p-8 dark:bg-gray-800"
                >
                    <div class="mb-6">
                        <Quote
                            class="h-10 w-10 text-blue-600 dark:text-blue-400"
                        />
                    </div>
                    <p class="mb-8 text-gray-700 italic dark:text-gray-300">
                        "{{ testimonial.quote }}"
                    </p>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <div
                                :class="[
                                    testimonial.avatarColor,
                                    'h-12 w-12 rounded-full',
                                ]"
                            ></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4
                                    class="font-bold text-gray-900 dark:text-white"
                                >
                                    {{ testimonial.name }}
                                </h4>
                                <div class="flex items-center">
                                    <Star
                                        v-for="i in 5"
                                        :key="i"
                                        class="h-4 w-4"
                                        :class="
                                            i <= testimonial.rating
                                                ? 'fill-yellow-500 text-yellow-500'
                                                : 'text-gray-300 dark:text-gray-600'
                                        "
                                    />
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ testimonial.course }}
                            </p>
                            <p
                                class="mt-1 text-xs text-gray-500 dark:text-gray-500"
                            >
                                {{ testimonial.location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div
                    class="inline-flex items-center rounded-full bg-blue-100 px-6 py-3 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"
                >
                    <Star class="mr-2 h-5 w-5" />
                    <span class="font-medium"
                        >4.9 average rating from 2,500+ reviews</span
                    >
                </div>
            </div>
        </div>
    </section>
</template>
