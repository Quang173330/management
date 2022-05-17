<template>
    <nuxt-link
        v-if="link"
        :to="link"
    >
        <ElSubmenu v-bind="$attrs" class="hover:text-white">
            <template #title>
                <slot name="icon">
                    <Ionicon
                        v-if="icon"
                        :name="icon"
                        size="md"
                        class="mr-5"
                    />
                </slot>
                <span><slot name="title" /></span>
            </template>

            <slot />
        </ElSubmenu>
    </nuxt-link>

    <ElSubmenu v-else v-bind="$attrs">
        <template #title>
            <slot name="icon">
                <Ionicon
                    v-if="icon"
                    :name="icon"
                    size="md"
                    class="mr-5"
                />
            </slot>
            <span><slot name="title" /></span>
        </template>

        <slot />
    </ElSubmenu>
</template>

<script>
    export default {
        props: {
            icon: String,
            link: String,
        },
    };
</script>

<style lang="scss">
    .sidebar {
        .el-submenu {
            color: theme('colors.gray.600');

            &.is-opened {
                color: theme('colorScheme.white');

                &.is-active {
                    color: theme('colorScheme.white');
                }
            }
        }

        .el-submenu__title {
            background-color: inherit;
            color: inherit;
        }
    }
</style>
