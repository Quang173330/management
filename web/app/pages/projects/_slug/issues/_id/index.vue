<template>
    <div class="flex justify-between m-5">
        <div class="w-full">
            <div class="flex mt-5 mb-3 justify-between">
                <div>
                    <span
                        class="capitalize text-center w-24 mr-1 font-medium inline-block py-1 rounded-3xl text-white text-sm"
                        :class="typeClass(issue.type)"
                    >
                        {{ issue.type }}
                    </span>
                    <span class="font-bold text-xl"><span class="uppercase">[{{issue.category.name}}]</span> {{issue.title}}</span>
                </div>
                <div>
                    <span
                        class="capitalize text-center w-28 mr-2 font-medium inline-block py-1 rounded-3xl text-white text-sm"
                        :class="statusClass(issue.status)"
                    >
                        {{ issue.status }}
                    </span>
                    <ElButton
                        type="primary"
                        icon="el-icon-edit"
                        class="rounded-3xl w-29 py-1.5"
                    >
                        <nuxt-link :to="`/projects/${project.slug}/issues/${issue.id}/edit`">
                            Edit
                        </nuxt-link>
                    </ElButton>
                </div>
            </div>
            <ElCard shadow="never" class="bg-white border-gray-400">
                <div slot="header" class="flex clearfix">
                    <ElAvatar
                        v-if="issue.owner.avatar_url"
                        :src="issue.owner.avatar_url"
                        class="mr-2 w-12 h-12"
                    />
                    <Ionicon v-else name="person-circle" class="ml-px mr-2 w-10 h-10" />
                    <div>
                        <div class="flex mb-1">
                            <h4 class="font-medium text-base text-slate-400">
                                {{ name(issue.owner) }}
                            </h4>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-400">
                                Created {{ issue.created_at | formatDate }}
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="font-bold">Description</div>
                    <div>{{issue.description}}</div>
                </div>

               <div class="my-10">
                    <div class="font-bold">Details</div>
                    <div class="flex mt-3 justify-between mb-10">
                        <div class="comment-child">
                            <div class="mt-3 flex mb-1">
                                <p class="w-1/3 font-text">Assignee</p>
                                <div class="flex content-center">
                                    <ElAvatar size="small" :src="issue.assign.avatar_url"/>
                                    <p class="text-center p-1">
                                        {{ name(issue.assign) }}
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Milestone</p>
                                <div class="flex content-center">
                                    <p
                                        v-for="milestone in issue.milestones"
                                        class="text-center mr-2 text-emerald-600 p-1 rounded-sm bg-emerald-50"
                                    >
                                        {{milestone.name}}
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Piority</p>
                                <div class="flex content-center">
                                    <p class="capitalize text-center text-emerald-600 p-1 rounded-sm bg-emerald-50">
                                        {{ issue.priority }}
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Category</p>
                                <div class="flex content-center">
                                    <p class="capitalize text-center text-emerald-600 p-1 rounded-sm bg-emerald-50">
                                        {{ issue.category.name }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="comment-child">
                            <div class="mt-3 flex mb-1">
                                <p class="w-1/3 font-text">Estimated Hours</p>
                                <div class="flex content-center">
                                    <p class="text-center text-emerald-600 p-1 rounded-sm bg-emerald-50">
                                        {{ issue.estimated_hours }} hours
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Actual Hours</p>
                                <div class="flex content-center">
                                    <p
                                        class="text-center text-emerald-600 p-1 rounded-sm bg-emerald-50"
                                    >
                                        {{issue.actual_hours}} hours
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Start Date</p>
                                <div class="flex content-center">
                                    <p class="capitalize text-center text-emerald-600 p-1 rounded-sm bg-emerald-50">
                                        {{ issue.start_date | formatDate }}
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-10 flex mb-1">
                                <p class="w-1/3 font-text">Due Date</p>
                                <div class="flex content-center">
                                    <p class="capitalize text-center text-emerald-600 p-1 rounded-sm bg-emerald-50">
                                        {{ issue.due_date |  formatDate }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </ElCard>
            <div class="flex mt-5 mb-2 justify-between font-bold text-xl">
                Comment
            </div>
            <ElCard shadow="never" class="mb-3 border-gray-400">
                <ElForm
                    ref="form"
                    :model="form"
                    :rules="rules"
                >
                    <ElFormItem prop="content" :error="serverErrors.content">
                        <ElInput placeholder="Comment" type="textarea" :rows="5" v-model="form.content"></ElInput>
                    </ElFormItem>
                    <ElButton
                        :loading="loading"
                        class="float-right my-2"
                        type="primary"
                        @click="saveComment(form)"
                    >
                        Post Comment
                    </ElButton>
                </ElForm>
            </ElCard>
            <ElCard v-for="comment in comments" shadow="never" class="bg-white mb-3 border-gray-400	" >
                <div class="flex">
                    <ElAvatar
                        v-if="comment.user.avatar_url"
                        :src="comment.user.avatar_url"
                        class="mr-2 w-12 h-12"
                    />
                    <Ionicon v-else name="person-circle" class="ml-px mr-2 w-10 h-10" />
                    <div>
                        <div class="flex mb-1">
                            <h4 class="font-medium text-base text-slate-400">
                                {{ name(comment.user) }}
                            </h4>
                        </div>
                        <div>
                            <p class="text-sm text-neutral-400">
                                {{ comment.created_at | formatDate }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="ml-14 mt-3">
                    {{comment.content}}
                </div>
            </ElCard>
            <Pagination :data="pagination" />
        </div>
    </div>
</template>
<script>
    import _mapValues from 'lodash/mapValues';
    import { mapState } from 'vuex';
    import { show } from '~/api/issues.js';
    import { storeComment, getComment } from '~/api/comments.js';
    import dialogForm from '~/mixins/dialogForm';
    import _concat from 'lodash/concat';
    import Pagination from '~/components/common/Pagination.vue';
    export default {
        components: {
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
        
        async asyncData({params, query}) {
            const { id } = params;
            const { slug } = params;
            const { data: {data: issue} } = await show(slug, id);
            const { data: {data, meta} } = await getComment(slug, id, {...query});
            console.log(meta)
            return {
                issue,
                comments: data,
                pagination: meta,
            }
        },

        data() {
            return {
                loading: false,
                form: {
                    content: ''
                },
                rules: {
                    content: [
                        { required: true, message: 'Content is required', trigger: 'change' },
                    ],
                },
                serverErrors: {},
            }
        },
        created() {
                this.setBreadcrumb(this.links);
        },

        watchQuery: true,
        methods: {
            name(user) {
                return user.name ?? user.username;
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

            async saveComment(data) {
                try {
                    this.loading = true;
                    const { data: {data: comment} } = await storeComment(this.project.slug, this.issue.id, data);
                    this.comments = _concat(comment, this.comments);
                    this.loading = false;
                    this.form.content = '';
                }  catch (error) {
                    if (error.response.status === 422) {
                        this.serverErrors = _mapValues(error.response.data.errors, '0');
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }
                    this.loading = false;
                }

            }
        }


    };
</script>

<style  lang="scss">
    .main-comment {
        width: 23%;
    }

    .comment-child {
        width: 46%
    }

    hr{
        border-top: 1px solid rgb(203 213 225);
    }
    .font-text {
        color: rgb(148 163 184);
    }
</style>