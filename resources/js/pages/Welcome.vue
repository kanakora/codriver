<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '@/components/welcome/Header.vue';
import HeroSection from '@/components/welcome/HeroSection.vue';
import FeaturesSection from '@/components/welcome/FeaturesSection.vue';
import TestimonialsSection from '@/components/welcome/TestimonialsSection.vue';
import HowItWorksSection from '@/components/welcome/HowItWorksSection.vue';
import PricingSection from '@/components/welcome/PricingSection.vue';
import CTASection from '@/components/welcome/CTASection.vue';
import Footer from '@/components/welcome/Footer.vue';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Head title="DriveSafe Driving School">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="min-h-screen bg-linear-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-950"
    >
        <Header :can-register="canRegister" :auth="$page.props.auth" />
        <HeroSection :can-register="canRegister" />
        <FeaturesSection />
        <HowItWorksSection />
        <PricingSection :can-register="canRegister" />
        <TestimonialsSection />
        <CTASection :can-register="canRegister" />
        <Footer />
    </div>
</template>
