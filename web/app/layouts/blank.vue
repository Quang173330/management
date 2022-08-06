<template>
    <ElContainer class="layout-default h-screen">
        <ElContainer direction="vertical" class="w-100 h-100">
            <ElHeader class="flex items-center justify-between bg-gray border-b border-gray-300">              
                <ProjectMenu />
                <UserMenu v-if="user" />
                <nuxt-link v-else to="/login">
                    <ElButton type="primary">
                        Login
                    </ElButton>
                </nuxt-link>
            </ElHeader>

            <ElMain class="w-100 bg-gray overflow-x-hidden">
                <nuxt />
            </ElMain>
        </ElContainer>
    </ElContainer>
</template>

<script>
    import { mapState } from 'vuex';
    import Sidebar from '~/components/layouts/OrganizationSidebar.vue';
    import UserMenu from '~/components/layouts/UserMenu.vue';
    import ProjectMenu from '~/components/layouts/ProjectMenu.vue';
    import BreadcrumbItem from '~/components/common/breadcrumb/BreadcrumbItem.vue';

    export default {
        components: {
            Sidebar,
            UserMenu,
            ProjectMenu,
            BreadcrumbItem,
        },

        provide() {
            return {
                setBreadcrumb: this.setBreadcrumb,
            };
        },

        middleware: ['init', 'auth'],

        data: () => ({
            breadcrumb: [],
        }),

        computed: {
            ...mapState('auth', ['user']),
        },

        methods: {
            login() {
                window.location.href = '/login';
            },

            setBreadcrumb(value) {
                this.breadcrumb = value;
            },
        },
    };
</script>

<style lang="scss">
    .layout-default {
        background-color: theme('colorScheme.blankBackground');

        .el-aside {
            z-index: 99;
            background-color: theme('colors.lightgray');
        }

        .el-breadcrumb__item {
            display: flex;
            align-items: center;

            &:last-child .el-breadcrumb__inner a {
                cursor: pointer;

                &:hover {
                    color: theme('colors.blue.600');
                }
            }
        }
    }
</style>
