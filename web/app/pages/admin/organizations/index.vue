<template>
    <div class="py-6 px-10 min-h-full bg-white">
        <div class="flex w-full justify-between mb-10">
            <OrganizationFilter />
        </div>
        <ElTable
            :data="organizations"
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
            <ElTableColumn label="Projects" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium pl-4">{{ countProjects(row) }}</span>
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
                    <ElButton icon="el-icon-view" size="mini" @click="show(row)" />
                    <ElButton icon="el-icon-edit" size="mini" @click="edit(row)" />
                </template>
            </ElTableColumn>
        </ElTable>
        <OrganizationDialog ref="form" :save="save" />
        <OrganizationDetailDialog ref="organization" :organization="organization" />
        <Pagination :data="pagination" />
    </div>
</template>

<script>
    import _findIndex from 'lodash/findIndex';
    import {
        get,
        update,
    } from '~/api/admin/organizations';
    import Pagination from '~/components/common/Pagination.vue';
    import OrganizationFilter from '~/components/admin/organizations/OrganizationFilter.vue';
    import OrganizationDialog from '~/components/organizations/OrganizationDialog.vue';
    import OrganizationDetailDialog from '~/components/admin/organizations/OrganizationDetailDialog.vue';


    export default {
        components: {
            Pagination,
            OrganizationFilter,
            OrganizationDialog,
            OrganizationDetailDialog,
        },

        inject: ['setBreadcrumb'],
        layout: 'admin',

        async asyncData({ query }) {
            const { data: { data, meta } } = await get(query);

            return {
                organizations: data,
                pagination: meta,
                organization: null,
            };
        },

        head() {
            return {
                title: 'Organization',
            };
        },

        computed: {
            links() {
                return [
                    { icon: 'albums', title: 'Organization', link: '/admin/organizations' },
                ];
            },

        },

        watchQuery: true,

        created() {
            this.setBreadcrumb(this.links);
        },

        methods: {
            countProjects(organization) {
                return organization.projects.length;
            },

            countUsers(organization) {
                return organization.permissions.length;
            },
            show(organization) {
                this.organization = organization;
                console.log(this.$refs)
                this.$refs.organization.open();
            },
            edit(organization) {
                this.$refs.form.open(organization);
            },
            async save(data) {
                await update(data.slug, data).then(({ data: { data: organization } }) => {
                    const indexParent = _findIndex(this.organizations, ['id', organization.id]);
                    console.log(organization)
                    console.log(indexParent)
                    if (indexParent !== -1) {
                        this.organizations.splice(indexParent, 1, organization);
                    }
                });
                this.$refs.form.close();
            },
        },
    };
</script>
