<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { route } from 'ziggy-js';

const props = defineProps<{
    classrooms: {
        data: Array<{
            id: number;
            title: string;
            description?: string | null;
            contents_count: number;
            prerequisite?: { id: number; title: string } | null;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');

const debouncedSearch = useDebounceFn(() => {
    router.get(
        route('student.classrooms.index'),
        { search: search.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

watch(search, () => {
    debouncedSearch();
});

const breadcrumbs = [
    {
        title: 'Student Dashboard',
        href: route('student.dashboard'),
    },
    {
        title: 'Classrooms',
        href: route('student.classrooms.index'),
    },
];
</script>

<template>
    <Head title="Classrooms" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-sky-50 via-white to-blue-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div class="space-y-2">
                    <p class="text-sm font-medium text-muted-foreground">
                        Learning paths
                    </p>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Follow curated classrooms
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Explore grouped lessons built to guide your learning.
                    </p>
                </div>
            </section>

            <Card>
                <CardHeader>
                    <CardTitle>Find a collection</CardTitle>
                </CardHeader>
                <CardContent class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="search">Search</Label>
                        <Input
                            id="search"
                            v-model="search"
                            placeholder="Search by title or description..."
                            type="search"
                        />
                    </div>
                    <div class="hidden items-end md:flex">
                        <div class="text-sm text-muted-foreground">
                            {{ classrooms.total }} classrooms
                        </div>
                    </div>
                </CardContent>
            </Card>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <Card
                    v-for="classroom in classrooms.data"
                    :key="classroom.id"
                    class="flex h-full flex-col"
                >
                    <CardHeader class="space-y-3">
                        <div class="flex items-center justify-between">
                            <Badge variant="outline">
                                {{ classroom.contents_count }} items
                            </Badge>
                            <span
                                v-if="classroom.prerequisite"
                                class="text-xs text-muted-foreground"
                            >
                                Requires {{ classroom.prerequisite.title }}
                            </span>
                        </div>
                        <div>
                            <Link
                                :href="
                                    route('student.classrooms.show', {
                                        classroom: classroom.id,
                                    })
                                "
                                class="text-lg font-semibold hover:text-primary"
                            >
                                {{ classroom.title }}
                            </Link>
                            <p class="mt-1 text-sm text-muted-foreground">
                                {{ classroom.description || 'No description' }}
                            </p>
                        </div>
                    </CardHeader>
                    <CardContent class="mt-auto">
                        <Link
                            :href="
                                route('student.classrooms.show', {
                                    classroom: classroom.id,
                                })
                            "
                            class="text-sm font-medium text-primary hover:underline"
                        >
                            Open classroom
                        </Link>
                    </CardContent>
                </Card>
            </div>

            <Card v-if="classrooms.data.length === 0">
                <CardContent class="py-12 text-center text-muted-foreground">
                    No classrooms available yet.
                </CardContent>
            </Card>

            <div class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Showing {{ classrooms.from }} to {{ classrooms.to }} of
                    {{ classrooms.total }} results
                </div>
                <div class="flex gap-2">
                    <template
                        v-for="link in classrooms.links"
                        :key="link.label"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="rounded-md px-3 py-2 text-sm font-medium"
                            :class="
                                link.active
                                    ? 'bg-primary text-primary-foreground'
                                    : 'bg-background hover:bg-accent'
                            "
                            preserve-state
                            preserve-scroll
                        >
                            <span v-html="link.label" />
                        </Link>
                        <span
                            v-else
                            class="px-3 py-2 text-muted-foreground"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
