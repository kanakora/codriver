<script setup lang="ts">
import { Button } from '../ui/button';
</script>

<template>
    <div class="container mx-auto py-16 lg:py-24">
        <div class="mb-10 lg:mb-14">
            <h2 class="title-header text-4xl">Quick Links</h2>
            <p class="text-muted-foreground">
                Access quick links to our platform
            </p>
        </div>
        <div class="grid grid-cols-4 gap-4">
            <div
                class="grid place-items-center rounded-xl border bg-white py-5"
            >
                <div>
                    <img src="../../../img/hand-icon.png" alt="hand icon" />
                </div>
                <div class="space-y-4 text-center">
                    <div>
                        <h5 class="text-2xl font-bold">Insuarance</h5>
                        <p class="text-muted-foreground">
                            Get more information about insuarance
                        </p>
                    </div>
                    <Button variant="outline">
                        Visit Page
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-external-link-icon lucide-external-link"
                        >
                            <path d="M15 3h6v6" />
                            <path d="M10 14 21 3" />
                            <path
                                d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                    </Button>
                </div>
            </div>
            <div
                class="grid place-items-center rounded-xl border bg-white py-5"
            >
                <div>
                    <img src="../../../img/car-icon.png" alt="car icon" />
                </div>
                <div class="space-y-4 text-center">
                    <div>
                        <h5 class="text-2xl font-bold">Driving School</h5>
                        <p class="text-muted-foreground">
                            Access the platform to learn
                        </p>
                    </div>
                    <Button variant="outline">
                        Visit Page
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-external-link-icon lucide-external-link"
                        >
                            <path d="M15 3h6v6" />
                            <path d="M10 14 21 3" />
                            <path
                                d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                    </Button>
                </div>
            </div>
            <div
                class="grid place-items-center rounded-xl border bg-white py-5"
            >
                <div>
                    <img
                        src="../../../img/contact-icon.png"
                        alt="contact icon"
                    />
                </div>
                <div class="space-y-4 text-center">
                    <div>
                        <h5 class="text-2xl font-bold">Contact Us</h5>
                        <p class="text-muted-foreground">Access the homepage</p>
                    </div>
                    <Button variant="outline">
                        Visit Page
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-external-link-icon lucide-external-link"
                        >
                            <path d="M15 3h6v6" />
                            <path d="M10 14 21 3" />
                            <path
                                d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                    </Button>
                </div>
            </div>
            <div
                class="grid place-items-center rounded-xl border bg-white py-5"
            >
                <div>
                    <img src="../../../img/ship-icon.png" alt="ship icon" />
                </div>
                <div class="space-y-4 text-center">
                    <div>
                        <h5 class="text-2xl font-bold">Duty Calculator</h5>
                        <p class="text-muted-foreground">Access the homepage</p>
                    </div>
                    <Button variant="outline">
                        Visit Page
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-external-link-icon lucide-external-link"
                        >
                            <path d="M15 3h6v6" />
                            <path d="M10 14 21 3" />
                            <path
                                d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"
                            />
                        </svg>
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
