<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
} from '@/components/ui/card';

type Role = {
    id: number;
    name: string;
};

type UserData = {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    roles: Role[];
    created_at: string;
};

const props = defineProps<{
    user: UserData;
    roles: Role[];
}>();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    roles: props.user.roles.map((r) => r.id),
});

function updateUser() {
    form.put(route('admin.users.update', { user: props.user.id }), {
        preserveScroll: true,
    });
}

function sendPasswordReset() {
    router.post(
        route('admin.users.send-password-reset', { user: props.user.id }),
        {},
        { preserveScroll: true },
    );
}

const breadcrumbs = [
    {
        title: 'Admin Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
    {
        title: `Edit ${props.user.name}`,
        href: route('admin.users.edit', { user: props.user.id }),
    },
];
</script>

<template>
    <Head title="Edit User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    Edit User
                </h1>
                <p class="text-sm text-muted-foreground">
                    Update user details and manage their roles.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <Card>
                    <CardHeader>
                        <CardTitle>User Details</CardTitle>
                        <CardDescription>
                            Update the user's name and email address.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form class="grid gap-6" @submit.prevent="updateUser">
                            <div class="grid gap-2">
                                <Label for="name">Name</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    placeholder="John Doe"
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="john@example.com"
                                />
                                <InputError :message="form.errors.email" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password">
                                    New Password
                                    <span class="text-xs text-muted-foreground">
                                        (leave blank to keep current)
                                    </span>
                                </Label>
                                <Input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    placeholder="New password"
                                />
                                <InputError :message="form.errors.password" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password_confirmation">
                                    Confirm New Password
                                </Label>
                                <Input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    placeholder="Confirm new password"
                                />
                                <InputError
                                    :message="form.errors.password_confirmation"
                                />
                            </div>

                            <div class="grid gap-3">
                                <Label>Roles</Label>
                                <select
                                    v-model="form.roles"
                                    multiple
                                    class="min-h-[6.5rem] w-full rounded-md border border-input bg-background px-2 py-2 text-sm"
                                >
                                    <option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :value="role.id"
                                    >
                                        {{ role.name }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.roles" />
                            </div>

                            <div class="flex items-center gap-3">
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    Save changes
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Password Reset</CardTitle>
                        <CardDescription>
                            Send the user a password reset link via email.
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <p class="text-sm text-muted-foreground">
                            The user will receive an email with a link to reset
                            their password. Their current password will continue
                            to work until the link is used.
                        </p>
                        <Button
                            variant="outline"
                            @click="sendPasswordReset"
                        >
                            Send password reset link
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
