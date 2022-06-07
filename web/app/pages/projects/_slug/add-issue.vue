<template>
    <ElForm label-position='left' class="m-5" ref="form" :model="form" label-width="120px">
        <ElFormItem label="Title">
            <ElInput placeholder="Issue title" v-model="form.name"></ElInput>
        </ElFormItem>
        <ElFormItem label="Type">
            <ElSelect v-model="form.region" placeholder="Issue type">
                <ElOption label="Feature" value="feature"></ElOption>
                <ElOption label="Task" value="task"></ElOption>
                <ElOption label="Bug" value="bug"></ElOption>
            </ElSelect>
        </ElFormItem>
        <ElFormItem label="Description">
            <ElInput placeholder="Issue description" type="textarea" :rows="5" v-model="form.desc"></ElInput>
        </ElFormItem>
        <div class="flex">
            <ElFormItem label="Start Date">
                <ElDatePicker placeholder="Start Date" type="date" v-model="form.date1"/>
            </ElFormItem>
            <ElFormItem class="ml-10" label="Due Date">
                <ElDatePicker placeholder="Due Date" type="date" v-model="form.date1"/>
            </ElFormItem>
        </div>
        <div class="flex">
            <ElFormItem label="Priority">
                <ElSelect v-model="form.region" placeholder="Issue type">
                    <ElOption label="Feature" value="feature"></ElOption>
                    <ElOption label="Task" value="task"></ElOption>
                    <ElOption label="Bug" value="bug"></ElOption>
                </ElSelect>            
            </ElFormItem>
            <ElFormItem class="ml-8" label="Milestone">
                <ElSelect v-model="form.region" placeholder="Issue type">
                    <ElOption label="Feature" value="feature"></ElOption>
                    <ElOption label="Task" value="task"></ElOption>
                    <ElOption label="Bug" value="bug"></ElOption>
                </ElSelect>            
            </ElFormItem>
        </div>

        <div class="flex">
            <ElFormItem label="Category">
                <ElSelect v-model="form.region" placeholder="Issue type">
                    <ElOption label="Feature" value="feature"></ElOption>
                    <ElOption label="Task" value="task"></ElOption>
                    <ElOption label="Bug" value="bug"></ElOption>
                </ElSelect>            
            </ElFormItem>
            <ElFormItem class="ml-8" label="Assign">
                <ElSelect v-model="form.region" placeholder="Issue type">
                    <ElOption label="Feature" value="feature"></ElOption>
                    <ElOption label="Task" value="task"></ElOption>
                    <ElOption label="Bug" value="bug"></ElOption>
                </ElSelect>            
            </ElFormItem>
        </div>

        <div class="flex">
            <ElFormItem label="Title">
                <ElInput placeholder="Issue title" v-model="form.name"></ElInput>
            </ElFormItem>
            <ElFormItem class="ml-14" label="Title">
                <ElInput placeholder="Issue title" v-model="form.name"></ElInput>
            </ElFormItem>        
        </div>
        <ElFormItem label="Resources">
            <ElRadioGroup v-model="form.resource">
                <ElRadio label="Sponsor"></ElRadio>
                <ElRadio label="Venue"></ElRadio>
            </ElRadioGroup>
        </ElFormItem>
        <ElFormItem label="Activity form">
            <ElInput type="textarea" v-model="form.desc"></ElInput>
        </ElFormItem>
        <ElFormItem>
            <ElButton type="primary">Add</ElButton>
        </ElFormItem>
    </ElForm>
</template>
<script>
    import { mapState } from 'vuex';

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
        data() {
            return {
                form: {
                    parent_id: null,
                    title: '',
                    type: '',
                    priority: null,
                    estimated_hours: null,
                    actual_hours: null,
                    description: '',
                    status: '',
                    start_date: '',
                    due_date: '',
                },
            };
        },
        methods: {
            onSubmit() {
            console.log("submit!");
            },
        },
    };
</script>

<style>

</style>