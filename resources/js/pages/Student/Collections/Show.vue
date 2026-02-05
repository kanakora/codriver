<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';

const props = defineProps<{
    collection: {
        id: number;
        title: string;
        description?: string | null;
        prerequisite?: { id: number; title: string } | null;
        contents: Array<{
            id: number;
            title: string;
            description?: string | null;
            content_type: string;
            published_at?: string | null;
            categories?: Array<{ id: number; name: string }>;
        }>;
    };
}>();

const breadcrumbs = [
    {
        title: 'Student Dashboard',
        href: route('student.dashboard'),
    },
    {
        title: 'Collections',
        href: route('student.collections.index'),
    },
    {
        title: props.collection.title,
        href: route('student.collections.show', {
            collection: props.collection.id,
        }),
    },
];
</script>

<template>
    <Head :title="collection.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-sky-50 via-white to-blue-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <Badge variant="outline">
                            {{ collection.contents.length }} items
                        </Badge>
                        <span
                            v-if="collection.prerequisite"
                            class="text-xs text-muted-foreground"
                        >
                            Prerequisite: {{ collection.prerequisite.title }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ collection.title }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ collection.description || 'No description provided.' }}
                    </p>
                </div>
            </section>

            <Card>
                <CardHeader>
                    <CardTitle>Collection resources</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div
                        v-for="content in collection.contents"
                        :key="content.id"
                        class="rounded-xl border border-border/60 p-4"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold">
                                    {{ content.title }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ content.description || 'No description' }}
                                </p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <Badge variant="outline">
                                        {{ content.content_type }}
                                    </Badge>
                                    <Badge
                                        v-for="cat in content.categories || []"
                                        :key="cat.id"
                                        variant="outline"
                                        class="text-xs"
                                    >
                                        {{ cat.name }}
                                    </Badge>
                                </div>
                            </div>
                            <Button variant="secondary" as-child>
                                <Link
                                    :href="
                                        route('student.contents.show', {
                                            content: content.id,
                                        })
                                    "
                                >
                                    Open
                                </Link>
                            </Button>
                        </div>
                    </div>
                    <div
                        v-if="collection.contents.length === 0"
                        class="rounded-xl border border-dashed border-border/60 p-6 text-center text-sm text-muted-foreground"
                    >
                        No published content is available in this collection yet.
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
