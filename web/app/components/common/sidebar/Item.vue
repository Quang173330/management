<template>
    <nuxt-link :to="link">
        <ElMenuItem :index="index" :route="route">
            <slot name="icon">
                <Ionicon
                    v-if="icon"
                    :name="icon"
                    size="md"
                    class="mr-5"
                />
            </slot>

            <template slot="title">
                <slot />
            </template>
        </ElMenuItem>
    </nuxt-link>
</template>

<script>
    export default {
        props: {
            index: {
                type: String,
                required: true,
            },
            link: {
                type: String,
                required: true,
            },
            icon: String,
        },

        computed: {
            route() {
                return this.link.split('?')[0];
            },
        },
    };
</script>
