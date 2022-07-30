<template>
    <ElInput
        v-model="email"
        placeholder="Search by email"
        suffix-icon="el-icon-search"
        clearable
        data-v-step="1"
        @keyup.native.enter="filter('email')"
        @clear="filter('email')"
    />
</template>

<script>
    import filter from '~/mixins/filter';

    export default {
        mixins: [filter],

        data() {
            const { email } = this.$route.query;

            return {
                email,
            };
        },
    };
</script>
