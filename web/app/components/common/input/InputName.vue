<template>
    <div class="flex">
        <p class="text-neutral-800 text-smbase font-bold">
            {{ title }}
        </p>
        <span v-if="required" class="ml-1 text-tiny text-system-error-500">*</span>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true,
            },
            required: {
                type: Boolean,
                default: false,
            },
        },
    };
</script>
