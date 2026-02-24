<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { route } from 'ziggy-js';
import {
    CheckCircle2,
    Clock3,
    FileText,
    Tag,
} from 'lucide-vue-next';

type Props = {
    stats: {
        totalLessons: number;
        publishedLessons: number;
        draftLessons: number;
        categoryCount: number;
    };
    recentLessons: Array<{
        id: number;
        title: string;
        publish_status: 'draft' | 'published';
        created_at: string;
        published_at: string | null;
    }>;
};

const props = defineProps<Props>();

const statCards = [
    {
        label: 'Total Content',
        value: props.stats.totalLessons,
        icon: FileText,
    },
    {
        label: 'Published',
        value: props.stats.publishedLessons,
        icon: CheckCircle2,
    },
    {
        label: 'Drafts',
        value: props.stats.draftLessons,
        icon: Clock3,
    },
    {
        label: 'Categories',
        value: props.stats.categoryCount,
        icon: Tag,
    },
];

function statusBadgeVariant(status: Props['recentLessons'][number]['publish_status']) {
    return status === 'published' ? 'success' : 'warning';
}

const breadcrumbs = [
    {
        title: 'Admin Dashboard',
        href: route('admin.dashboard'),
    },
];
</script>

<template>
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-amber-50 via-white to-emerald-50 p-6 shadow-sm dark:border-border dark:from-slate-900 dark:via-slate-950 dark:to-slate-900"
            >
                <div
                    class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-muted-foreground">
                            Admin overview
                        </p>
                        <h1 class="text-2xl font-semibold tracking-tight">
                            Keep content flowing and organized
                        </h1>
                        <p class="max-w-xl text-sm text-muted-foreground">
                            Review publishing progress, jump into new content,
                            or tidy up categories to keep the learning path
                            clear.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <Button as-child>
                            <Link :href="route('admin.lessons.create')">
                                Create Lesson
                            </Link>
                        </Button>
                        <Button variant="secondary" as-child>
                            <Link :href="route('admin.categories.create')">
                                Add category
                            </Link>
                        </Button>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <Card
                    v-for="stat in statCards"
                    :key="stat.label"
                    class="relative overflow-hidden"
                >
                    <CardHeader class="pb-2">
                        <CardTitle class="text-sm text-muted-foreground">
                            {{ stat.label }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-semibold">
                                {{ stat.value }}
                            </div>
                            <p class="text-xs text-muted-foreground">
                                Updated just now
                            </p>
                        </div>
                        <div
                            class="rounded-full bg-primary/10 p-3 text-primary"
                        >
                            <component :is="stat.icon" class="h-5 w-5" />
                        </div>
                    </CardContent>
                </Card>
            </section>

            <section class="grid gap-4 lg:grid-cols-3">
                <Card class="lg:col-span-2">
                    <CardHeader>
                        <CardTitle>Recent content</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div
                            v-for="lesson in recentLessons"
                            :key="lesson.id"
                            class="flex items-center justify-between gap-4 rounded-lg border border-border/60 p-4"
                        >
                            <div class="space-y-1">
                                <Link
                                    :href="
                                        route('admin.lessons.show', {
                                            lesson: lesson.id,
                                        })
                                    "
                                    class="text-sm font-semibold hover:text-primary"
                                >
                                    {{ lesson.title }}
                                </Link>
                                <p class="text-xs text-muted-foreground">
                                    {{
                                        new Date(
                                            lesson.published_at ??
                                                lesson.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </p>
                            </div>
                            <Badge :variant="statusBadgeVariant(lesson.publish_status)">
                                {{ lesson.publish_status }}
                            </Badge>
                        </div>
                        <div v-if="recentLessons.length === 0" class="text-sm text-muted-foreground">
                            No lesson has been created yet.
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Quick links</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-3">
                        <Link
                            :href="route('admin.lessons.index')"
                            class="flex items-center justify-between rounded-lg border border-border/60 px-4 py-3 text-sm font-medium hover:border-primary/50 hover:text-primary"
                        >
                            Manage lessons
                            <span class="text-xs text-muted-foreground">
                                {{ props.stats.totalLessons }} total
                            </span>
                        </Link>
                        <Link
                            :href="route('admin.categories.index')"
                            class="flex items-center justify-between rounded-lg border border-border/60 px-4 py-3 text-sm font-medium hover:border-primary/50 hover:text-primary"
                        >
                            Manage categories
                            <span class="text-xs text-muted-foreground">
                                {{ props.stats.categoryCount }} total
                            </span>
                        </Link>
                        <Link
                            :href="route('admin.users.index')"
                            class="flex items-center justify-between rounded-lg border border-border/60 px-4 py-3 text-sm font-medium hover:border-primary/50 hover:text-primary"
                        >
                            Manage users
                            <span class="text-xs text-muted-foreground">
                                Role access
                            </span>
                        </Link>
                        <Link
                            :href="route('admin.roles.index')"
                            class="flex items-center justify-between rounded-lg border border-border/60 px-4 py-3 text-sm font-medium hover:border-primary/50 hover:text-primary"
                        >
                            Manage roles
                            <span class="text-xs text-muted-foreground">
                                Permission sets
                            </span>
                        </Link>
                        <Link
                            :href="route('admin.lessons.index')"
                            class="flex items-center justify-between rounded-lg border border-border/60 px-4 py-3 text-sm font-medium hover:border-primary/50 hover:text-primary"
                        >
                            Review lessons
                            <span class="text-xs text-muted-foreground">
                                {{ props.stats.totalLessons }} total
                            </span>
                        </Link>
                    </CardContent>
                </Card>
            </section>
        </div>
    </AppLayout>
</template>
