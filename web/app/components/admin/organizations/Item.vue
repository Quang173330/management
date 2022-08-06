<template>
    <ElCard shadow="always" body-style="padding: 0" class="border">
        <div class="flex items-center">
            <div class="flex flex-col flex-1 p-4 min-w-0">
                <div>
                    <span class="text-lg break-words hover:text-blue-700 mb-2">{{ organization.name }}</span>
                </div>
                <p class="truncate">
                    {{ organization.description }}
                </p>
            </div>

            <Time title="Created" :start-time="organization.created_at" />
        </div>
    </ElCard>
</template>

<script>
    import Time from '~/components/common/Time.vue';

    export default {
        components: {
            Time,
        },

        props: {
            organization: {
                type: Object,
                required: true,
            },
        },
    };
</script>
