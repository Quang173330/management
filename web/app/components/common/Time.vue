<template>
    <div class="ml-6 border-l border-gray-300 p-4" :class="$style.datetime">
        <p class="mb-2 text-gray-700">
            {{ title }}
        </p>
        <div
            v-if="startTime"
            v-tooltip
            :title="startTime | formatDate"
            class="flex items-center cursor-pointer"
        >
            <Ionicon name="calendar" size="md" class="ml-px mr-2" />
            <span class="truncate">{{ startTime | humanizeTime }}</span>
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
