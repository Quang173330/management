<template>
    <ElBreadcrumbItem>
        <div class="flex items-center">
            <Ionicon
                v-if="data.icon"
                :name="data.icon"
                class="mr-2"
                size="md"
            />

            <slot>
                <nuxt-link v-if="data.link" :to="data.link">
                    {{ data.title }}
                </nuxt-link>
                <span v-else>{{ data.title }}</span>
            </slot>

            <nuxt-link v-if="data.extraLink" :to="data.extraLink" class="ml-1 flex items-center">
                <Ionicon
                    :name="data.extraIcon"
                    class="mr-2"
                    size="lg"
                />
            </nuxt-link>
        </div>
    </ElBreadcrumbItem>
</template>

<script>
    export default {
        componentName: 'BreadcrumbItem',

        props: {
            data: {
                type: Object,
                required: true,
            },
        },
    };
</script>
