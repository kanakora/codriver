<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { Switch } from '@/components/ui/switch';
import { computed } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

const { resolvedAppearance, updateAppearance } = useAppearance();
const isDark = computed(() => resolvedAppearance.value === 'dark');

const toggleAppearance = (value: boolean | null) => {
    updateAppearance(value ? 'dark' : 'light');
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
            <span class="text-xs text-muted-foreground">Dark mode</span>
            <Switch
                :model-value="isDark"
                @update:modelValue="toggleAppearance"
                aria-label="Toggle dark mode"
            />
        </div>
    </header>
</template>
