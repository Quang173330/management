<template>
    <div>
        <ElInput
            v-model="email"
            class="max-w-sm"
            size="medium"
            placeholder="Search by email"
            suffix-icon="el-icon-search"
            clearable
            type="email"
            @keyup.native.enter="setQuery()"
            @clear="filter('email')"
        />
    </div>
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

        methods: {
            setQuery() {
                if (this.validEmail(this.email)) {
                    this.filter('email');
                }
            },
            validEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
        },
    };
</script>
