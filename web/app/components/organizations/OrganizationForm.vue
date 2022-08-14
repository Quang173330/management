<template>
    <div class="w-1/2 m-auto">
        <span slot="header" class="text-neutral-800 font-bold text-xl">
                {{ title }}
        </span>
        <div>
            <ElForm
                ref="form"
                :model="form"
                :rules="rules"
            >
                <ElFormItem prop="name" :error="serverErrors.name">
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

                <ElFormItem prop="description" :error="serverErrors.description">
                    <InputName title="Description" required />
                    <ElInput
                        v-model="form.description"
                        type="textarea"
                        name="description"
                        :rows="4"
                    />
                </ElFormItem>
            </ElForm>
            <div class="flex float-right mb-5">
                <ElButton class="px-8" type="primary" @click="cancel()">
                    Cancel
                </ElButton>
                <ElButton
                    class="px-8"
                    :loading="processing"
                    type="primary"
                    @click="saveOrganization(form)"
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
            organization: {
                type: Object,
                required: false,
            },
            save: {
                type: Function,
                required: true,
            },
            serverErrors: {
                type: Object,
                required: true,
            },
            cancel: {
                type: Function,
            },
            editing : {
                type: Boolean,
            }
        },
        data() {
            let form = {
                name: '',
                description: '',
            }
            if (this.organization) {
                form = _cloneDeep(this.organization)
            }

            return {
                form,
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

        computed: {
            title() {
                return this.organization ? 'Update Organization' : 'Create Organization';
            }
        },
        methods: {
            onCancel() {
                this.editing = false;

            },
            async saveOrganization(data) {
                this.processing = true;
                await this.save(data);
                this.processing = false;
            },
        },
    };
</script>
