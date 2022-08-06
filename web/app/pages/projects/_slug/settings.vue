<template>
    <div class="bg-white">
        <div class="py-4 md:py-6 px-4 md:px-7 h-full bg-white xs:text-center md:text-left">
            <p class="font-bold text-xl text-neutral-800 mb-4">
                Project settings
            </p>
            <div class="flex text-neutral-400 tabs-project-settings w-full xs:justify-center md:justify-start mb-4">
                <nuxt-link
                    :to="`/projects/${$route.params.slug}/settings`"
                    exact-path
                    class="py-2 px-8 border-4 bg-background-light-gray border-background-light-gray"
                >
                    <span class="font-bold text-base">General</span>
                </nuxt-link>
                <nuxt-link
                    :to="`/projects/${$route.params.slug}/settings/users`"
                    exact-path
                    class="py-2 px-8 border-4 bg-background-light-gray border-background-light-gray"
                >
                    <span class="font-bold text-base">User</span>
                </nuxt-link>
            </div>
            <div class="overflow-auto w-full bg-white">
                <nuxt-child :current-project="project"/>
            </div>
        </div>
    </div>
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
    .tabs-project-settings .nuxt-link-exact-active{
        background-color: theme('colors.background.white') !important;
        color: theme('colors.emerald.500');
    }
</style>
