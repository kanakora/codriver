<script setup>
import FeatureCard from './FeatureCard.vue';
</script>

<template>
    <section
        id="features"
        class="bg-gray-50 py-16 lg:py-24 dark:bg-gray-900/50"
    >
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-12 text-center lg:mb-16">
                <h2
                    class="text-3xl font-bold text-gray-900 lg:text-4xl dark:text-white"
                >
                    Why Choose DriveSafe?
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    We provide the best learning experience for new drivers
                </p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <FeatureCard
                    title="Safety First"
                    description="Our top priority is your safety. Learn defensive driving techniques from certified instructors in modern, well-maintained vehicles."
                >
                    <template #icon>
                        <svg
                            class="h-8 w-8 text-blue-600 dark:text-blue-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                            />
                        </svg>
                    </template>
                </FeatureCard>

                <FeatureCard
                    title="Flexible Scheduling"
                    description="Book lessons at your convenience. We offer morning, afternoon, evening, and weekend slots to fit your busy schedule."
                >
                    <template #icon>
                        <svg
                            class="h-8 w-8 text-blue-600 dark:text-blue-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </template>
                </FeatureCard>

                <FeatureCard
                    title="Personalized Instruction"
                    description="One-on-one training tailored to your learning style and pace. Build confidence with patient, experienced instructors."
                >
                    <template #icon>
                        <svg
                            class="h-8 w-8 text-blue-600 dark:text-blue-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </template>
                </FeatureCard>
            </div>
        </div>
    </section>
</template>
