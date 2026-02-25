<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';

const props = defineProps<{
    classroom: {
        id: number;
        title: string;
        slug: string;
        description?: string | null;
        is_public: boolean;
        sort_order: number;
        prerequisite?: { id: number; title: string } | null;
        lessons: Array<{
            id: number;
            title: string;
            slug: string;
            description?: string | null;
            content_type: string;
            publish_status: string;
            scheduled_publish_at?: string | null;
            expires_at?: string | null;
            categories?: Array<{ id: number; name: string }>;
        }>;
    };
}>();

const { canManageClassRooms } = useAuthRoles();

function getStatusBadge(content: { publish_status: string; scheduled_publish_at?: string | null; expires_at?: string | null }) {
    const now = new Date();

    if (content.expires_at && new Date(content.expires_at) <= now) {
        return { label: 'Expired', variant: 'destructive' };
    }

    if (content.publish_status === 'published') {
        return { label: 'Active', variant: 'default' };
    }

    if (content.scheduled_publish_at && new Date(content.scheduled_publish_at) > now) {
        return { label: 'Scheduled', variant: 'secondary' };
    }

    return { label: 'Draft', variant: 'outline' };
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Classroom Management',
        href: route('admin.classrooms.index'),
    },
    {
        title: props.classroom.title,
        href: route('admin.classrooms.show', { classroom: props.classroom.id }),
    },
];
</script>

<template>
    <Head :title="classroom.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        {{ classroom.title }}
                    </h1>
                    <p class="text-muted-foreground">
                        {{ classroom.description || 'No description provided.' }}
                    </p>
                </div>
                <div class="flex items-center gap-2" v-if="canManageClassRooms()">
                    <Button variant="outline" as-child>
                        <Link
                            :href="
                                route('admin.classrooms.edit', {
                                    classroom: classroom.id,
                                })
                            "
                        >
                            Edit classroom
                        </Link>
                    </Button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <Card>
                    <CardHeader>
                        <CardTitle>Classrooom's lessons</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div
                            v-for="lesson in classroom.lessons"
                            :key="lesson.id"
                            class="rounded-xl border border-border/60 p-4"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold">
                                        {{ lesson.title }}
                                    </p>
                                    <p class="text-xs text-muted-foreground">
                                        {{ lesson.description || 'No description' }}
                                    </p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <Badge variant="outline">
                                            {{ lesson.content_type }}
                                        </Badge>
                                        <Badge :variant="getStatusBadge(lesson).variant">
                                            {{ getStatusBadge(lesson).label }}
                                        </Badge>
                                        <Badge
                                            v-for="cat in lesson.categories || []"
                                            :key="cat.id"
                                            variant="outline"
                                            class="text-xs"
                                        >
                                            {{ cat.name }}
                                        </Badge>
                                    </div>
                                </div>
                                <Link
                                    :href="
                                        route('admin.lessons.show', {
                                            lesson: lesson.slug,
                                        })
                                    "
                                    class="text-sm font-medium text-primary hover:underline"
                                >
                                    View
                                </Link>
                            </div>
                        </div>
                        <div
                            v-if="classroom.lessons.length === 0"
                            class="rounded-xl border border-dashed border-border/60 p-6 text-center text-sm text-muted-foreground"
                        >
                            No content has been added yet.
                        </div>
                    </CardContent>
                </Card>

                <div class="space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Details</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4 text-sm">
                            <div>
                                <div class="text-muted-foreground">Slug</div>
                                <div class="font-mono text-xs">
                                    {{ classroom.slug }}
                                </div>
                            </div>
                            <div>
                                <div class="text-muted-foreground">Visibility</div>
                                <div>
                                    {{ classroom.is_public ? 'Public' : 'Internal' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-muted-foreground">Sort order</div>
                                <div>{{ classroom.sort_order }}</div>
                            </div>
                            <div v-if="classroom.prerequisite">
                                <div class="text-muted-foreground">
                                    Prerequisite
                                </div>
                                <div>{{ classroom.prerequisite.title }}</div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
