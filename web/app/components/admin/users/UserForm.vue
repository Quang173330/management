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
