<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';

// Import FilePond plugins
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import { Label } from './ui/label';

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateType,
);

interface Props {
    modelValue?: File | File[] | string | null;
    name?: string;
    label?: string;
    required?: boolean;
    disabled?: boolean;
    multiple?: boolean;
    acceptedFileTypes?: string[];
    maxFileSize?: string;
    maxFiles?: number;
    server?: {
        url: string;
        headers?: Record<string, string>;
        process?: any;
        revert?: any;
        restore?: any;
        load?: any;
        fetch?: any;
    };
    instantUpload?: boolean;
    credits?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    name: 'file',
    label: 'Upload files',
    required: false,
    disabled: false,
    multiple: false,
    acceptedFileTypes: () => ['image/*', 'application/pdf'],
    maxFileSize: '2MB',
    maxFiles: 1,
    instantUpload: true,
    credits: false,
});

const emit = defineEmits<{
    'update:modelValue': [value: File | File[] | null];
    processing: [files: File[]];
    processed: [response: any];
    error: [error: Error];
}>();

const pond = ref<any>(null);
const files = ref<any[]>([]);

// Handle file updates
const handleUpdateFiles = (fileItems: any[]) => {
    files.value = fileItems;

    if (fileItems.length === 0) {
        emit('update:modelValue', null);
        return;
    }

    if (props.multiple) {
        const fileObjects = fileItems.map((item) => item.file);
        emit('update:modelValue', fileObjects);
    } else {
        emit('update:modelValue', fileItems[0]?.file || null);
    }
};

// Initialize with existing value
onMounted(() => {
    if (props.modelValue) {
        if (typeof props.modelValue === 'string') {
            // Handle URL string (existing file)
            pond.value?.addFile(props.modelValue);
        } else if (props.modelValue instanceof File) {
            // Handle File object
            pond.value?.addFile(props.modelValue);
        }
    }
});

// Watch for modelValue changes
watch(
    () => props.modelValue,
    (newValue) => {
        if (!newValue && pond.value) {
            pond.value.removeFiles();
        }
    },
);

// Server configuration for instant upload
const serverConfig = ref({
    process: (
        fieldName: string,
        file: File,
        metadata: any,
        load: Function,
        error: Function,
        progress: Function,
        abort: Function,
    ) => {
        // Your upload logic here
        // For now, we'll simulate a successful upload
        const formData = new FormData();
        formData.append(fieldName, file, file.name);

        // Example fetch request
        fetch(props.server?.url || '/upload', {
            method: 'POST',
            body: formData,
            headers: props.server?.headers || {},
        })
            .then((response) => response.json())
            .then((data) => {
                load(data.fileUrl);
            })
            .catch((err) => {
                error(err.message);
            });

        return {
            abort: () => {
                abort();
            },
        };
    },
    revert: (uniqueFileId: string, load: Function, error: Function) => {
        // Handle file removal from server
        fetch(`/upload/${uniqueFileId}`, {
            method: 'DELETE',
            headers: props.server?.headers || {},
        })
            .then(() => load())
            .catch((err) => error(err.message));
    },
});

// Custom file validation
const checkFileType = (file: File, typePattern: string): boolean => {
    if (typePattern === '*') return true;

    const pattern = typePattern.replace('*', '.*');
    const regex = new RegExp(`^${pattern}$`, 'i');

    return regex.test(file.type) || regex.test(file.name);
};
</script>

<template>
    <div class="space-y-2 rounded-md border pb-4 text-center shadow-xs">
        <FilePond
            ref="pond"
            :name="name"
            :accepted-file-types="acceptedFileTypes"
            :max-file-size="maxFileSize"
            :max-files="maxFiles"
            :allow-multiple="multiple"
            :required="required"
            :disabled="disabled"
            :credits="credits"
            :instant-upload="instantUpload"
            :server="instantUpload ? serverConfig : undefined"
            :allow-image-preview="acceptedFileTypes.includes('image/*')"
            :allow-image-exif-orientation="
                acceptedFileTypes.includes('image/*')
            "
            :allow-file-type-validation="true"
            :label-idle="`Drag & drop your ${label.toLowerCase()} or <span class='filepond--label-action'>Browse</span>`"
            :label-file-processing="'Uploading...'"
            :label-file-processing-complete="'Upload complete'"
            :label-tap-to-cancel="'Tap to cancel'"
            :label-tap-to-retry="'Tap to retry'"
            :label-tap-to-undo="'Tap to undo'"
            :label-file-loading="'Loading'"
            :label-file-load-error="'Error during load'"
            :label-file-processing-error="'Error during upload'"
            :label-file-processing-aborted="'Upload cancelled'"
            :label-file-processing-revert-error="'Error during revert'"
            :label-file-remove-error="'Error during remove'"
            :label-file-type-not-allowed="'File type not allowed'"
            :label-file-size-too-large="'File is too large'"
            :label-max-file-size-exceeded="'File is too large'"
            :label-max-files-exceeded="'Maximum number of files exceeded'"
            @updatefiles="handleUpdateFiles"
            @processfile="
                (error: any, file: any) => !error && emit('processed', file)
            "
            @processfiles="
                (files: any) =>
                    emit(
                        'processing',
                        files.map((f: { file: any }) => f.file),
                    )
            "
            @error="(error: any) => emit('error', error)"
        />

        <p v-if="$slots.help" class="text-sm text-muted-foreground">
            <slot name="help" />
        </p>
    </div>
</template>

<style scoped>
:deep(.filepond--root) {
    margin-bottom: 0;
}

:deep(.filepond--panel-root) {
    background-color: hsl(var(--background));
    border: 1px solid hsl(var(--input));
    border-radius: calc(var(--radius) - 2px);
}

:deep(.filepond--drop-label) {
    color: hsl(var(--muted-foreground));
    font-size: 0.875rem;
}

:deep(.filepond--label-action) {
    color: hsl(var(--primary));
    text-decoration: underline;
}

:deep(.filepond--drip) {
    background-color: hsl(var(--primary) / 0.05);
}
</style>
