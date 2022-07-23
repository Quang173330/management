<template>
    <ElForm label-position='left' :rules="rules" class="m-5" ref="form" :model="form" label-width="150px">
        <ElFormItem label="Title" prop="title">
            <ElInput placeholder="Issue title" v-model="form.title"></ElInput>
        </ElFormItem>
        <ElFormItem label="Type" prop="type">
            <ElSelect v-model="form.type" placeholder="Issue type">
                <ElOption label="Feature" value="feature"></ElOption>
                <ElOption label="Task" value="task"></ElOption>
                <ElOption label="Bug" value="bug"></ElOption>
            </ElSelect>
        </ElFormItem>
        <ElFormItem label="Description" prop="description">
            <ElInput placeholder="Issue description" type="textarea" :rows="5" v-model="form.description"></ElInput>
        </ElFormItem>
        <div class="flex">
            <ElFormItem label="Start Date" prop="start_date">
                <ElDatePicker placeholder="Start Date" type="date" v-model="form.start_date"/>
            </ElFormItem>
            <ElFormItem class="ml-10" label="Due Date" prop="due_date">
                <ElDatePicker placeholder="Due Date" type="date" v-model="form.due_date"/>
            </ElFormItem>
        </div>
        <div class="flex">
            <ElFormItem label="Priority" prop="priority">
                <ElSelect v-model="form.priority" placeholder="Priority">
                    <ElOption label="High" value="high"></ElOption>
                    <ElOption label="Normal" value="normal"></ElOption>
                    <ElOption label="Low" value="low"></ElOption>
                </ElSelect>
            </ElFormItem>
            <ElFormItem class="ml-8" label="Milestone" prop="milestone">
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
            <ElFormItem label="Category" prop="category_id">
                <ElSelect v-model="form.category_id" placeholder="Select category">
                    <ElOption
                        v-for="item in categories"
                        :key="item.id" :label="item.name"
                        :value="item.id"
                    />
                </ElSelect>            
            </ElFormItem>
            <ElFormItem class="ml-8" label="Assign" prop="assign_id">
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
            <ElFormItem label="Estimated Hours" prop="estimated_hours">
                <ElInput type="number" placeholder="Estimated Hours" v-model="form.estimated_hours"></ElInput>
            </ElFormItem>
            <ElFormItem class="ml-14" label="Actual Hours" prop="actual_hours">
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
                this.getData();
        },
        
        data() {
            return {
                users: [],
                milestones: [],
                categories: [],
                loading: false,
                form: {
                    parent_id: null,
                    title: '',
                    milestone: null,
                    type: 'task',
                    priority: 'normal',
                    estimated_hours: null,
                    actual_hours: null,
                    description: '',
                    status: 'open',
                    start_date: '',
                    due_date: '',
                    assign_id: null,
                    category_id: null
                },
                rules: {
                    title: [
                        { required: true, message: 'Please input issue title', trigger: 'blur' },
                    ],
                    type: [
                        {required: true, message: 'Please select issue type', trigger: 'change'}
                    ],
                    description: [
                        { required: true, message: 'Please input issue description', trigger: 'blur' }
                    ],
                    due_date: [
                        { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                    ],
                    start_date: [
                        { type: 'date', required: true, message: 'Please pick a time', trigger: 'change' }
                    ],
                    milestone: [
                        {required: true,  message: 'Please select Activity zone', trigger: 'change'}
                    ],
                    priority: [
                        {required: true,  message: 'Please select issue priority', trigger: 'change'}
                    ],
                    estimated_hours: [
                        {required: true,  message: 'Please select issue priority', trigger: 'change'}
                    ],
                    actual_hours: [
                        {required: true,  message: 'Please select issue priority', trigger: 'change'}
                    ],
                    assign_id: [
                        {required: true,  message: 'Please select issue priority', trigger: 'change'}
                    ],
                    category_id: [
                        {required: true,  message: 'Please select issue priority', trigger: 'change'}
                    ],
                }
            };
        },
        methods: {
            async getData() {
                const { slug } = this.$route.params;
                const {data: { data: milestones } } = await get(slug);
                const {data: { data: users } } = await getUsers(slug);
                const {data: { data: categories } } = await getCategories(slug);
                this.milestones = milestones;
                this.users = users;
                this.categories = categories;
            },
            async createIssue(data) {
                try {
                    this.$refs.form.validate();
                    const { slug } = this.$route.params;
                    this.loading = true;
                    const { data: { data: issue } } = await store(slug, data);
                    console.log(issue);
                    this.$router.push(`/projects/${slug}/issues`);
                    this.$message.success('Create issue success');    
                    // this.$refs.form.validate(async (valid) => {
                    //     if (valid) {
                    //         const { slug } = this.$route.params;
                    //         this.loading = true;
                    //         const { data: { data: issue } } = await store(slug, data);
                    //         console.log(issue);
                    //         this.$router.push(`/projects/${slug}/issues`);
                    //         this.$message.success('Create issue success');                        
                    //     }
                    // });
                } catch (e) {
                    if(e.response.status === 422) {
                        this.$message.error('Error, Invalid input');
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }
                } finally {
                    this.loading = false;
                }

            }
        },
    };
</script>

<style>

</style>