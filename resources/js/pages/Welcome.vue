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
import PageLinks from '@/components/welcome/PageLinks.vue';
import { MessageCircle } from 'lucide-vue-next';

defineProps({
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Head title="Codriver Platform">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="min-h-screen bg-linear-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-950"
    >
        <Header :can-register="canRegister" :auth="$page.props.auth" />
        <HeroSection :can-register="canRegister" />
        <PageLinks />
        <!-- <FeaturesSection /> -->
        <!-- <HowItWorksSection /> -->
        <!-- <PricingSection :can-register="canRegister" /> -->
        <!-- <TestimonialsSection /> -->
        <!-- <CTASection :can-register="canRegister" /> -->
        <Footer />

        <!-- Floating WhatsApp Button -->
        <a
            href="https://wa.me/254727514410?text=Hello%2C%20I%20need%20help%20with%20Codriver.ke"
            target="_blank"
            rel="noopener noreferrer"
            class="animate-soft-pulse fixed right-4 bottom-4 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-green-500 shadow-lg transition-all duration-300 hover:scale-110 hover:bg-green-600 hover:shadow-xl focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:outline-none sm:right-6 sm:bottom-6"
            aria-label="Contact us on WhatsApp"
            title="Chat with us on WhatsApp"
        >
            <MessageCircle class="h-7 w-7 text-white" />
        </a>
    </div>
</template>

<style scoped>
@keyframes soft-pulse {
    0%,
    100% {
        box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(72, 187, 120, 0);
    }
}

.animate-soft-pulse {
    animation: soft-pulse 2s infinite;
}
</style>
