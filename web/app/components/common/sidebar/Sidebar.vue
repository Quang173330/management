<template>
    <ElMenu
        ref="menu"
        v-bind="$attrs"
        :default-active="active"
        class="sidebar"
    >
        <slot name="header" />

        <ElScrollbar class="flex-auto" wrap-class="overflow-x-hidden">
            <slot />
        </ElScrollbar>
    </ElMenu>
</template>

<script>
    export default {
        data: () => ({
            active: '',
        }),
    };
</script>

<style lang="scss">
    .sidebar {
        border: none;
        display: flex;
        flex-direction: column;
        height: 100%;

        &:not(.el-menu--collapse):not(.horizontal-collapse-transition) {
            width: 220px;

            .el-menu-item {
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    }
</style>
