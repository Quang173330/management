<template>
    <div class="py-6 px-10 min-h-full bg-white">
        <div class="flex w-full justify-between mb-10">
            <ProjectFilter />
        </div>
        <ElTable
            :data="projects"
            row-key="id"
            style="width: 100%"
            cell-class-name="pr-5"
        >
            <ElTableColumn label="Name">
                <template slot-scope="{ row }">
                    <span class="font-medium">{{ row.name }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Description">
                <template slot-scope="{ row }">
                    <span class="break-normal">{{ row.description }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Issues" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium pl-4">{{ countMonitors(row) }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Users" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium pl-3">{{ countUsers(row) }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Created at" width="200">
                <template slot-scope="{ row }">
                    <span class="font-medium">{{ row.created_at | humanizeTime }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn width="250">
                <template slot-scope="{ row }">
                    <ElButton icon="el-icon-edit" size="mini" @click.prevent="edit(row)" />
                </template>
            </ElTableColumn>

        </ElTable>
        <ProjectForm ref="form" :save="save" />
        <Pagination :data="pagination" />
    </div>
</template>

<script>
    import _findIndex from 'lodash/findIndex';
    import {
        getProjects,
        updateProject,
    } from '~/api/admin/projects';
    import Pagination from '~/components/common/Pagination.vue';
    import ProjectFilter from '~/components/admin/projects/ProjectFilter.vue';
    import ProjectForm from '~/components/projects/ProjectForm.vue';

    export default {
        components: {
            Pagination,
            ProjectFilter,
            ProjectForm,
        },

        inject: ['setBreadcrumb'],
        layout: 'admin',

        async asyncData({ query }) {
            const { data: { data, meta } } = await getProjects(query);

            return {
                projects: data,
                pagination: meta,
                project: null,
            };
        },

        head() {
            return {
                title: 'Project',
            };
        },

        computed: {
            links() {
                return [
                    { icon: 'albums', title: 'Project', link: '/admin/projects' },
                ];
            },

        },

        watchQuery: true,

        created() {
            this.setBreadcrumb(this.links);
        },

        methods: {
            countMonitors(project) {
                return project.issues.length;
            },

            countUsers(project) {
                return project.permissions.length;
            },
            edit(project) {
                this.$refs.form.open(project);
            },
            async save(data) {
                await updateProject(data.id, data).then(({ data: { data: project } }) => {
                    const indexParent = _findIndex(this.projects, ['id', project.id]);
                    if (indexParent !== -1) {
                        this.projects.splice(indexParent, 1, project);
                    }
                });
                this.$refs.form.close();
            },
        },
    };
</script>
