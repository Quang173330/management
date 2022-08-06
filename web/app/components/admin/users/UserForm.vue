<template>
    <ElDialog :visible.sync="show" :title="title" @close="clear($refs.form)">
        <ElForm
            ref="form"
            :model="form"
            :rules="formRules"
            label-width="120px"
        >
            <ElFormItem label="Name" prop="name" :error="serverErrors.name">
                <ElInput v-model="form.name" name="name" />
            </ElFormItem>

            <ElFormItem label="Username" prop="username" :error="serverErrors.username">
                <ElInput v-model="form.username" name="username" />
            </ElFormItem>

            <ElFormItem label="Status" prop="is_active" :error="serverErrors.is_active">
                <ElSwitch
                    v-model="form.is_active"
                    active-color="#13ce66"
                />
            </ElFormItem>

            <ElFormItem
                v-if="form.id !== user.id"
                label="Role"
                prop="is_admin"
                :error="serverErrors.is_admin"
            >
                <ElRadio v-model="form.is_admin" :label="true">
                    Admin
                </ElRadio>
                <ElRadio v-model="form.is_admin" :label="false">
                    User
                </ElRadio>
            </ElFormItem>
        </ElForm>

        <div class="text-right">
            <ElButton :loading="processing" type="primary" @click="submit($refs.form, save)">
                Save
            </ElButton>

            <ElButton :disabled="processing" @click="close">
                Cancel
            </ElButton>
        </div>
    </ElDialog>
</template>

<script>
    import { mapState } from 'vuex';
    import dialogForm from '~/mixins/dialogForm';

    const defaultValues = () => ({
        name: '',
        username: '',
    });

    export default {
        mixins: [dialogForm(defaultValues)],

        props: {
            save: {
                type: Function,
                required: true,
            },
        },

        data: () => ({
            rules: {
                name: 'required',
                username: 'required',
            },
        }),

        computed: {
            ...mapState('auth', ['user']),

            title() {
                return this.editing ? 'Edit user' : 'New user';
            },
        },
    };
</script>
