<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';

const { canManageCategories } = useAuthRoles();

const form = useForm({
    name: '',
    slug: '',
    description: '',
});

function handleSubmit() {
    form.post(route('admin.categories.store'), {
        preserveScroll: true,
    });
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Category Management',
        href: route('admin.categories.index'),
    },
    {
        title: 'Create Category',
        href: route('admin.categories.create'),
    },
];
</script>

<template>
    <Head title="Create Category" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold tracking-tight">
                    Create New Category
                </h1>
                <p class="text-muted-foreground">
                    Categories help organize content for better navigation
                </p>
            </div>

            <!-- Form -->
            <Card>
                <CardHeader>
                    <CardTitle>Category Details</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <Label for="name">Name *</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                required
                                placeholder="e.g., Programming, Design, Marketing"
                                :class="{
                                    'border-destructive': form.errors.name,
                                }"
                            />
                            <p
                                v-if="form.errors.name"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Slug -->
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

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                placeholder="Brief description of the category"
                                rows="3"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                                :class="{
                                    'border-destructive':
                                        form.errors.description,
                                }"
                            ></textarea>
                            <p
                                v-if="form.errors.description"
                                class="text-sm text-destructive"
                            >
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <Button type="button" variant="outline" as-child>
                                <Link :href="route('admin.categories.index')">
                                    Cancel
                                </Link>
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                <span v-if="form.processing">Creating...</span>
                                <span v-else>Create Category</span>
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
