<template>
    <div>
        {{ project.name }}
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    export default {
        middleware: ['auth'],
        inject: ['setBreadcrumb'],

        computed: {
            ...mapState('project', ['project']),
            links() {
                return [
                    { icon: 'folder-open', title: this.project.name, link: '/' },
                ];
            },
        },

        created() {
            this.setBreadcrumb(this.links);
        },
    };
</script>
