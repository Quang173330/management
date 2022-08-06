<template>
    <div>
        <div class="float-left">
            <ElInput
                v-model="name"
                class="max-w-lg w-72"
                size="large"
                placeholder="Filter by name organization"
                suffix-icon="el-icon-search"
                clearable
                @keyup.native.enter="filterByName()"
                @clear="filterByName()"
            />
        </div>
    </div>
</template>

<script>
    import filter from '~/mixins/filter';

    export default {
        mixins: [filter],

        data() {
            const { name } = this.$route.query;

            return {
                name,
            };
        },

        methods: {
            filterByName() {
                this.filter('name');
            },
        },
    };
</script>
