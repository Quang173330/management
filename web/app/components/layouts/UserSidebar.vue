<template>
    <Sidebar :default-openeds="defaultActiveSubmenu" class="layout__sidebar">
        <template #header>
            <SidebarItem class="header" :link="`/`" index="/">
                <div slot="icon" class="h-full mx-auto flex justify-center">
                    <nuxt-link :to="`/`">
                        Logo
                    </nuxt-link>
                </div>
            </SidebarItem>
        </template>
        <SidebarItem :link="`/`" icon="home" index="home">
            Home
        </SidebarItem>
        <SidebarItem :link="`/projects/${slug}/add-issue`" icon="add" index="issue">
            Add Issue
        </SidebarItem>
        <SidebarItem :link="`/`" icon="list" index="issues">
            Issues
        </SidebarItem>
        <SidebarItem :link="`/`" icon="stats-chart" index="board">
            Board
        </SidebarItem>
        <SidebarItem :link="`/`" icon="document" index="wiki">
            Wiki
        </SidebarItem>
        <SidebarItem :link="`/`" icon="file-tray" index="files">
            Files
        </SidebarItem>
        <SidebarItem :link="`/`" icon="settings" index="setting">
            Project Settings
        </SidebarItem>
    </Sidebar>
</template>

<script>
    import { mapState } from 'vuex';
    import Sidebar from '~/components/common/sidebar/Sidebar.vue';
    import SidebarItem from '~/components/common/sidebar/Item.vue';

    export default {
        components: {
            Sidebar,
            SidebarItem,
        },

        data() {
            return {
                slug: 'project-manager',
                defaultActiveSubmenu: [],
            };
        },

        computed: {
            ...mapState('organization', ['organization']),
        },
    };
</script>

<style lang="scss">
    .header {
        height: 60px;
    }

    .layout__sidebar {
        background-color: theme('colors.emerald.500');

        .el-menu-item {
            color: theme('colorScheme.white');
            background-color: theme('colors.emerald.500');
            border-left: 3px solid theme('colors.emerald.500');

            &:hover {
                color: theme('colors.emerald.500');
                background-color: theme('colorScheme.blankBackground');
                border-left: 3px theme('colorScheme.blankBackground');
            }

            &.is-active {
                color: theme('colors.emerald.500');
                background-color: theme('colorScheme.blankBackground');
                border-left: 3px theme('colorScheme.blankBackground');
            }
        }
    }
</style>
