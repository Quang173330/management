<template>
    <div class="px-5 min-h-full py-4 bg-white user-settings">
        <div class="md:flex w-full justify-between">
            <UserFilter class="xs:w-full md:w-1/2" />

            <ElButton
                :disabled="!currentProject.permission.write"
                type="primary"
                @click="() => $refs.form.open()"
            >
                <div class="flex items-center justify-center gap-4">
                    <Ionicon name="add" size="lg" />
                    <span class="text-base font-bold">Invite user</span>
                </div>
            </ElButton>
        </div>

        <UserForm ref="form" :save="save" />

        <div data-v-step="2">
            <div v-if="permissions.length > 0" class="mt-4">
                <UserList
                    :permissions="permissions"
                    :edit="edit"
                    :loading="loading"
                    :index-clicked-delete="indexClickedDelete"
                    :owner-id="currentProject.owner.id"
                    :current-permission="currentProject.permission"
                    :remove="remove"
                />

                <Pagination :data="pagination" />
            </div>

            <div v-else>
                <ElAlert
                    class="my-4"
                    title="You don't have any members in projects yet!"
                    type="info"
                    show-icon
                    :closable="false"
                    size="sm"
                >
                    <span>Click invite memeber button to add member to your projects</span>
                </ElAlert>
            </div>
        </div>
    </div>
</template>

<script>
    import Storage from 'store';
    import _concat from 'lodash/concat';
    import _assign from 'lodash/assign';
    import _omit from 'lodash/omit';
    import _filter from 'lodash/filter';
    import _findIndex from 'lodash/findIndex';
    import {
        inviteUser, getUsers, removeUser, updatePermissionUser,
    } from '~/api/projects';
    import role from '~/mixins/role';
    import UserForm from '~/components/projects/users/UserForm.vue';
    import UserList from '~/components/projects/users/List.vue';
    import UserFilter from '~/components/projects/users/UserFilter.vue';
    import Pagination from '~/components/common/Pagination.vue';

    export default {
        components: {
            UserForm,
            UserList,
            UserFilter,
            Pagination,
        },

        mixins: [role],

        inject: ['setBreadcrumb'],

        props: {
            currentProject: {
                type: Object,
                required: true,
            },
        },

        async asyncData({ params, query }) {
            const { slug } = params;

            const { data: { data, meta } } = await getUsers(slug,  {...query});

            return {
                permissions: data,
                pagination: meta,
                loading: false,
                indexClickedDelete: 0,
                loadingDelete: false,
                editableTabsValue: '0',
            };
        },

        head() {
            return {
                title: `Users · ${this.currentProject.name}`,
            };
        },

        computed: {
            links() {
                const { slug } = this.$route.params;

                return [
                    { icon: 'folder-open', title: `${this.currentProject.name}`, link: `/projects/${slug}` },
                    { icon: 'cog', title: 'Settings', link: `/projects/${slug}/settings` },
                    { icon: 'people', title: 'Members', link: `/projects/${slug}/settings/users` },
                ];
            },
        },

        watchQuery: true,

        created() {
            this.setBreadcrumb(this.links);
        },

        methods: {
            openUserForm() {
                this.$refs.form.open();
            },
            async remove(permission) {
                try {
                    const { slug } = this.$route.params;

                    this.loading = true;
                    this.indexClickedDelete = permission.id;
                    await this.$confirm(`Do you want to remove user <b>${permission.user.name}</b>?`, 'Remove user', {
                        dangerouslyUseHTMLString: true,
                    });

                    await removeUser(slug, permission.id);

                    this.permissions = _filter(this.permissions, (item) => item.id !== permission.id);
                    if (permission.user.id === this.currentProject.permission.user_id) {
                        this.$store.commit('projects/removeProject', this.currentProject);
                        this.$router.push('/projects');
                    }
                    this.$message.success('Success remove user');
                } catch (e) {
                    if (e.response && e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    } else if (e !== 'cancel') {
                        this.$message.error('Something went wrong, please try again later');
                    }
                } finally {
                    this.loading = false;
                    this.indexClickedDelete = 0;
                }
            },

            edit(subscription) {
                const formData = _assign(
                    subscription,
                    { role: this.convertRoles(subscription) },
                );
                this.$refs.form.open(formData);
            },
            async save(data) {
                const formData = _assign(
                    this.mappingRoles(data.role),
                    _omit(data, ['role']),
                );
                const action = data.id ? this.update(data.id, this.mappingRoles(data.role)) : this.create(formData);

                await action;
                this.$refs.form.close();
            },

            async create(data) {
                try {
                    const { slug } = this.$route.params;
                    const { data: { data: permission } } = await inviteUser(slug, data);
                    const indexParent = _findIndex(this.permissions, ['id', permission.id]);
                    if (indexParent === -1) {
                        this.permissions = _concat(permission, this.permissions);
                    } else {
                        this.$message.error('Sorry, that user has already been invited');
                    }
                } catch (e) {
                    if (e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },

            async update(id, changes) {
                try {
                    const { slug } = this.$route.params;
                    const { data: { data: permission } } = await updatePermissionUser(id, slug, changes);
                    const indexParent = _findIndex(this.permissions, ['id', permission.id]);
                    if (indexParent !== -1) {
                        this.permissions.splice(indexParent, 1, permission);
                    }
                    if (!permission.admin && permission.user.id === this.currentProject.permission.user_id) {
                        this.$router.push('/projects');
                    }
                } catch (e) {
                    if (e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    }
                }
            },
        },
    };
</script>

<style>
    .user-settings{
        height: 700px;
    }

</style>
