<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';
import type { Content } from '@/types';

const props = defineProps<{
    classroom: {
        id: number;
        title: string;
        description?: string | null;
        prerequisite?: { id: number; title: string } | null;
    };
    lesson: Content & {
        author?: { name: string };
        categories?: Array<{ id: number; name: string }>;
    };
}>();

function getContentTypeBadgeVariant(type: Content['content_type']) {
    switch (type) {
        case 'text':
            return 'default';
        case 'pdf':
            return 'secondary';
        case 'video':
            return 'outline';
        case 'link':
            return 'destructive';
        default:
            return 'default';
    }
}

const breadcrumbs = [
    {
        title: 'Student Dashboard',
        href: route('student.dashboard'),
    },
    {
        title: 'Content Library',
        href: route('student.lessons.index', { classroom: props.classroom.id }),
    },
    {
        title: props.lesson.title,
        href: route('student.lessons.show', {
            classroom: props.classroom.id,
            lesson: props.lesson.id,
        }),
    },
];
</script>

<template>
    <Head :title="lesson.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-blue-50 via-white to-sky-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <Badge
                            :variant="
                                getContentTypeBadgeVariant(lesson.content_type)
                            "
                        >
                            {{ lesson.content_type }}
                        </Badge>
                        <span class="text-xs text-muted-foreground">
                            By {{ lesson.author?.name || 'Unknown' }}
                        </span>
                        <span class="text-xs text-muted-foreground">
                            {{
                                lesson.published_at
                                    ? new Date(
                                          lesson.published_at,
                                      ).toLocaleDateString()
                                    : 'Recently added'
                            }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ lesson.title }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ lesson.description || 'No description provided.' }}
                    </p>
                </div>
            </section>

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <Card>
                    <CardHeader>
                        <CardTitle>Lesson content</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div
                            v-if="
                                lesson.content_type === 'text' &&
                                lesson.content_text
                            "
                            class="prose max-w-none dark:prose-invert"
                            v-html="lesson.content_text"
                        ></div>

                        <div
                            v-if="
                                lesson.content_type === 'pdf' &&
                                lesson.file_path
                            "
                            class="rounded-lg border border-border/60 p-4"
                        >
                            <h3 class="text-sm font-semibold">PDF Document</h3>
                            <p class="mt-1 text-sm text-muted-foreground">
                                Open the PDF in a new tab to read or download.
                            </p>
                            <Button as-child class="mt-4">
                                <a
                                    :href="`/storage/${lesson.file_path}`"
                                    target="_blank"
                                >
                                    View PDF
                                </a>
                            </Button>
                        </div>

                        <div
                            v-if="
                                lesson.content_type === 'video' &&
                                lesson.external_url
                            "
                            class="rounded-lg border border-border/60 p-4"
                        >
                            <h3 class="text-sm font-semibold">Video lesson</h3>
                            <p class="mt-1 text-sm text-muted-foreground">
                                Watch the lesson using the link below.
                            </p>
                            <Button variant="secondary" as-child class="mt-4">
                                <a :href="lesson.external_url" target="_blank">
                                    Watch video
                                </a>
                            </Button>
                        </div>

                        <div
                            v-if="
                                lesson.content_type === 'link' &&
                                lesson.external_url
                            "
                            class="rounded-lg border border-border/60 p-4"
                        >
                            <h3 class="text-sm font-semibold">External link</h3>
                            <p class="mt-1 text-sm text-muted-foreground">
                                Visit the resource to continue learning.
                            </p>
                            <Button variant="secondary" as-child class="mt-4">
                                <a :href="lesson.external_url" target="_blank">
                                    Open resource
                                </a>
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <div class="space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Lesson details</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4 text-sm">
                            <div>
                                <div class="text-muted-foreground">Created</div>
                                <div>
                                    {{
                                        new Date(
                                            lesson.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </div>
                            </div>
                            <div>
                                <div class="text-muted-foreground">
                                    Published
                                </div>
                                <div>
                                    {{
                                        lesson.published_at
                                            ? new Date(
                                                  lesson.published_at,
                                              ).toLocaleDateString()
                                            : 'Not published'
                                    }}
                                </div>
                            </div>
                            <div>
                                <div class="text-muted-foreground">
                                    Last updated
                                </div>
                                <div>
                                    {{
                                        new Date(
                                            lesson.updated_at,
                                        ).toLocaleDateString()
                                    }}
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Categories</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex flex-wrap gap-2">
                                <Badge
                                    v-for="cat in lesson.categories"
                                    :key="cat.id"
                                    variant="outline"
                                >
                                    {{ cat.name }}
                                </Badge>
                                <span
                                    v-if="!lesson.categories?.length"
                                    class="text-sm text-muted-foreground"
                                >
                                    No categories assigned
                                </span>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
