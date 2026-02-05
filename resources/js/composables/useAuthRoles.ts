import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { User } from '@/types';

export type UseAuthRolesReturn = {
    user: () => User | null;
    isAdmin: () => boolean;
    isStudent: () => boolean;
    hasRole: (role: string) => boolean;
    hasPermission: (permission: string) => boolean;
    canManageContent: () => boolean;
    canManageCategories: () => boolean;
    canManageCollections: () => boolean;
    canViewContent: () => boolean;
    canViewCollections: () => boolean;
};

export function useAuthRoles(): UseAuthRolesReturn {
    const page = usePage();

    const user = () => {
        return page.props.auth.user as User | null;
    };

    const isAdmin = () => {
        const currentUser = user();
        return currentUser ? currentUser.roles.includes('admin') : false;
    };

    const isStudent = () => {
        const currentUser = user();
        return currentUser ? currentUser.roles.includes('student') : false;
    };

    const hasRole = (role: string) => {
        const currentUser = user();
        return currentUser ? currentUser.roles.includes(role) : false;
    };

    const hasPermission = (permission: string) => {
        const currentUser = user();
        return currentUser
            ? currentUser.permissions.includes(permission)
            : false;
    };

    const canManageContent = () => {
        return hasPermission('manage content') || isAdmin();
    };

    const canManageCategories = () => {
        return hasPermission('manage categories') || isAdmin();
    };

    const canManageCollections = () => {
        return hasPermission('manage collections') || isAdmin();
    };

    const canViewContent = () => {
        return hasPermission('view content') || isAdmin() || isStudent();
    };

    const canViewCollections = () => {
        return hasPermission('view collections') || isAdmin() || isStudent();
    };

    return {
        user,
        isAdmin,
        isStudent,
        hasRole,
        hasPermission,
        canManageContent,
        canManageCategories,
        canManageCollections,
        canViewContent,
        canViewCollections,
    };
}
