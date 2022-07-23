<template>
    <ElCard shadow="hover">
        <div>
            <span
                class=" capitalize text-center w-14 py-0.5 inline-block py-1 rounded-3xl text-white text-xs"
                :class="typeClass(issue.type)"
            >
                {{ issue.type }}
            </span>
        </div>
        <div>
            <span class="break-normal">{{ issue.title }}</span>
        </div>
        <div v-if="issue.assign !== null" class="flex break-normal">
            <ElAvatar size="small" :src="issue.assign.avatar_url"/>
            <span class="truncate ml-1 flex content-center mt-1">{{ issue.assign.name }}</span>
        </div>
        <div v-else class="h-7"></div>
    </ElCard>
</template>

<script>
    export default {
        props: {
            issue: {
                type: Object,
                required: true,
            },
        },

        methods: {
            typeClass(type) {
                switch (type) {
                    case 'task':
                        return 'bg-yellow-600';
                    case 'feature':
                        return 'bg-blue-600';
                    case 'bug':
                        return 'bg-red-500';
                }
            },
        }
    }
</script>