<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
    <AppContent
        variant="sidebar"
        class="overflow-x-hidden bg-gradient-to-br from-blue-50/70 via-white to-slate-50 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
    >
        <AppSidebarHeader :breadcrumbs="breadcrumbs" />
        <slot />
    </AppContent>
    </AppShell>
</template>
