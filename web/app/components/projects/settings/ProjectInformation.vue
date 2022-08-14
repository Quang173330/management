<template>
    <div>
        <span slot="header" class="text-neutral-800 font-bold text-xl">
            Project information
        </span>
        <div>
            <ElForm
                :disabled="!currentProject.permission.write"
                ref="form"
                :model="form"
                :rules="rules"
            >
                <ElFormItem prop="name" :error="serverErrors.name" class="w-full lg:w-1/2">
                    <InputName title="Name" required />
                    <ElInput
                        v-model="form.name"
                        type="text"
                        name="name"
                        class="text-red-500"
                        clearable
                        @keypress.native.enter.prevent
                    />
                </ElFormItem>

                <ElFormItem prop="description" :error="serverErrors.description" class="w-full lg:w-1/2">
                    <InputName title="Description" required />
                    <ElInput
                        v-model="form.description"
                        type="textarea"
                        name="description"
                        :rows="4"
                    />
                </ElFormItem>
            </ElForm>
            <div class="flex justify-between lg:justify-end">
                <ElButton :disabled="!currentProject.permission.write" class="px-8" type="primary" @click="onCancel">
                    Cancel
                </ElButton>
                <ElButton
                    :disabled="!currentProject.permission.write"
                    class="px-8"
                    :loading="processing"
                    type="primary"
                    @click="updateProject(form)"
                >
                    Save
                </ElButton>
            </div>
        </div>
    </div>
</template>

<script>
    import _cloneDeep from 'lodash/cloneDeep';
    import InputName from '~/components/common/input/InputName.vue';
    export default {
        components: {
            InputName,
        },
        props: {
            currentProject: {
                type: Object,
                required: true,
            },
            update: {
                type: Function,
                required: true,
            },
            serverErrors: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                form: _cloneDeep(this.currentProject),
                rules: {
                    name: [
                        { required: true, message: 'Name is required', trigger: 'change' },
                        { type: 'string', message: 'Name must be string', trigger: 'change' },
                    ],
                    description: [
                        { required: true, message: 'Description is required', trigger: 'change' },
                    ],
                },
                processing: false,
            };
        },
        methods: {
            onCancel() {
                this.form = _cloneDeep(this.currentProject);
                this.$message({
                    dangerouslyUseHTMLString: true,
                    message: '<strong>Infor.</strong>Project form has been reset.',
                });
            },
            async updateProject(data) {
                this.processing = true;
                await this.update(data);
                this.processing = false;
            },
        },
    };
</script>
