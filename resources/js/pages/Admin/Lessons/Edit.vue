<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import AppLayout from '@/layouts/AppLayout.vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { Lesson, Category } from '@/types';
import { Textarea } from '@/components/ui/textarea';
import Editor from '@/components/Editor.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import ImageUpload from '@/components/ImageUpload.vue';

const props = defineProps<{
    lesson: Lesson & { categories?: Category[] };
    categories: Category[];
}>();

const server = {
    url: route('admin.lessons.upload', props.lesson.id),
    headers: {
        'X-CSRF-TOKEN':
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('lesson') || '',
    },
};

const form = useForm({
    title: props.lesson.title,
    slug: props.lesson.slug,
    description: props.lesson.description || '',
    content_type: props.lesson.content_type as
        | 'text'
        | 'pdf'
        | 'video'
        | 'link',
    file_path: null as File | null,
    external_url: props.lesson.external_url || '',
    content_text: props.lesson.content_text || '',
    publish_status: props.lesson.publish_status as 'draft' | 'published',
    scheduled_publish_at: formatDateTime(props.lesson.scheduled_publish_at),
    expires_at: formatDateTime(props.lesson.expires_at),
    archived_at: formatDateTime(props.lesson.archived_at),
    category_ids:
        props.lesson.categories?.map((c: any) => c.id) || ([] as number[]),
});

function handleSubmit() {
    const formData = new FormData();
    Object.entries(form.data()).forEach(([key, value]) => {
        if (key === 'file_path' && value instanceof File) {
            formData.append(key, value);
        } else if (key === 'category_ids' && Array.isArray(value)) {
            value.forEach((id) =>
                formData.append('category_ids[]', id.toString()),
            );
        } else if (value !== null && value !== undefined) {
            formData.append(key, value.toString());
        }
    });

    form.put(route('admin.lessons.update', { lesson: props.lesson.id }), {
        preserveScroll: true,
    });
}

// Updated to handle the ImageUpload component
function handleFileUpdate(file: File | File[] | null) {
    form.file_path = file as File | null;
}

// Remove the old handleFileChange function

function toggleCategory(id: number) {
    const index = form.category_ids.indexOf(id);
    if (index > -1) {
        form.category_ids.splice(index, 1);
    } else {
        form.category_ids.push(id);
    }
}

function formatDateTime(value?: string | null) {
    if (!value) {
        return '';
    }

    const date = new Date(value);
    const offset = date.getTimezoneOffset();
    const localDate = new Date(date.getTime() - offset * 60000);

    return localDate.toISOString().slice(0, 16);
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
        title: 'Edit Lesson',
        href: route('admin.lessons.edit', { lesson: props.lesson.id }),
    },
];
</script>

<template>
    <Head title="Edit Lesson" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-4xl space-y-6 p-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Edit Lesson</h1>
                <p class="text-muted-foreground">
                    Update e-learning content (text, PDF, video, or link)
                </p>
            </div>

            <!-- Form -->
            <Card>
                <CardHeader>
                    <CardTitle>Lesson Details</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <div class="space-y-2">
                            <Label for="title">Title *</Label>
                            <Input
                                id="title"
                                v-model="form.title"
                                required
                                placeholder="Enter content title"
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

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Brief description of the content"
                                rows="3"
                                :class="{
                                    'border-destructive':
                                        form.errors.description,
                                }"
                            />
                            <p
                                v-if="form.errors.description"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <!-- Lesson Type & Publish Status -->
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="content_type">Lesson Type *</Label>
                                <Select v-model="form.content_type">
                                    <SelectTrigger
                                        class="w-full"
                                        :class="{
                                            'border-destructive':
                                                form.errors.content_type,
                                        }"
                                    >
                                        <SelectValue
                                            placeholder="Select a type"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel
                                                >Lesson Types</SelectLabel
                                            >
                                            <SelectItem value="text">
                                                Text
                                            </SelectItem>
                                            <SelectItem value="pdf">
                                                PDF Document
                                            </SelectItem>
                                            <SelectItem value="video">
                                                Video
                                            </SelectItem>
                                            <SelectItem value="link">
                                                External Link
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="form.errors.content_type"
                                    class="text-sm text-destructive"
                                >
                                    {{ form.errors.content_type }}
                                </p>
                            </div>
                            <div class="space-y-2">
                                <Label for="publish_status"
                                    >Publish Status *</Label
                                >
                                <Select v-model="form.publish_status">
                                    <SelectTrigger
                                        class="w-full"
                                        :class="{
                                            'border-destructive':
                                                form.errors.publish_status,
                                        }"
                                    >
                                        <SelectValue
                                            placeholder="Select a type"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel
                                                >Publish Status</SelectLabel
                                            >
                                            <SelectItem value="draft">
                                                Draft
                                            </SelectItem>
                                            <SelectItem value="published">
                                                Published
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="form.errors.publish_status"
                                    class="text-sm text-destructive"
                                >
                                    {{ form.errors.publish_status }}
                                </p>
                            </div>
                        </div>

                        <!-- <div class="rounded-xl border border-border/60 bg-muted/20 p-4">
                            <div class="space-y-2">
                                <h3 class="text-sm font-semibold">
                                    Scheduling & lifecycle
                                </h3>
                                <p class="text-xs text-muted-foreground">
                                    Use dates to automate publishing and
                                    expiration windows.
                                </p>
                            </div>
                            <div class="mt-4 grid gap-4 md:grid-cols-3">
                                <div class="space-y-2">
                                    <Label for="scheduled_publish_at"
                                        >Scheduled publish</Label
                                    >
                                    <Input
                                        id="scheduled_publish_at"
                                        v-model="form.scheduled_publish_at"
                                        type="datetime-local"
                                    />
                                    <p
                                        v-if="form.errors.scheduled_publish_at"
                                        class="text-sm text-destructive"
                                    >
                                        {{ form.errors.scheduled_publish_at }}
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <Label for="expires_at">Expires at</Label>
                                    <Input
                                        id="expires_at"
                                        v-model="form.expires_at"
                                        type="datetime-local"
                                    />
                                    <p
                                        v-if="form.errors.expires_at"
                                        class="text-sm text-destructive"
                                    >
                                        {{ form.errors.expires_at }}
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <Label for="archived_at">Archive at</Label>
                                    <Input
                                        id="archived_at"
                                        v-model="form.archived_at"
                                        type="datetime-local"
                                    />
                                    <p
                                        v-if="form.errors.archived_at"
                                        class="text-sm text-destructive"
                                    >
                                        {{ form.errors.archived_at }}
                                    </p>
                                </div>
                            </div>
                        </div> -->

                        <!-- Dynamic Fields based on Lesson Type -->
                        <div
                            v-if="form.content_type === 'text'"
                            class="space-y-2"
                        >
                            <Label for="content_text">Lesson Text *</Label>
                            <Editor
                                v-model="form.content_text"
                                :class="{
                                    'border-destructive':
                                        form.errors.content_text,
                                }"
                            />
                            <p
                                v-if="form.errors.content_text"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.content_text }}
                            </p>
                        </div>

                        <!-- Updated PDF Upload Section -->
                        <div
                            v-if="form.content_type === 'pdf'"
                            class="space-y-2"
                        >
                            <Label for="file_path">PDF File</Label>
                            <ImageUpload
                                v-model="form.file_path"
                                @update:model-value="handleFileUpdate"
                                :label="'PDF File'"
                                :accepted-file-types="['application/pdf']"
                                :max-file-size="'2MB'"
                                :multiple="false"
                                :instant-upload="false"
                                :credits="false"
                                :server="server"
                                :name="'file_path'"
                                :disabled="form.processing"
                            >
                                <template #help>
                                    <p class="text-sm text-muted-foreground">
                                        Maximum file size: 2MB. Only PDF files
                                        allowed.
                                        <span
                                            v-if="lesson.file_path"
                                            class="mt-1 block"
                                        >
                                            Current file:
                                            {{ lesson.file_path }}
                                        </span>
                                    </p>
                                </template>
                            </ImageUpload>
                            <p
                                v-if="form.errors.file_path"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.file_path }}
                            </p>
                        </div>

                        <div
                            v-if="form.content_type === 'video'"
                            class="space-y-2"
                        >
                            <Label for="external_url">Video URL *</Label>
                            <Input
                                id="external_url"
                                v-model="form.external_url"
                                type="url"
                                placeholder="https://youtube.com/watch?v=..."
                                :class="{
                                    'border-destructive':
                                        form.errors.external_url,
                                }"
                            />
                            <p
                                v-if="form.errors.external_url"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.external_url }}
                            </p>
                        </div>

                        <div
                            v-if="form.content_type === 'link'"
                            class="space-y-2"
                        >
                            <Label for="external_url">External URL *</Label>
                            <Input
                                id="external_url"
                                v-model="form.external_url"
                                type="url"
                                placeholder="https://example.com/article"
                                :class="{
                                    'border-destructive':
                                        form.errors.external_url,
                                }"
                            />
                            <p
                                v-if="form.errors.external_url"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.external_url }}
                            </p>
                        </div>

                        <!-- Categories -->
                        <div class="space-y-2">
                            <Label>Categories</Label>
                            <div class="grid gap-2 md:grid-cols-3">
                                <div
                                    v-for="cat in categories"
                                    :key="cat.id"
                                    class="flex items-center space-x-2"
                                >
                                    <input
                                        type="checkbox"
                                        :id="`category-${cat.id}`"
                                        :checked="
                                            form.category_ids.includes(cat.id)
                                        "
                                        @change="toggleCategory(cat.id)"
                                        class="h-4 w-4 rounded border-gray-300"
                                    />
                                    <Label
                                        :for="`category-${cat.id}`"
                                        class="text-sm font-normal"
                                    >
                                        {{ cat.name }}
                                    </Label>
                                </div>
                            </div>
                            <p
                                v-if="form.errors.category_ids"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.category_ids }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <Button type="button" variant="outline" as-child>
                                <Link :href="route('admin.lessons.index')">
                                    Cancel
                                </Link>
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                <span v-if="form.processing">Updating...</span>
                                <span v-else>Update Lesson</span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
