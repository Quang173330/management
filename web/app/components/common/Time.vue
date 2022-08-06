<template>
    <div class="flex flex-col gap-3 border-gray-300 items-center w-36" :class="$style.datetime">
        <p class="text-neutral-400 font-medium text-xs">
            {{ title }}
        </p>
        <div
            v-if="startTime"
            v-tooltip
            :title="startTime | formatDate"
            class="flex items-center cursor-pointer"
        >
            <span class="truncate text-neutral-400 font-medium text-xs py-2 px-3.5">
                {{ startTime | humanizeTime }}
            </span>
        </div>
        <div v-else class="flex items-center cursor-pointer">
            <span>-</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true,
            },
            startTime: {
                type: [String, Number],
            },
        },
    };
</script>

<style lang="scss" module>
    .datetime {
        width: 180px;
    }
</style>