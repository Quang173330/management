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
                prop="name"
                :error="serverErrors.name"
            >
                <InputName title="Name" required />
                <ElInput v-model="form.name" name="name" />
            </ElFormItem>
        </ElForm>

        <div class="flex gap-x-2 mt-5">
            <ElButton
                class="h-12 w-full text-base leading-130 font-bold bg-secondary-100 text-emerald-600"
                :disabled="processing"
                @click="close"
            >
                Cancel
            </ElButton>
            <ElButton
                class="h-12 w-full text-base leading-130 font-bold text-neutral-0"
                type="primary"
                :loading="processing"
                @click="submit($refs.form, save)"
            >
                Save
            </ElButton>
        </div>
    </ElDialog>
</template>

<script>
    import dialogForm from '~/mixins/dialogForm';
    import InputName from '~/components/common/input/InputName.vue';

    const defaultValues = () => ({
        name: '',
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
                name: 'required',
            },
        }),

        computed: {
            title() {
                return this.editing ? 'Update Milestone' : 'Create Milestone';
            }
        },
    };
</script>

<style lang="scss">
    .el-radio__label {
        width: 100%;
    }
</style>
