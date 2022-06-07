<template>
    <div>
        {{ project.name }}
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { getOrganizations } from '~/api/organizations';
    export default {
        middleware: ['auth'],
        inject: ['setBreadcrumb'],

        computed: {
            ...mapState('project', ['project']),
            links() {
                return [
                    { icon: 'home', title: this.project.name, link: '/' },
                ];
            },
        },

        created() {
            this.setBreadcrumb(this.links);
        },
    };
</script>
