<script setup>
import { Star } from 'lucide-vue-next';

const testimonials = [
    {
        name: 'Sarah Johnson',
        role: 'Beginner Driving Course',
        rating: 5,
        quote: 'The instructors were incredibly patient and professional. I passed my test on the first try thanks to their thorough training.',
        initials: 'SJ',
    },
    {
        name: 'Michael Chen',
        role: 'Defensive Driving',
        rating: 5,
        quote: 'As someone who was nervous about highway driving, the defensive driving course gave me the confidence I needed. Highly recommended!',
        initials: 'MC',
    },
    {
        name: 'Jessica Williams',
        role: 'Advanced Maneuvers',
        rating: 5,
        quote: 'The one-on-one instruction helped me master parallel parking and other tricky maneuvers. Worth every penny!',
        initials: 'JW',
    },
];
</script>

<template>
    <section class="border-b border-gray-100 bg-gray-50/50 py-20 dark:border-gray-800 dark:bg-gray-900/30">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">TESTIMONIALS</p>
                <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    What Our Students Say
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Join thousands of satisfied drivers who mastered the road with us
                </p>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="testimonial in testimonials"
                    :key="testimonial.name"
                    class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-800 dark:bg-gray-900"
                >
                    <div class="flex items-center gap-0.5">
                        <Star
                            v-for="i in 5"
                            :key="i"
                            :class="[
                                'size-4',
                                i <= testimonial.rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200 dark:fill-gray-700 dark:text-gray-700',
                            ]"
                        />
                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                        "{{ testimonial.quote }}"
                    </p>

                    <div class="mt-6 flex items-center gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                        <div class="flex size-10 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            {{ testimonial.initials }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ testimonial.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ testimonial.role }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-5 py-2 text-sm font-medium text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                    <Star class="size-4 fill-yellow-400 text-yellow-400" />
                    4.9 average rating from 2,500+ reviews
                </div>
            </div>
        </div>
    </section>
</template>
