<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';
import { BookOpen, GraduationCap } from 'lucide-vue-next';

type Props = {
    stats: {
        publishedCount: number;
        categoryCount: number;
    };
    latestLessons: Array<{
        id: number;
        title: string;
        content_type: 'text' | 'pdf' | 'video' | 'link';
        published_at: string | null;
    }>;
};

const props = defineProps<Props>();

const breadcrumbs = [
    {
        title: 'Student Dashboard',
        href: route('student.dashboard'),
    },
];
</script>

<template>
    <Head title="Student Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-blue-50 via-white to-sky-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div
                    class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-muted-foreground">
                            Welcome back
                        </p>
                        <h1 class="text-2xl font-semibold tracking-tight">
                            Your learning dashboard
                        </h1>
                        <p class="text-sm text-muted-foreground">
                            Jump back into your latest lessons or explore the
                            full library curated for you.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <Button as-child>
                            <Link :href="route('student.lessons.index')">
                                Browse courses
                            </Link>
                        </Button>
                        <Button variant="secondary" as-child>
                            <Link :href="route('appearance.edit')">
                                Appearance settings
                            </Link>
                        </Button>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-2">
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm text-muted-foreground">
                            Published lessons
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-semibold">
                                {{ props.stats.publishedCount }}
                            </div>
                            <p class="text-xs text-muted-foreground">
                                Ready to learn
                            </p>
                        </div>
                        <div
                            class="rounded-full bg-primary/10 p-3 text-primary"
                        >
                            <BookOpen class="h-5 w-5" />
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm text-muted-foreground">
                            Categories available
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-semibold">
                                {{ props.stats.categoryCount }}
                            </div>
                            <p class="text-xs text-muted-foreground">
                                Topics to explore
                            </p>
                        </div>
                        <div
                            class="rounded-full bg-primary/10 p-3 text-primary"
                        >
                            <GraduationCap class="h-5 w-5" />
                        </div>
                    </CardContent>
                </Card>
            </section>

            <Card>
                <CardHeader>
                    <CardTitle>Latest lessons</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div
                        v-for="lesson in latestLessons"
                        :key="lesson.id"
                        class="flex items-center justify-between gap-4 rounded-lg border border-border/60 p-4"
                    >
                        <div class="space-y-1">
                            <Link
                                :href="
                                    route('student.lessons.show', {
                                        lesson: lesson.id,
                                    })
                                "
                                class="text-sm font-semibold hover:text-primary"
                            >
                                {{ lesson.title }}
                            </Link>
                            <p class="text-xs text-muted-foreground">
                                {{
                                    lesson.published_at
                                        ? new Date(
                                              lesson.published_at,
                                          ).toLocaleDateString()
                                        : 'Recently added'
                                }}
                            </p>
                        </div>
                        <Badge variant="outline">
                            {{ lesson.content_type }}
                        </Badge>
                    </div>
                    <div
                        v-if="latestLessons.length === 0"
                        class="text-sm text-muted-foreground"
                    >
                        No lessons published yet.
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
