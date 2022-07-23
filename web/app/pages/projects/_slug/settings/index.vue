<template>
    <div class="min-h-full py-4 bg-white">
        <h1 class="font-bold text-xl text-neutral-800 mb-4">
            Removal Setting
        </h1>
        <div class="flex w-full xs:justify-center md:justify-between">
            <ElButton
                class="bg-background-white text-system-error-500 py-2
                px-10 w-64 h-10 border-system-error-500"
                data-v-step="1"
            >
                <div class="flex items-center gap-4">
                    <span class="text-base font-bold m-auto">Remove this project</span>
                </div>
            </ElButton>
        </div>
    </div>
</template>

<script>

    export default {

        inject: ['setBreadcrumb'],

        props: {
            currentProject: {
                type: Object,
                required: true,
            },
        },

        computed: {
            links() {
                const { slug } = this.$route.params;

                return [
                    { icon: 'albums', title: 'Project', link: '/projects' },
                    { icon: 'folder-open', title: `${this.currentProject.name}`, link: `/projects/${slug}` },
                    { icon: 'cog', title: 'Settings', link: `/projects/${slug}/settings` },
                ];
            },
        },

        created() {
            this.setBreadcrumb(this.links);
        },
    };
</script>
