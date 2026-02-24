<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';
import type { Lesson } from '@/types';

const props = defineProps<{
    lesson: Lesson & {
        author?: { name: string };
        categories?: Array<{ id: number; name: string }>;
    };
    revisions?: Array<{
        id: number;
        data: Record<string, unknown>;
        created_at: string;
        user?: { name: string };
    }>;
}>();

const { canManageLessons } = useAuthRoles();

function handleDelete() {
    if (confirm(`Are you sure you want to delete "${props.lesson.title}"?`)) {
        router.delete(
            route('admin.lessons.destroy', { content: props.lesson.id }),
        );
    }
}

function getLessonTypeBadgeVariant(type: Lesson['content_type']) {
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

function getPublishStatusBadgeVariant(status: Lesson['publish_status']) {
    switch (status) {
        case 'published':
            return 'default';
        case 'draft':
            return 'outline';
        default:
            return 'default';
    }
}

const revisionFields = [
    { key: 'title', label: 'Title' },
    { key: 'slug', label: 'Slug' },
    { key: 'description', label: 'Description' },
    { key: 'content_type', label: 'Lesson type' },
    { key: 'content_text', label: 'Lesson text' },
    { key: 'external_url', label: 'External URL' },
    { key: 'publish_status', label: 'Publish status' },
    { key: 'published_at', label: 'Published at' },
    { key: 'scheduled_publish_at', label: 'Scheduled publish' },
    { key: 'expires_at', label: 'Expires at' },
    { key: 'archived_at', label: 'Archived at' },
];

const selectedRevisionId = ref(props.revisions?.[0]?.id ?? null);

const selectedRevision = computed(() => {
    return (
        props.revisions?.find(
            (revision) => revision.id === selectedRevisionId.value,
        ) || null
    );
});

function formatDate(value?: string | null) {
    if (!value) {
        return '—';
    }

    return new Date(value).toLocaleString();
}

function formatValue(value: unknown) {
    if (value === null || value === undefined || value === '') {
        return '—';
    }

    if (Array.isArray(value)) {
        return value.length ? value.join(', ') : '—';
    }

    return String(value);
}

function getCurrentValue(key: string) {
    const value = (props.lesson as Record<string, unknown>)[key];

    if (key.endsWith('_at')) {
        return formatDate(value as string | null);
    }

    return formatValue(value);
}

function getRevisionValue(key: string) {
    const data = selectedRevision.value?.data as
        | Record<string, unknown>
        | undefined;
    const value = data ? data[key] : null;

    if (key.endsWith('_at')) {
        return formatDate(value as string | null);
    }

    return formatValue(value);
}

function valuesDiffer(key: string) {
    const current = getCurrentValue(key);
    const revision = getRevisionValue(key);

    return current !== revision;
}

function restoreRevision(revisionId: number) {
    if (
        !confirm(
            'Restore this revision? This will overwrite the current lesson.',
        )
    ) {
        return;
    }

    router.post(
        route('admin.lessons.revisions.restore', {
            lesson: props.lesson.id,
            revision: revisionId,
        }),
    );
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Lesson Management',
        href: route('admin.lessons.index'),
    },
    {
        title: props.lesson.title,
        href: route('admin.lessons.show', { lesson: props.lesson.id }),
    },
];
</script>

<template>
    <Head :title="lesson.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Header with actions -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        {{ lesson.title }}
                    </h1>
                    <div class="mt-2 flex items-center gap-2">
                        <Badge
                            :variant="
                                getLessonTypeBadgeVariant(lesson.content_type)
                            "
                        >
                            {{ lesson.content_type }}
                        </Badge>
                        <Badge
                            :variant="
                                getPublishStatusBadgeVariant(
                                    lesson.publish_status,
                                )
                            "
                        >
                            {{ lesson.publish_status }}
                        </Badge>
                        <span class="text-sm text-muted-foreground">
                            by {{ lesson.author?.name || 'Unknown' }}
                        </span>
                        <span
                            v-if="lesson.scheduled_publish_at"
                            class="text-xs text-muted-foreground"
                        >
                            Scheduled:
                            {{
                                new Date(
                                    lesson.scheduled_publish_at,
                                ).toLocaleDateString()
                            }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2" v-if="canManageLessons()">
                    <!-- <Dialog v-if="revisions?.length">
                        <DialogTrigger as-child>
                            <Button variant="outline"> View history </Button>
                        </DialogTrigger>
                        <DialogContent class="max-w-5xl">
                            <DialogHeader>
                                <DialogTitle>Revision history</DialogTitle>
                            </DialogHeader>
                            <div class="grid gap-6">
                                <div class="space-y-3">
                                    <div
                                        v-for="revision in revisions"
                                        :key="revision.id"
                                        class="rounded-xl border border-border/60 p-4"
                                        :class="{
                                            'border-primary/60 bg-primary/5':
                                                revision.id ===
                                                selectedRevisionId,
                                        }"
                                    >
                                        <button
                                            type="button"
                                            class="w-full text-left"
                                            @click="
                                                selectedRevisionId = revision.id
                                            "
                                        >
                                            <div
                                                class="flex items-center justify-between"
                                            >
                                                <div>
                                                    <p
                                                        class="text-sm font-semibold"
                                                    >
                                                        Revision
                                                        {{ revision.id }}
                                                    </p>
                                                    <p
                                                        class="text-xs text-muted-foreground"
                                                    >
                                                        {{
                                                            new Date(
                                                                revision.created_at,
                                                            ).toLocaleString()
                                                        }}
                                                    </p>
                                                    <p
                                                        class="text-xs text-muted-foreground"
                                                    >
                                                        {{
                                                            revision.user
                                                                ?.name ||
                                                            'System'
                                                        }}
                                                    </p>
                                                </div>
                                                <Button
                                                    size="sm"
                                                    variant="secondary"
                                                    @click.stop="
                                                        restoreRevision(
                                                            revision.id,
                                                        )
                                                    "
                                                >
                                                    Restore
                                                </Button>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    v-if="selectedRevision"
                                    class="rounded-xl border border-border/60 p-4"
                                >
                                    <h3 class="text-sm font-semibold">
                                        Snapshot diff
                                    </h3>
                                    <div class="mt-4 space-y-3">
                                        <div
                                            v-for="field in revisionFields"
                                            :key="field.key"
                                            class="rounded-lg border border-border/60 px-3 py-2"
                                            :class="{
                                                'border-primary/60 bg-primary/5':
                                                    valuesDiffer(field.key),
                                            }"
                                        >
                                            <p class="text-xs uppercase tracking-wide text-muted-foreground">
                                                {{ field.label }}
                                            </p>
                                            <div class="mt-2 grid gap-3 md:grid-cols-2">
                                                <div>
                                                    <p class="text-xs text-muted-foreground">
                                                        Current
                                                    </p>
                                                    <p class="text-sm">
                                                        {{ getCurrentValue(field.key) }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-muted-foreground">
                                                        Revision
                                                    </p>
                                                    <p class="text-sm">
                                                        {{ getRevisionValue(field.key) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </DialogContent>
                    </Dialog> -->
                    <Button variant="outline" as-child>
                        <Link
                            :href="
                                route('admin.lessons.edit', {
                                    lesson: lesson.id,
                                })
                            "
                        >
                            Edit
                        </Link>
                    </Button>
                    <Button variant="destructive" @click="handleDelete">
                        Delete
                    </Button>
                </div>
            </div>

            <!-- Lesson Details -->
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Main Lesson -->
                <Card class="md:col-span-2">
                    <CardHeader>
                        <CardTitle>Lesson</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div v-if="lesson.description">
                            <h3 class="mb-2 font-semibold">Description</h3>
                            <p class="text-muted-foreground">
                                {{ lesson.description }}
                            </p>
                        </div>

                        <div
                            v-if="
                                lesson.content_type === 'text' &&
                                lesson.content_text
                            "
                        >
                            <h3 class="mb-2 font-semibold">Text Lesson</h3>
                            <div
                                class="prose dark:prose-invert max-w-none"
                                v-html="lesson.content_text"
                            ></div>
                        </div>

                        <div
                            v-if="
                                lesson.content_type === 'pdf' &&
                                lesson.file_path
                            "
                        >
                            <h3 class="mb-2 font-semibold">PDF Document</h3>
                            <Button as-child>
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
                        >
                            <h3 class="mb-2 font-semibold">Video</h3>
                            <a
                                :href="lesson.external_url"
                                target="_blank"
                                class="text-primary hover:underline"
                            >
                                {{ lesson.external_url }}
                            </a>
                        </div>

                        <div
                            v-if="
                                lesson.content_type === 'link' &&
                                lesson.external_url
                            "
                        >
                            <h3 class="mb-2 font-semibold">External Link</h3>
                            <a
                                :href="lesson.external_url"
                                target="_blank"
                                class="text-primary hover:underline"
                            >
                                {{ lesson.external_url }}
                            </a>
                        </div>
                    </CardContent>
                </Card>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Metadata -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Details</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div>
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Slug
                                </h3>
                                <p class="font-mono text-sm">
                                    {{ lesson.slug }}
                                </p>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Created
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </p>
                            </div>
                            <div v-if="lesson.published_at">
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Published
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.published_at,
                                        ).toLocaleDateString()
                                    }}
                                </p>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Last Updated
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.updated_at,
                                        ).toLocaleDateString()
                                    }}
                                </p>
                            </div>
                            <div v-if="lesson.scheduled_publish_at">
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Scheduled publish
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.scheduled_publish_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>
                            <div v-if="lesson.expires_at">
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Expires
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.expires_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>
                            <div v-if="lesson.archived_at">
                                <h3
                                    class="text-sm font-medium text-muted-foreground"
                                >
                                    Archived
                                </h3>
                                <p>
                                    {{
                                        new Date(
                                            lesson.archived_at,
                                        ).toLocaleString()
                                    }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Categories -->
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
