<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Switch } from '@/components/ui/switch';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import { route } from 'ziggy-js';

const props = defineProps<{
    lessons: Array<{
        id: number;
        title: string;
        description?: string | null;
        content_type: string;
        publish_status: string;
        scheduled_publish_at?: string | null;
        expires_at?: string | null;
    }>;
    classes: Array<{
        id: number;
        title: string;
    }>;
}>();

const form = useForm({
    title: '',
    slug: '',
    description: '',
    is_public: false,
    sort_order: 0,
    prerequisite_collection_id: '' as string | number,
    content_ids: [] as number[],
});

const contentSearch = ref('');

const availableClasses = computed(() => {
    const term = contentSearch.value.toLowerCase();

    return props.lessons.filter((lesson) => {
        if (form.content_ids.includes(lesson.id)) {
            return false;
        }

        if (!term) {
            return true;
        }

        return (
            lesson.title.toLowerCase().includes(term) ||
            (lesson.description || '').toLowerCase().includes(term)
        );
    });
});

const selectedLessons = computed(() => {
    return form.content_ids
        .map((id) => props.lessons.find((lesson) => lesson.id === id))
        .filter(Boolean);
});

function addLesson(lessonId: number) {
    if (!form.content_ids.includes(lessonId)) {
        form.content_ids.push(lessonId);
    }
}

function removeLesson(lessonId: number) {
    form.content_ids = form.content_ids.filter((id) => id !== lessonId);
}

function moveLesson(lessonId: number, direction: 'up' | 'down') {
    const index = form.content_ids.indexOf(lessonId);

    if (index === -1) {
        return;
    }

    const targetIndex = direction === 'up' ? index - 1 : index + 1;

    if (targetIndex < 0 || targetIndex >= form.content_ids.length) {
        return;
    }

    const updated = [...form.content_ids];
    [updated[index], updated[targetIndex]] = [updated[targetIndex], updated[index]];
    form.content_ids = updated;
}

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

function handleSubmit() {
    form.post(route('admin.classrooms.store'), {
        preserveScroll: true,
    });
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Classes Management',
        href: route('admin.classrooms.index'),
    },
    {
        title: 'Create',
        href: route('admin.classrooms.create'),
    },
];
</script>

<template>
    <Head title="Create Class" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6 mx-auto w-full md:w-5xl">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">
                    Create Class
                </h1>
                <p class="text-muted-foreground">
                    Bundle lessons into a guided learning path for students.
                </p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Class details</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="title">Title *</Label>
                            <Input
                                id="title"
                                v-model="form.title"
                                required
                                placeholder="New hire onboarding"
                                :class="{
                                    'border-destructive': form.errors.title,
                                }"
                            />
                            <p
                                v-if="form.errors.title"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Describe who this collection is for and what it covers."
                                rows="3"
                                :class="{
                                    'border-destructive': form.errors.description,
                                }"
                            />
                            <p
                                v-if="form.errors.description"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between rounded-xl border border-border/60 bg-muted/20 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold">
                                    Public class
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    Public classes appear in the student catalog.
                                </p>
                            </div>
                            <Switch v-model="form.is_public" />
                        </div>

                        <div class="grid gap-6 lg:grid-cols-[1fr_1fr]">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Available content</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-3">
                                    <Input
                                        v-model="contentSearch"
                                        type="search"
                                        placeholder="Filter content..."
                                    />
                                    <div class="space-y-3">
                                        <div
                                            v-for="content in availableClasses"
                                            :key="content.id"
                                            class="flex items-start justify-between gap-3 rounded-xl border border-border/60 p-3"
                                        >
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
                                                        :variant="getStatusBadge(content).variant"
                                                    >
                                                        {{ getStatusBadge(content).label }}
                                                    </Badge>
                                                </div>
                                            </div>
                                            <Button
                                                size="sm"
                                                variant="secondary"
                                                type="button"
                                                @click="addLesson(content.id)"
                                            >
                                                Add
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader>
                                    <CardTitle>Collection order</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div
                                        v-if="selectedLessons.length === 0"
                                        class="rounded-xl border border-dashed border-border/60 p-6 text-center text-sm text-muted-foreground"
                                    >
                                        Add items from the left panel to build this collection.
                                    </div>
                                    <div v-else class="space-y-3">
                                        <div
                                            v-for="content in selectedLessons"
                                            :key="content?.id"
                                            class="flex items-start justify-between gap-3 rounded-xl border border-border/60 p-3"
                                        >
                                            <div>
                                                <p class="text-sm font-semibold">
                                                    {{ content?.title }}
                                                </p>
                                                <div class="mt-2 flex flex-wrap gap-2">
                                                    <Badge variant="outline">
                                                        {{ content?.content_type }}
                                                    </Badge>
                                                    <Badge
                                                        v-if="content"
                                                        :variant="getStatusBadge(content).variant"
                                                    >
                                                        {{ getStatusBadge(content).label }}
                                                    </Badge>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    type="button"
                                                    @click="moveLesson(content!.id, 'up')"
                                                >
                                                    Up
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    type="button"
                                                    @click="moveLesson(content!.id, 'down')"
                                                >
                                                    Down
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    variant="destructive"
                                                    type="button"
                                                    @click="removeLesson(content!.id)"
                                                >
                                                    Remove
                                                </Button>
                                            </div>
                                        </div>
                                    </div>
                                    <p
                                        v-if="form.errors.content_ids"
                                        class="mt-3 text-sm text-destructive"
                                    >
                                        {{ form.errors.content_ids }}
                                    </p>
                                </CardContent>
                            </Card>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <Button type="button" variant="outline" as-child>
                                <Link :href="route('admin.classrooms.index')">
                                    Cancel
                                </Link>
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                <span v-if="form.processing">Creating...</span>
                                <span v-else>Create class</span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
