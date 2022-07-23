<template>
    <div class="m-5">
        <BoardFilter />
        <div class="mt-10 board-issues w-full flex justify-between">
            <!-- Open Issues -->
            <div v-infinite-scroll="loadOpen" class="infinite-list w-1/5 bg-white" style="overflow:auto">
                <div class="flex mx-auto w-4/5 my-5">
                    <ion-icon class="mt-1 mr-0.5 text-red-500" name="ellipse" />
                    <span class="font-medium">Open</span>
                </div>
                <draggable :list="openIssues" @change="addOpen" group="issues">
                    <div class="mb-2 mx-auto w-4/5" v-for="issue in openIssues" :key="issue.id">
                        <CardIssue
                            :issue="issue"
                        />
                    </div>
                </draggable>
            </div>

            <!-- Inprogress Issues -->
            <div v-infinite-scroll="loadInProgress" class="overflow-auto w-1/5 bg-white">
                <div class="flex mx-auto w-4/5 my-5">
                    <ion-icon class="mt-1 mr-0.5 text-blue-500" name="ellipse" />
                    <span class="font-medium">In Progress</span>
                </div>
                <draggable :list="inProgressIssues" @change="addInprogress" group="issues">
                    <div class="mb-2 mx-auto w-4/5" v-for="issue in inProgressIssues" :key="issue.id">
                        <CardIssue
                            :issue="issue"
                        />
                    </div>
                </draggable>
            </div>

            <!-- Resolved Issues -->
            <div v-infinite-scroll="loadResolved" class="overflow-auto w-1/5 bg-white">
                <div class="flex mx-auto w-4/5 my-5">
                    <ion-icon class="mt-1 mr-0.5 text-green-500" name="ellipse" />
                    <span class="font-medium">Resolved</span>
                </div>
                <draggable :list="resolvedIssues" group="issues" @change="addResolved">
                    <div class="mb-2 mx-auto w-4/5" v-for="issue in resolvedIssues" :key="issue.id">
                        <CardIssue
                            :issue="issue"
                        />
                    </div>
                </draggable>
            </div>

            <!-- Closed Issues -->
            <div v-infinite-scroll="loadClosed" class="overflow-auto w-1/5 bg-white">
                <div class="flex mx-auto w-4/5 my-5">
                    <ion-icon class="mt-1 mr-0.5 text-gray-500" name="ellipse" />
                    <span class="font-medium">Closed</span>
                </div>
                <draggable :list="closedIssues" @change="addClosed" group="issues">
                    <div class="mb-2 mx-auto w-4/5" v-for="issue in closedIssues" :key="issue.id">
                        <CardIssue
                            :issue="issue"
                        />
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import { get, update } from '~/api/issues.js';
    import { mapState } from 'vuex';
    import _filter from 'lodash/filter';
    import _concat from 'lodash/concat';
    import draggable from 'vuedraggable'
    import BoardFilter from '~/components/projects/issues/BoardFilter.vue';
    import CardIssue from '~/components/projects/issues/CardIssue.vue';
    export default {
        components: {
            BoardFilter,
            CardIssue,
            draggable
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
            const {data: { data: openIssues, meta: openPagination } } = await get(slug, {status: 'open', ...query});
            const {data: { data: inProgressIssues, meta: inProgressPagination } } = await get(slug, {status: 'in progress', ...query});
            const {data: { data: resolvedIssues, meta: resolvedPagination } } = await get(slug, {status: 'resolved', ...query});
            const {data: { data: closedIssues, meta: closedPagination } } = await get(slug, {status: 'closed', ...query});
            return {
                slug,
                openIssues,
                inProgressIssues,
                resolvedIssues,
                closedIssues,
                openPagination,
                inProgressPagination,
                resolvedPagination,
                closedPagination,
                oldIndex: 0,
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

            async addOpen(e) {
                if (e.added) {
                    const data = e.added.element;
                    const index = e.added.newIndex;
                    const status = data.status;
                    try {
                        data.status = 'open';
                        const {data: { data: issue } } = await update(this.slug, data)
                        this.$message.success('Update status success');
                    } catch(error) {
                        this.$message.error('Error, Something went wrong!')
                        this.openIssues.splice(index,1);
                        switch (status) {
                            case 'closed': return this.closedIssues.unshift(e.added.element);
                            case 'in progress': return this.inProgressIssues.unshift(e.added.element);
                            case 'resolved': return this.resolvedIssues.unshift(e.added.element);
                        }
                    }


                }
            },

            async addInprogress(e) {
                if (e.added) {
                    const data = e.added.element;
                    const index = e.added.newIndex;
                    const status = data.status;
                    try {
                        data.status = 'in progress';
                        const {data: { data: issue } } = await update(this.slug, data)
                        this.$message.success('Update status success');
                    } catch(error) {
                        this.$message.error('Error, Something went wrong!')
                        this.inProgressIssues.splice(index,1);
                        switch (status) {
                            case 'open': return this.openIssues.unshift(e.added.element);
                            case 'closed': return this.closedIssues.unshift(e.added.element);
                            case 'resolved': return this.resolvedIssues.unshift(e.added.element);
                        }
                    }


                }
            },

            async addResolved(e) {
                if (e.added) {
                    const data = e.added.element;
                    const index = e.added.newIndex;
                    const status = data.status;
                    try {
                        data.status = 'resolved';
                        const {data: { data: issue } } = await update(this.slug, data)
                        this.$message.success('Update status success');
                    } catch(error) {
                        this.$message.error('Error, Something went wrong!')
                        this.resolvedIssues.splice(index,1);
                        switch (status) {
                            case 'open': return this.openIssues.unshift(e.added.element);
                            case 'in progress': return this.inProgressIssues.unshift(e.added.element);
                            case 'closed': return this.closedIssues.unshift(e.added.element);
                        }
                    }


                }
                if(e.removed) {
                    console.log(e.removed)
                    this.oldIndex = e.removed.oldIndex;
                    console.log(this.oldIndex);
                }
            },

            async addClosed(e) {
                console.log(this.oldIndex);
                if (e.added) {
                    const data = e.added.element;
                    const index = e.added.newIndex;
                    const status = data.status;
                    try {
                        data.status = 'closed';
                        const {data: { data: issue } } = await update(this.slug, data)
                        this.$message.success('Update status success');
                    } catch(error) {
                        data.status = status;
                        this.$message.error('Error, Something went wrong!')
                        this.closedIssues.splice(index,1);
                        switch (status) {
                            case 'open': return this.openIssues.splice(this.oldIndex,0,e.added.element);
                            case 'in progress': return this.inProgressIssues.splice(this.oldIndex,0,e.added.element);
                            case 'resolved': return this.resolvedIssues.splice(this.oldIndex,0,e.added.element);
                        }
                    }


                }
            },

            async loadOpen() {
                if(this.openPagination.current_page < this.openPagination.last_page) {
                    console.log('sda')
                    this.openPagination.current_page = this.openPagination.current_page + 1;
                    const {data: { data: newIssues } } = await get(this.slug, {status: 'open', page: this.openPagination.current_page, ...this.$route.query});
                    this.openIssues = _concat(this.openIssues, newIssues);
                }

            },

            async loadInProgress() {
                if(this.inProgressPagination.current_page < this.inProgressPagination.last_page) {
                    console.log('sda')
                    this.inProgressPagination.current_page = this.inProgressPagination.current_page + 1;
                    const {data: { data: newIssues } } = await get(this.slug, {status: 'in progress', page: this.inProgressPagination.current_page, ...this.$route.query});
                    this.inProgressIssues = _concat(this.inProgressIssues, newIssues);
                }

            },
            async loadResolved() {
                if(this.resolvedPagination.current_page < this.resolvedPagination.last_page) {
                    console.log('sda')
                    this.resolvedPagination.current_page = this.resolvedPagination.current_page + 1;
                    const {data: { data: newIssues } } = await get(this.slug, {status: 'resolved', page: this.resolvedPagination.current_page, ...this.$route.query});
                    this.resolvedIssues = _concat(this.resolvedIssues, newIssues);
                }

            },
            async loadClosed() {
                if(this.closedPagination.current_page < this.closedPagination.last_page) {
                    console.log('sda')
                    this.closedPagination.current_page = this.closedPagination.current_page + 1;
                    const {data: { data: newIssues } } = await get(this.slug, {status: 'closed', page: this.closedPagination.current_page, ...this.$route.query});
                    this.closedIssues = _concat(this.closedIssues, newIssues);
                }

            }
        }
    };
</script>


<style>
    .board-issues{
        height: 740px;
    }
</style>