<template>
    <span v-tooltip :title="title" class="ml-2">
        <ElButton v-bind="btnProps" @click="onClick">
            <slot />
        </ElButton>
    </span>
</template>

<script>
    export default {
        props: {
            type: String,
            icon: String,
            title: String,
            action: Function,
            confirm: [String, Object],
            confirmTitle: String,
            data: Object,
        },

        data() {
            return {
                loading: false,
            };
        },

        computed: {
            confirmArgs() {
                const options = {
                    confirmButtonClass: `el-button--${this.type}`,
                    dangerouslyUseHTMLString: true,
                };

                if (typeof this.confirm === 'string') {
                    return [this.confirm, this.confirmTitle, options];
                }

                const { message, title } = this.confirm;

                return [message, title, options];
            },

            btnProps() {
                return {
                    type: this.type,
                    icon: this.icon,
                    size: 'mini',
                    loading: this.loading,
                };
            },
        },

        methods: {
            async onClick() {
                try {
                    if (this.confirm) {
                        await this.$confirm(...this.confirmArgs);
                    }

                    this.loading = true;
                    await this.action(this.data);
                } catch (e) {
                    if (e !== 'cancel') {
                        throw e;
                    }
                } finally {
                    this.loading = false;
                }
            },
        },
    };
</script>
