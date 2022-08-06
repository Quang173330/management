<template>
    <div class="min-h-full py-4 bg-white">
        <div class="pb-6">
            <ProjectInformation :current-project="currentProject" :update="update" :server-errors="serverErrors" />
        </div>
        <h1 class="font-bold text-xl text-neutral-800 mb-4">
            List Categories
        </h1>
        <div>
        <ElButton type="primary" class="float-right	">Add Category</ElButton>
        <ElTable class="mt-5" :data="categories">
            <ElTableColumn label="Name" >
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.name }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Issues">
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.total_issue }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Created at">
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.created_at | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Action" width="100">
                <template slot-scope="{ row }">
                    <ElButton size="mini">Edit</ElButton>
                </template>
            </ElTableColumn>
        </ElTable>
        </div>

        <h1 class="font-bold mt-5 text-xl text-neutral-800 mb-4">
            List Milestones
        </h1>
        <div>
        <ElButton type="primary" class="float-right	">Add Milestone</ElButton>
        <ElTable class="mt-5" :data="milestones">
            <ElTableColumn label="Name" >
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.name }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Issues">
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.total_issue }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Created at">
                <template slot-scope="{ row }">
                    <span class="font-medium truncate">{{ row.created_at | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Action" width="100">
                <template slot-scope="{ row }">
                    <ElButton size="mini">Edit</ElButton>
                </template>
            </ElTableColumn>
        </ElTable>
        </div>
    </div>
</template>

<script>
    import _mapValues from 'lodash/mapValues';
    import {
        update,
        getCategories
    } from '~/api/projects';
    import { get } from '~/api/milestones.js';
    import ProjectInformation from '~/components/projects/settings/ProjectInformation.vue';
    export default {
        components: {
            ProjectInformation,
        },
        inject: ['setBreadcrumb'],
        props: {
            currentProject: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                serverErrors: {},
            };
        },

        async asyncData({ params, query }) {
            const { slug } = params;

            const {data: { data: milestones } } = await get(slug);
            const {data: { data: categories } } = await getCategories(slug);
            return {
                milestones, categories
            };
        },
        computed: {
            links() {
                const { slug } = this.$route.params;
                return [
                    { icon: 'folder-open', title: `${this.currentProject.name}`, link: `/projects/${slug}` },
                    { icon: 'cog', title: 'Settings', link: `/projects/${slug}/settings` },
                ];
            },
        },
        watch: {
            currentProject() {
                this.setBreadcrumb(this.links);
            },
        },
        created() {
            this.setBreadcrumb(this.links);
        },
        methods: {
            async update({ id, ...data }) {
                try {
                    const { data: { data: updatedProject } } = await update(id, data);
                    this.$store.commit('projects/updateProject', updatedProject);
                    updatedProject.owner = data.owner;
                    updatedProject.permission = data.permission;
                    this.$emit('change', updatedProject);
                    this.$router.push(`/projects/${updatedProject.slug}/settings`);
                    this.$message.success({
                        dangerouslyUseHTMLString: true,
                        message: '<strong>Success.</strong> Project information was updated.',
                    });
                    this.serverErrors = {};
                } catch (error) {
                    if (error.response.status === 422) {
                        this.serverErrors = _mapValues(error.response.data.errors, '0');
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },
        },
    };
</script>