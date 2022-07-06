<template>
    <ElForm label-position='left' class="m-5" ref="form" :model="form" label-width="120px">
        <ElFormItem label="Title">
            <ElInput placeholder="Issue title" v-model="form.title"></ElInput>
        </ElFormItem>
        <ElFormItem label="Type">
            <ElSelect v-model="form.type" placeholder="Issue type">
                <ElOption label="Feature" value="feature"></ElOption>
                <ElOption label="Task" value="task"></ElOption>
                <ElOption label="Bug" value="bug"></ElOption>
            </ElSelect>
        </ElFormItem>
        <ElFormItem label="Description">
            <ElInput placeholder="Issue description" type="textarea" :rows="5" v-model="form.description"></ElInput>
        </ElFormItem>
        <div class="flex">
            <ElFormItem label="Start Date">
                <ElDatePicker placeholder="Start Date" type="date" v-model="form.start_date"/>
            </ElFormItem>
            <ElFormItem class="ml-10" label="Due Date">
                <ElDatePicker placeholder="Due Date" type="date" v-model="form.due_date"/>
            </ElFormItem>
        </div>
        <div class="flex">
            <ElFormItem label="Priority">
                <ElSelect v-model="form.priority" placeholder="Priority">
                    <ElOption label="High" :value="3"></ElOption>
                    <ElOption label="Normal" :value="2"></ElOption>
                    <ElOption label="Low" :value="1"></ElOption>
                </ElSelect>            
            </ElFormItem>
            <ElFormItem class="ml-8" label="Milestone">
                <ElSelect v-model="form.milestone" placeholder="Milestone">
                    <ElOption
                        v-for="item in milestones"
                        :key="item.id" :label="item.name"
                        :value="item.id"
                    />
                </ElSelect>            
            </ElFormItem>
        </div>

        <div class="flex">
            <ElFormItem label="Category">
                <ElSelect v-model="form.category_id" placeholder="Select user">
                    <ElOption
                        v-for="item in categories"
                        :key="item.id" :label="item.name"
                        :value="item.id"
                    />
                </ElSelect>            
            </ElFormItem>
            <ElFormItem class="ml-8" label="Assign">
                <ElSelect v-model="form.assign_id" placeholder="Select user">
                    <ElOption
                        v-for="item in users"
                        :key="item.id" :label="item.name"
                        :value="item.id"
                    />
                </ElSelect>            
            </ElFormItem>
        </div>

        <div class="flex">
            <ElFormItem label="Estimated Hours">
                <ElInput type="number" placeholder="Estimated Hours" v-model="form.estimated_hours"></ElInput>
            </ElFormItem>
            <ElFormItem class="ml-14" label="Actual Hours">
                <ElInput type="number" placeholder="Actual Hours" v-model="form.actual_hours"></ElInput>
            </ElFormItem>        
        </div>
        <ElFormItem>
            <ElButton class="py-2 px-10" :loading="loading"  @click="createIssue($refs.form.model)" type="primary">Add</ElButton>
        </ElFormItem>
    </ElForm>
</template>
<script>
    import { mapState } from 'vuex';
    import { get } from '~/api/milestones.js';
    import { store } from '~/api/issues.js';
    import { getUsers, getCategories } from '~/api/projects.js';
    import dialogForm from '~/mixins/dialogForm';
    export default {
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
        async asyncData({params}) {
            const { slug } = params;

            const {data: { data: milestones } } = await get(slug);
            const {data: { data: users } } = await getUsers(slug);
            const {data: { data: categories } } = await getCategories(slug);
            return {
                users,
                milestones,
                categories,
                loading: false,
                form: {
                    parent_id: null,
                    title: '',
                    milestone: null,
                    type: '',
                    priority: null,
                    estimated_hours: null,
                    actual_hours: null,
                    description: '',
                    status: 'open',
                    start_date: '',
                    due_date: '',
                    assign_id: null,
                    category_id: null
                },
            };
        },
        methods: {
            async createIssue(data) {
                const { slug } = this.$route.params;
                this.loading = true;
                const { data: { data: issue } } = await store(slug, data);
                this.loading = false;
                console.log(issue);
                this.$router.push(`/projects/${slug}/issues`);
            }
        },
    };
</script>

<style>

</style>