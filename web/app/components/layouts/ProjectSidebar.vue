<template>
    <Sidebar class="layout__sub-sidebar">
        <template #header>
            <div slot="icon" class="items-center flex p-4 pl-6 font-medium flex">
                <Ionicon class="mr-2" name="settings" />
                Project Settings
            </div>
        </template>

        <SidebarItem :link="`/projects/${slug}/settings`" index="general" class="h-10">
            General
        </SidebarItem>
        <SidebarItem v-if="isAdmin" :link="`/projects/${slug}/settings/users`" index="users">
            Users
        </SidebarItem>
    </Sidebar>
</template>

<script>
    import { mapState } from 'vuex';
    import _find from 'lodash/find';
    import Sidebar from '~/components/common/sidebar/Sidebar.vue';
    import SidebarItem from '~/components/common/sidebar/Item.vue';

    export default {
        components: {
            Sidebar,
            SidebarItem,
        },

        computed: {
            ...mapState('project', ['project']),
            isAdmin() {
                return this.project ? this.project.permission?.admin : null;
            },

            slug() {
                return this.project ? this.project.slug : null;
            },
        },
    };
</script>

<style lang="scss">

    .layout__sub-sidebar {
        background-color: theme('colors.lightgray');

        .el-menu-item {
            color: theme('colors.gray.600');
            border-left: 3px solid theme('colorScheme.white');
            height: 46px;
            line-height: 46px;
            background-color: inherit;

            &:hover, &.is-active {
                color: inherit;
            }

            &.is-active {
                border-left: 3px solid theme('colors.purple.500');
            }
        }
    }
</style>
