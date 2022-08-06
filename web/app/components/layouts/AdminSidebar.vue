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
        <SidebarItem :link="'/admin'" icon="home" index="home">
            Dashboard
        </SidebarItem>
        <SidebarItem :link="'/admin/organizations'" icon="business" index="organization">
            Organizations
        </SidebarItem>
        <SidebarItem :link="'/admin/projects'" icon="document" index="project">
            Projects
        </SidebarItem>
        <SidebarItem :link="'/admin/users'" icon="people" index="user">
            Users
        </SidebarItem>
    </Sidebar>
</template>

<script>
    import { mapState } from 'vuex';
    import Sidebar from '~/components/common/sidebar/Sidebar.vue';
    import SidebarItem from '~/components/common/sidebar/Item.vue';
    import draggable from 'vuedraggable';

    export default {
        components: {
            Sidebar,
            SidebarItem,
            draggable
        },

        data() {
            return {
                slug: 'project-manager',
                defaultActiveSubmenu: [],
            };
        },

        computed: {
            ...mapState('organization', ['organization']),
            ...mapState('project', ['project']),
        },
    };
</script>

<style lang="scss" scoped>
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
