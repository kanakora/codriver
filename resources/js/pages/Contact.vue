<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, MapPin, Phone, Send, User, ArrowLeft } from 'lucide-vue-next';
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
    <Head title="Contact Us" />

    <div class="min-h-screen bg-white dark:bg-gray-950">
        <Header :can-register="$page.props.canRegister" :auth="$page.props.auth" />

        <main class="mx-auto max-w-7xl px-4 pt-32 pb-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-semibold tracking-wide text-emerald-600 dark:text-emerald-400">CONTACT</p>
                <h1 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                    Get in Touch
                </h1>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">
                    Have questions about our driving school platform? We're here to help.
                </p>
            </div>

            <div class="mx-auto mt-16 grid max-w-5xl gap-12 lg:grid-cols-5">
                <div class="space-y-8 lg:col-span-2">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                                <Mail class="size-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Email</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">support@codriver.ke</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Typically respond within 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                                <Phone class="size-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Phone</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">+254 701 232 309</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Mon-Fri from 8am to 6pm</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20">
                                <MapPin class="size-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Location</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nairobi, Kenya</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Serving driving schools nationwide</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-100 bg-gray-50/50 p-6 dark:border-gray-800 dark:bg-gray-900/30">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Quick Support</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            For urgent matters, please call our support line.
                        </p>
                        <Link
                            :href="route('home')"
                            class="mt-4 inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 transition-colors hover:text-emerald-500 dark:text-emerald-400"
                        >
                            <ArrowLeft class="size-4" />
                            Return to home
                        </Link>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-800 dark:bg-gray-900">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Send us a message</h2>

                        <Alert v-if="$page.props.flash?.success" class="mt-6 bg-emerald-50 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-300">
                            <AlertDescription>{{ $page.props.flash.success }}</AlertDescription>
                        </Alert>

                        <form @submit.prevent="submit" class="mt-8 space-y-5">
                            <div class="space-y-1.5">
                                <Label for="name">Full Name</Label>
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

                            <div class="space-y-1.5">
                                <Label for="email">Email Address</Label>
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

                            <div class="space-y-1.5">
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
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    Please include as much detail as possible so we can help you better.
                                </p>
                            </div>

                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full"
                            >
                                <Send class="mr-2 size-4" />
                                <span v-if="form.processing">Sending...</span>
                                <span v-else>Send Message</span>
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
