<template>
    <ElContainer class="layout-default h-screen">
        <ElAside class="overflow-y-hidden" width="auto">
            <Sidebar />
        </ElAside>

        <ElContainer direction="vertical" class="w-100 h-100">
                <nuxt-child :current-project="project" />
        </ElContainer>
    </ElContainer>
</template>

<script>
    import { getProject } from '~/api/projects';
    import { mapState } from 'vuex';
    import Sidebar from '~/components/layouts/ProjectSidebar.vue';

    export default {
        components: {
            Sidebar
        },

        inject: ['setBreadcrumb'],

        head() {
            return {
                title: 'Project',
            };
        },

        computed: {
            ...mapState('project', ['project']),
        },
    };
</script>

<style lang="scss">
</style>
