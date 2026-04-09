<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, MapPin, Phone, Send, User } from 'lucide-vue-next';
import Header from '@/components/welcome/Header.vue';
import Footer from '@/components/welcome/Footer.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { Alert, AlertDescription } from '@/components/ui/alert';

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post(route('contact.send'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Contact Us">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-linear-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-950">
        <Header :can-register="$page.props.canRegister" :auth="$page.props.auth" />
        
        <main class="container mx-auto px-4 py-16">
            <!-- Page Header -->
            <div class="lg:mx-auto max-w-3xl lg:text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    Get in Touch
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    Have questions about our driving school platform? We're here to help. 
                    Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <div class="mx-auto mt-16 grid max-w-7xl gap-12 lg:grid-cols-2 lg:gap-16">
                <!-- Contact Information -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                            Contact Information
                        </h2>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">
                            Reach out to us through any of the channels below or fill out the contact form.
                        </p>
                    </div>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                                <Mail class="size-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">Email</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-300">support@codriver.ke</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Typically respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                <Phone class="size-6 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">Phone</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-300">+254 701 232 309</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Mon-Fri from 8am to 6pm</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                <MapPin class="size-6 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">Location</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-300">Nairobi, Kenya</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Serving driving schools nationwide</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="font-medium text-gray-900 dark:text-white">Quick Support</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            For urgent matters, please call our support line. For platform access issues, 
                            include your username or email in your message.
                        </p>
                        <Link 
                            :href="route('home')" 
                            class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400"
                        >
                            Return to home
                        </Link>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg dark:border-gray-800 dark:bg-gray-900">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Send us a message</h2>
                    
                    <Alert v-if="$page.props.flash?.success" class="mt-6 bg-green-50 dark:bg-green-900/20">
                        <AlertDescription class="text-green-800 dark:text-green-300">
                            {{ $page.props.flash.success }}
                        </AlertDescription>
                    </Alert>

                    <form @submit.prevent="submit" class="mt-8 space-y-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <Label for="name" class="flex items-center gap-2">
                                <User class="size-4" />
                                Full Name
                            </Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="John Doe"
                                :disabled="form.processing"
                            />
                            <p v-if="form.errors.name" class="text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <Label for="email" class="flex items-center gap-2">
                                <Mail class="size-4" />
                                Email Address
                            </Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                placeholder="john@example.com"
                                :disabled="form.processing"
                            />
                            <p v-if="form.errors.email" class="text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Message -->
                        <div class="space-y-2">
                            <Label for="message">Message</Label>
                            <Textarea
                                id="message"
                                v-model="form.message"
                                required
                                placeholder="Tell us how we can help you..."
                                rows="6"
                                :disabled="form.processing"
                                class="min-h-37.5"
                            />
                            <p v-if="form.errors.message" class="text-sm text-red-600 dark:text-red-400">
                                {{ form.errors.message }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Please include as much detail as possible so we can help you better.
                            </p>
                        </div>

                        <!-- Submit -->
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full"
                        >
                            <Send class="mr-2 size-4" />
                            <span v-if="form.processing">Sending...</span>
                            <span v-else>Send Message</span>
                        </Button>

                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                            By contacting us, you agree to our 
                            <Link :href="route('home')" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                Privacy Policy
                            </Link>.
                        </p>
                    </form>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>