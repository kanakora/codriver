<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';

const props = defineProps<{
    classroom: {
        id: number;
        title: string;
        description?: string | null;
        prerequisite?: { id: number; title: string } | null;
        lessons: Array<{
            id: number;
            title: string;
            slug: string;
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
        title: 'Classrooms',
        href: route('student.classrooms.index'),
    },
    {
        title: props.classroom.title,
        href: route('student.classrooms.show', {
            classroom: props.classroom.id,
        }),
    },
];
</script>

<template>
    <Head :title="classroom.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-sky-50 via-white to-blue-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <Badge variant="outline">
                            {{ classroom.lessons.length }} items
                        </Badge>
                        <span
                            v-if="classroom.prerequisite"
                            class="text-xs text-muted-foreground"
                        >
                            Prerequisite: {{ classroom.prerequisite.title }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ classroom.title }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ classroom.description || 'No description provided.' }}
                    </p>
                </div>
            </section>

            <Card>
                <CardHeader>
                    <CardTitle>Class resources</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div
                        v-for="content in classroom.lessons"
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
                                        route('student.lessons.show', {
                                            classroom: classroom.id,
                                            lesson: content.slug,
                                        })
                                    "
                                >
                                    Open
                                </Link>
                            </Button>
                        </div>
                    </div>
                    <div
                        v-if="classroom.lessons.length === 0"
                        class="rounded-xl border border-dashed border-border/60 p-6 text-center text-sm text-muted-foreground"
                    >
                        No published content is available in this classroom yet.
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
