<template>
    <div class="m-5">
        <IssueFilter />
        <Pagination :data="pagination" />
        <ElTable class="mt-5" :data="issues" style="width: 100%">
            <ElTableColumn label="Issue Type" width="150">
                <template slot-scope="{ row }">
                    <span
                        class=" capitalize text-center w-28 font-medium inline-block py-1 rounded-3xl text-white text-sm"
                        :class="typeClass(row.type)"
                    >
                        {{ row.type }}
                    </span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Title" width="240" >
                <template slot-scope="{ row }">
                    <nuxt-link
                        :to="`/projects/${project.slug}/issues/${row.id}`"
                    >
                        <span class="font-medium truncate">{{ row.title }}</span>
                    </nuxt-link>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Assign" width="200" >
                <template slot-scope="{ row }">
                    <div v-if="row.assign !== null" class="flex  break-normal">
                        <ElAvatar size="small" :src="row.assign.avatar_url"/>
                        <span class="truncate ml-1 flex content-center mt-1 font-medium">{{ row.assign.name }}</span>
                    </div>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Status" width="150" >
                <template slot-scope="{ row }">
                    <span
                        class="capitalize text-center w-28 font-medium inline-block py-1 rounded-3xl text-white text-sm"
                        :class="statusClass(row.status)"
                    >
                        {{ row.status }}
                    </span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Priority" width="150" >
                <template slot-scope="{ row }">
                    <strong class="capitalize" :class="priorityClass(row.priority)">{{ row.priority }}</strong>              
                </template>
            </ElTableColumn>
            <ElTableColumn label="Milestone" width="150" >
                <template slot-scope="{ row }">
                    <span v-for="milestone in row.milestones">{{ milestone.name }}<br></span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Created by" width="200" >
                <template slot-scope="{ row }">
                    <div v-if="row.owner !== null" class="flex  break-normal">
                        <ElAvatar size="small" :src="row.owner.avatar_url"/>
                        <span class="truncate ml-1 flex content-center mt-1 font-medium">{{ row.owner.name }}</span>
                    </div>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Category" width="150" >
                <template slot-scope="{ row }">
                    <span v-if="row.category !== null" class="font-medium break-normal">{{ row.category.name }}</span>
                    <span v-else>null</span>
                </template>
            </ElTableColumn>

            <ElTableColumn prop="created_at" label="Created" width="150" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.created_at | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Start Date" width="150" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.start_date | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="due_date" label="Due Date" width="150" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.due_date | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="estimated_hours" label="Estimate Hours" width="150">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.estimated_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="actual_hours" label="Actual Hours" width="150">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.actual_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="description" label="Description" width="150">
                <template slot-scope="{ row }">
                    <span class="truncate font-medium break-normal">{{ row.description }}</span>
                </template>
            </ElTableColumn>

            <ElTableColumn fixed="right" label="Action" width="100">
                <template slot-scope="{ row }">
                    <span class="font-text">
                        <Ionicon name="pencil" />
                        <nuxt-link :to="`/projects/${project.slug}/issues/${row.id}/edit`">
                            Edit
                        </nuxt-link>
                    </span>
                </template>
            </ElTableColumn>
        </ElTable>
        <Pagination :data="pagination" />
    </div>
</template>

<script>
    import { get } from '~/api/issues.js';
    import { mapState } from 'vuex';
    import IssueFilter from '~/components/projects/issues/IssueFilter.vue';
    import Pagination from '~/components/common/Pagination.vue';
    
    export default {
        components: {
            IssueFilter,
            Pagination,
        },
        middleware: ['auth'],
        inject: ['setBreadcrumb'],      
        computed: {
            ...mapState('project', ['project']),
            links() {
                return [
                    { icon: 'folder-open', title: `${this.project.name}`, link: `/projects/${this.project.slug}` },
                    { icon: 'list', title: 'Issues', link: `/projects/${this.project.slug}/issues` },
                ];
            },
        },
        created() {
                this.setBreadcrumb(this.links);
        },
        async asyncData({ params, query }) {
            const { slug } = params;
            const {data: { data, meta } } = await get(slug, {...query});
            return {
                issues: data,
                pagination: meta,
            };
        },
        watchQuery: true,

        methods: {
            typeClass(type) {
                switch (type) {
                    case 'task':
                        return 'bg-yellow-600';
                    case 'feature':
                        return 'bg-blue-600';
                    case 'bug':
                        return 'bg-red-500';
                }
            },
            statusClass(type) {
                switch (type) {
                    case 'in progress':
                        return 'bg-blue-500';
                    case 'resolved':
                        return 'bg-green-500';
                    case 'open':
                        return 'bg-red-400';
                    case 'closed':
                        return 'bg-amber-500';
                }
            },
            priorityClass(type) {
                switch (type) {
                    case 'high':
                        return 'text-red-500';
                    case 'normal':
                        return 'text-blue-500';
                }
            },
        }
    };
</script>

<style>
    .font-text {
        color: rgb(148 163 184);
    }
</style>
