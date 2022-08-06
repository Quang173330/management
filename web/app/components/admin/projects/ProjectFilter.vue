<template>
    <div>
        <div class="float-left">
            <ElInput
                v-model="name"
                class="max-w-lg w-72"
                size="large"
                placeholder="Filter by name project"
                suffix-icon="el-icon-search"
                clearable
                @keyup.native.enter="filterByName()"
                @clear="filterByName()"
            />
        </div>
        <div class="float-left ml-8">
            <ElInput
                v-model="email"
                class="max-w-lg w-72"
                size="large"
                placeholder="Filter by email"
                suffix-icon="el-icon-search"
                clearable
                @keyup.native.enter="filterByEmail()"
                @clear="filterByEmail()"
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
            const { email } = this.$route.query;

            return {
                name,
                email,
            };
        },

        methods: {
            filterByName() {
                if (!this.email && this.$route.query.email) {
                    delete this.$route.query.email;
                }

                this.filter('name');
            },
            filterByEmail() {
                if (!this.name && this.$route.query.name) {
                    delete this.$route.query.name;
                }

                this.filter('email');
            },
        },
    };
</script>
