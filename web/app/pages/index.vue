<template>
    <div>
        Hello Worldd
    </div>
</template>

<script>
    export default {
        middleware: ['auth'],
        inject: ['setBreadcrumb'],      
                
        computed: {
            links() {
                return [
                    { icon: 'home', title: 'Dashboard', link: '/' },
                ];
            },
        },

        created() {
            this.setBreadcrumb(this.links);
        },
    };
</script>
