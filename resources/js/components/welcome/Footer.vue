<script setup lang="ts">
import AppLogo from '../AppLogo.vue';

</script>

<template>
    <footer class="border-t border-gray-200 py-8 dark:border-gray-800">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center space-x-2">
                        <AppLogo />
                    </div>
                </div>
                <div class="flex space-x-6">
                    <a
                        href="#"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >Terms</a
                    >
                    <a
                        href="#"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >Privacy</a
                    >
                    <a
                        href="#"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >About</a
                    >
                </div>
            </div>
            <div class="bg-gray-100 px-4 lg:px-8 py-4 mt-10 border flex items-center justify-between">
                <p class="text-xs">
                    Maintained with ❤️ by <a href="https://bretoreta.me/ref=codriver.ke"><b>Bret Oreta</b></a>
                </p>
                <p class="text-sm">
                    &copy; 2026 Codriver. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>
</template>
