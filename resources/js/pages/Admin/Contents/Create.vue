<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { route } from 'ziggy-js';
import type { Category } from '@/types';
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import Editor from '@/components/Editor.vue';

const props = defineProps<{
    categories: Category[];
}>();

const form = useForm({
    title: '',
    slug: '',
    description: '',
    content_type: 'text' as 'text' | 'pdf' | 'video' | 'link',
    file_path: null as File | null,
    external_url: '',
    content_text: '',
    publish_status: 'draft' as 'draft' | 'published',
    scheduled_publish_at: '',
    expires_at: '',
    archived_at: '',
    category_ids: [] as number[],
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

    form.post(route('admin.contents.store'), {
        forceFormData: true,
        preserveScroll: true,
    });
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.file_path = target.files[0];
    }
}

function toggleCategory(id: number) {
    const index = form.category_ids.indexOf(id);
    if (index > -1) {
        form.category_ids.splice(index, 1);
    } else {
        form.category_ids.push(id);
    }
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Content Management',
        href: route('admin.contents.index'),
    },
    {
        title: 'Create Content',
        href: route('admin.contents.create'),
    },
];
</script>

<template>
    <Head title="Create Content" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6 mx-auto max-w-4xl">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold tracking-tight">
                    Create New Content
                </h1>
                <p class="text-muted-foreground">
                    Add new e-learning content (text, PDF, video, or link)
                </p>
            </div>

            <!-- Form -->
            <Card>
                <CardHeader>
                    <CardTitle>Content Details</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Title & Slug -->
                        <div class="grid gap-4 md:grid-cols-2">
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
                            <div class="space-y-2">
                                <Label for="slug">Slug *</Label>
                                <Input
                                    id="slug"
                                    v-model="form.slug"
                                    required
                                    placeholder="url-friendly-slug"
                                    :class="{
                                        'border-destructive': form.errors.slug,
                                    }"
                                />
                                <p
                                    v-if="form.errors.slug"
                                    class="text-sm text-destructive"
                                >
                                    {{ form.errors.slug }}
                                </p>
                            </div>
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

                        <!-- Content Type & Publish Status -->
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="content_type">Content Type *</Label>
                                <Select v-model="form.content_type">
                                    <SelectTrigger class="w-full"
                                        :class="{
                                            'border-destructive':
                                                form.errors.content_type,
                                        }"
                                    >
                                        <SelectValue placeholder="Select a type" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Content Types</SelectLabel>
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
                                    <SelectTrigger class="w-full"
                                        :class="{
                                            'border-destructive':
                                                form.errors.publish_status,
                                        }"
                                    >
                                        <SelectValue placeholder="Select a type" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Publish Status</SelectLabel>
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

                        <div class="rounded-xl border border-border/60 bg-muted/20 p-4">
                            <div class="space-y-2">
                                <h3 class="text-sm font-semibold">
                                    Scheduling & lifecycle
                                </h3>
                                <p class="text-xs text-muted-foreground">
                                    Set optional publish and expiration windows.
                                    Scheduled items remain in draft until the
                                    publish date.
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
                        </div>

                        <!-- Dynamic Fields based on Content Type -->
                        <div
                            v-if="form.content_type === 'text'"
                            class="space-y-2"
                        >
                            <Label for="content_text">Content Text *</Label>
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

                        <div
                            v-if="form.content_type === 'pdf'"
                            class="space-y-2"
                        >
                            <Label for="file_path">PDF File *</Label>
                            <Input
                                id="file_path"
                                type="file"
                                accept=".pdf"
                                @change="handleFileChange"
                                :class="{
                                    'border-destructive': form.errors.file_path,
                                }"
                            />
                            <p
                                v-if="form.errors.file_path"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.file_path }}
                            </p>
                            <p class="text-sm text-muted-foreground">
                                Maximum file size: 2MB. Only PDF files allowed.
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
                                        :checked="form.category_ids.includes(cat.id)"
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
                                <Link :href="route('admin.contents.index')">
                                    Cancel
                                </Link>
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                <span v-if="form.processing">Creating...</span>
                                <span v-else>Create Content</span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
