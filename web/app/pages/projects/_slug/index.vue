<template>
    <div class="flex justify-between m-5">
        <div class="project-section">
            <div class="flex mt-5 mb-3 justify-between">
                <div>
                    <span class="font-bold">Project Home</span>
                </div>
            </div>

            <ElTable row-key="id" class="mt-5" :data="issues" style="width: 100%">
                <ElTableColumn label="Issue Type" width="200">
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
        <div class="milestone-section">
            <div class="flex mt-5 mb-3 justify-between">
                <div>
                    <span class="font-bold">Status</span>
                </div>
            </div>
            <ElCard shadow="never" class="bg-white border-gray-400">
                <div class="h-3 flex">
                    <div class="bg-red-400" v-tooltip :title="getPercentFixed(status.open, status.all) + '% Open'" :style="{ 'width': getPercent(status.open, status.all) + '%'}"></div>
                    <div class="bg-blue-500" v-tooltip :title="getPercentFixed(status.inprogress, status.all) + '% In Progress'" :style="{ 'width': getPercent(status.inprogress, status.all) + '%'}"></div>
                    <div class="bg-green-500" v-tooltip :title="getPercentFixed(status.resolved, status.all) + '% Resolved'" :style="{ 'width': getPercent(status.resolved, status.all) + '%'}"></div>
                    <div class="bg-amber-500" v-tooltip :title="getPercentFixed(status.closed, status.all) + '% Closed'" :style="{ 'width': getPercent(status.closed, status.all) + '%'}"></div>
                </div>

                <div class="flex mt-5">
                    <div class="w-1/4">
                        <p class="text-center">Open</p>
                        <span
                            class=" capitalize text-center w-28 font-medium inline-block py-0.5 rounded-3xl text-white text-sm bg-red-400"
                        >
                            {{ status.open }}
                        </span>
                    </div>
                    <div class="w-1/4">
                        <p class="text-center">In Progress</p>
                        <span
                            class=" capitalize text-center w-28 font-medium inline-block py-0.5 rounded-3xl text-white text-sm bg-blue-500"
                        >
                            {{ status.inprogress }}
                        </span>
                    </div>
                    <div class="w-1/4">
                        <p class="text-center">Resolved</p>
                        <span
                            class=" capitalize text-center w-28 font-medium inline-block py-0.5 rounded-3xl text-white text-sm bg-green-500"
                        >
                            {{ status.resolved }}
                        </span>
                    </div>
                    <div class="w-1/4">
                        <p class="text-center">Closed</p>
                        <span
                            class=" capitalize text-center w-28 font-medium inline-block py-0.5 rounded-3xl text-white text-sm bg-amber-500"
                        >
                            {{ status.closed }}
                        </span>
                    </div>
                </div>
            </ElCard>

            <div class="flex mt-5 mb-3 justify-between">
                <div>
                    <span class="font-bold">Milestone</span>
                </div>
            </div>
            <ElCard shadow="never" class="bg-white border-gray-400">
                <div v-for="milestone in milestones" class="mb-3">
                    <div v-if="milestone.all">
                        <p class="text-emerald-600 font-medium mb-1"> {{ milestone.name }}</p>
                        <div class="h-3 flex">
                            <div class="bg-red-400" v-tooltip :title="getPercentFixed(milestone.open, milestone.all) + '% Open'" :style="{ 'width': getPercent(milestone.open, milestone.all) + '%'}"></div>
                            <div class="bg-blue-500" v-tooltip :title="getPercentFixed(milestone.inprogress, milestone.all) + '% In Progress'" :style="{ 'width': getPercent(milestone.inprogress, milestone.all) + '%'}"></div>
                            <div class="bg-green-500" v-tooltip :title="getPercentFixed(milestone.resolved, milestone.all) + '% Resolved'" :style="{ 'width': getPercent(milestone.resolved, milestone.all) + '%'}"></div>
                            <div class="bg-amber-500" v-tooltip :title="getPercentFixed(milestone.closed, milestone.all) + '% Closed'" :style="{ 'width': getPercent(milestone.closed, milestone.all) + '%'}"></div>
                        </div>
                    </div>
                </div>
            </ElCard>

            <div class="flex mt-5 mb-3 justify-between">
                <div>
                    <span class="font-bold">Category</span></span>
                </div>
            </div>
            <ElCard shadow="never" class="bg-white border-gray-400">
                <div v-for="category in categories" class="mb-3">
                    <div v-if="category.all">
                        <p class="text-emerald-600 font-medium mb-1"> {{ category.name }}</p>
                        <div class="h-3 flex">
                            <div class="bg-red-400" v-tooltip :title="getPercentFixed(category.open, category.all) + '% Open'" :style="{ 'width': getPercent(category.open, category.all) + '%'}"></div>
                            <div class="bg-blue-500" v-tooltip :title="getPercentFixed(category.inprogress, category.all) + '% In Progress'" :style="{ 'width': getPercent(category.inprogress, category.all) + '%'}"></div>
                            <div class="bg-green-500" v-tooltip :title="getPercentFixed(category.resolved, category.all) + '% Resolved'" :style="{ 'width': getPercent(category.resolved, category.all) + '%'}"></div>
                            <div class="bg-amber-500" v-tooltip :title="getPercentFixed(category.closed, category.all) + '% Closed'" :style="{ 'width': getPercent(category.closed, category.all) + '%'}"></div>
                        </div>
                    </div>
                </div>
            </ElCard>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { getHome } from '~/api/projects.js';
    import { get } from '~/api/issues.js';
    import Pagination from '~/components/common/Pagination.vue';

    export default {
        middleware: ['auth'],
        inject: ['setBreadcrumb'],
        components: {
            Pagination,
        },
        computed: {
            ...mapState('project', ['project']),
            ...mapState('organization', ['organization']),
            ...mapState('auth', ['user']),
            links() {
                return [
                    { icon: 'folder-open', title: this.project.name, link: '/' },
                ];
            },
        },

        // async asyncData({ params, query }) {
        //     const { slug } = params;
        //     const {data: { data } } = await getHome(this.organization.slug, slug);
        //     const {data: { data: issues, meta: pagination } } = await get(slug, {assign: this.user.id, ...query});
        //     this.status = data.status;
        //     this.milestones = data.milestones;
        //     this.categories = data.categories;
        //     this.issues = issues;
        //     this.pagination = pagination;
        // },

        data() {
            return {
                status: {},
                milestones: [],
                categories: [],
                issues: [],
                pagination: [],
            }
        },

        created() {
            this.setBreadcrumb(this.links);
            this.getData();
        },

        watchQuery: true,

        methods: {
            name(user) {
                return user.name ?? user.username;
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
            priorityClass(type) {
                switch (type) {
                    case 'high':
                        return 'text-red-500';
                    case 'normal':
                        return 'text-blue-500';
                }
            },
            async getData(){
                const { slug } = this.$route.params;
                const query = this.$route.query;
                const {data: { data } } = await getHome(this.organization.slug, slug);
                const {data: { data: issues, meta: pagination } } = await get(slug, {assign: this.user.id, ...query});
                this.status = data.status;
                this.milestones = data.milestones;
                this.categories = data.categories;
                this.issues = issues;
                this.pagination = pagination;
            },

            getPercent(a,b){
                return a*100/b;
            },

            getPercentFixed(a,b){
                const percent = a*100/b
                return percent.toFixed(2);
            }
        }
    };
</script>

<style>
.project-section{
    width: 65%
}

.milestone-section{
    width: 33%;
}
</style>
