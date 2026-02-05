import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { Category } from '@/types';

export type UseCategoriesReturn = {
    categories: Category[];
    getCategoryById: (id: number) => Category | undefined;
    getCategoryBySlug: (slug: string) => Category | undefined;
};

export function useCategories(
    categoriesList?: Category[],
): UseCategoriesReturn {
    const page = usePage();

    const categories = computed(() => {
        if (categoriesList && categoriesList.length > 0) {
            return categoriesList;
        }

        // Try to get categories from page props
        const props = page.props;
        if (props.categories && Array.isArray(props.categories)) {
            return props.categories as Category[];
        }

        return [];
    });

    const getCategoryById = (id: number) => {
        return categories.value.find((category) => category.id === id);
    };

    const getCategoryBySlug = (slug: string) => {
        return categories.value.find((category) => category.slug === slug);
    };

    return {
        categories: categories.value,
        getCategoryById,
        getCategoryBySlug,
    };
}
