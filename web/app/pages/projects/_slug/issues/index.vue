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
            <ElTableColumn label="Title" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.title }}</span>
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
            <ElTableColumn label="Milestone" width="120" >
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
            <ElTableColumn label="Category" width="120" >
                <template slot-scope="{ row }">
                    <span v-if="row.category !== null" class="font-medium break-normal">{{ row.category.name }}</span>
                    <span v-else>null</span>
                </template>
            </ElTableColumn>

            <ElTableColumn prop="created_at" label="Created" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.created_at | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Start Date" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.start_date | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="due_date" label="Due Date" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.due_date | formatDate }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="estimated_hours" label="Estimate Hours" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.estimated_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="actual_hours" label="Actual Hours" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.actual_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="description" label="Description" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.description }}</span>
                </template>
            </ElTableColumn
            <ElTableColumn fixed="right" label="Actions" width="120">
                <el-button
                type="text"
                >
                    Edit <i class="el-icon-edit"/>
                </el-button>
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
                    { icon: 'home', title: this.project.name, link: '/' },
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
