<template>
    <ElDialog :visible.sync="show" custom-class="md:w-1/2 xl:w-1/3 w-11/12">
        <div slot="title">
            <p class="text-neutral-800 text-2xl font-bold leading-120">
                {{ title }}
            </p>
        </div>
        <ElForm
            ref="form"
            :model="form"
            :rules="formRules"
            data-v-step="4"
        >
            <ElFormItem
                v-if="!editing"
                prop="email"
                :error="serverErrors.email"
            >
                <InputName title="Email address" required />
                <ElInput v-model="form.email" name="email" />
            </ElFormItem>

            <ElFormItem prop="role" :error="serverErrors.role">
                <InputName title="Role" required />
                <ElRadioGroup
                    v-model="form.role"
                    class="flex flex-col border rounded border-gray-300"
                >
                    <ElRadio label="member" class="flex p-4 text-left">
                        <p class="font-bold capitalize">
                            Member
                        </p>
                        <p class="font-thin text-sm whitespace-normal break-normal">
                            Member can view most data within project
                        </p>
                    </ElRadio>
                    <ElRadio label="manager" class="flex p-4 text-left">
                        <p class="font-bold capitalize">
                            Manage
                        </p>
                        <div class="font-thin text-sm whitespace-normal break-normal">
                            Manager can manage monitor, access settings. Additionally, they have ability to add and
                            remove member of projects that they are member of
                        </div>
                    </ElRadio>
                    <ElRadio label="admin" class="flex p-4 text-left">
                        <p class="font-bold capitalize">
                            Admin
                        </p>
                        <p class="font-thin text-sm whitespace-normal break-normal">
                            Unrestricted access the projects, its data and its settings. Can add. modify,
                            and delete projects and member
                        </p>
                    </ElRadio>
                </ElRadioGroup>
            </ElFormItem>
        </ElForm>

        <div class="flex gap-x-2 mt-5">
            <ElButton
                class="h-12 w-full text-base leading-130 font-bold bg-secondary-100 text-primary-600"
                :disabled="processing"
                @click="close"
            >
                Cancel
            </ElButton>
            <ElButton
                class="h-12 w-full text-base leading-130 font-bold bg-primary-500 text-neutral-0"
                type="primary"
                :loading="processing"
                @click="submit($refs.form, save)"
            >
                {{ confirm }}
            </ElButton>
        </div>
    </ElDialog>
</template>

<script>
    import dialogForm from '~/mixins/dialogForm';
    import InputName from '~/components/common/input/InputName.vue';

    const defaultValues = () => ({
        email: '',
        role: '',
    });

    export default {
        components: {
            InputName,
        },

        mixins: [dialogForm(defaultValues)],

        props: {
            save: {
                type: Function,
                required: true,
            },
        },

        data: () => ({
            rules: {
                email: 'required|type:email',
                role: 'required',
            },
        }),

        computed: {
            title() {
                return this.editing ? 'Update user' : 'Invite new user';
            },

            confirm() {
                return this.editing ? 'Save' : 'Send invite request';
            },
        },
    };
</script>

<style lang="scss">
    .el-radio__label {
        width: 100%;
    }
</style>
