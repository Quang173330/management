<template>
    <div class="py-6 px-10 min-h-full bg-white">
        <div class="flex w-full justify-start">
            <UserFilter />
        </div>
        <UserForm ref="form" :save="save" />
        <div>
            <UserList
                :users="users"
                :edit="edit"
                :update="update"
                :change-active="changeActive"
            />
            <Pagination :data="pagination" />
        </div>
    </div>
</template>

<script>
    import _findIndex from 'lodash/findIndex';
    import {
        update,
        getUsers,
    } from '~/api/admin/users';
    import Pagination from '~/components/common/Pagination.vue';
    import UserFilter from '~/components/admin/users/UserFilter.vue';
    import UserList from '~/components/admin/users/List.vue';
    import UserForm from '~/components/admin/users/UserForm.vue';

    export default {
        components: {
            Pagination,
            UserFilter,
            UserList,
            UserForm,
        },

        inject: ['setBreadcrumb'],
        layout: 'admin',
        async asyncData({ query }) {
            try {
                const { data: { data, meta } } = await getUsers(query);

                return {
                    users: data,
                    pagination: meta,
                };
            } catch (err) {
                return {
                    users: [],
                    pagination: [],
                };
            }
        },

        head() {
            return {
                title: 'Users',
            };
        },

        computed: {
            links() {
                return [
                    { icon: 'people', title: 'Users', link: '/admin/users' },
                ];
            },
        },

        watchQuery: true,

        created() {
            this.setBreadcrumb(this.links);
        },

        methods: {
            edit(subscription) {
                this.$refs.form.open(subscription);
            },

            async save(data) {
                const action = this.update;
                await action(data);
                this.$refs.form.close();
            },

            async update(data) {
                await update(data.id, data).then(({ data: { data: user } }) => {
                    const indexParent = _findIndex(this.users, ['id', user.id]);
                    if (indexParent !== -1) {
                        this.users.splice(indexParent, 1, user);
                    }
                });
            },

            async changeActive(data) {
                try {
                    await this.$confirm(`Do you want to ${data.is_active ? 'disable' : 'enable'} this user?`, 'Change active user', {
                        dangerouslyUseHTMLString: true,
                    });
                    data.loading = true;
                    data.is_active = !data.is_active;
                    await update(data.id, data).then(({ data: { data: user } }) => {
                        const indexParent = _findIndex(this.users, ['id', user.id]);
                        if (indexParent !== -1) {
                            this.users.splice(indexParent, 1, user);
                        }
                    });
                    data.loading = false;
                } catch (err) {
                    if (err !== 'cancel') {
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },
        },
    };
</script>
