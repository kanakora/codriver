<script setup>
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

defineProps({
    breadcrumbs: {
        type: Array,
        default: () => []
    }
})

const { resolvedAppearance, updateAppearance } = useAppearance();

const toggleAppearance = () => {
    updateAppearance(resolvedAppearance.value === 'dark' ? 'light' : 'dark');
};
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
        <div class="flex items-center gap-2">
            <button
                @click="toggleAppearance"
                class='relative flex size-9 items-center justify-center rounded-lg transition-colors overflow-hidden text-gray-700 hover:bg-gray-900/5 dark:text-white/70 dark:hover:bg-white/10 dark:hover:text-white'
                :aria-label="resolvedAppearance === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
            >
                <Sun
                    :class="[
                        'size-4 absolute transition-all duration-500',
                        resolvedAppearance === 'light' ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 rotate-90 scale-75',
                    ]"
                />
                <Moon
                    :class="[
                        'size-4 absolute transition-all duration-500',
                        resolvedAppearance === 'dark' ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 -rotate-90 scale-75',
                    ]"
                />
            </button>
        </div>
    </header>
</template>
