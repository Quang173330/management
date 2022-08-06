<template>
    <div>
        Admin Dashboard
    </div>
</template>

<script>
    export default {

        inject: ['setBreadcrumb'],
        layout: 'admin',

        computed: {
            links() {
                return [
                    { icon: 'home', title: 'Dashboard', link: '/admin' },
                ];
            },
        },

        created() {
            this.setBreadcrumb(this.links);
        },
    };
</script>
