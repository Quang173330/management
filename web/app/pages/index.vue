<template>
    <div v-if="organization" class="mx-20 my-10">
        <div v-if="!editing" class="text-xl text-center font-bold">{{organization.name}} <i class="el-icon-edit cursor-pointer text-xl ml-1 mt-1" @click="editOrganization()" /> </div>
        <OrganizationForm v-else="editing" :cancel="cancel" :editing="editing" :save="saveOrganization" :server-errors="serverErrors" :organization="organization" />
        <div class="my-10 mt-10">
            <ElCard class="w-full" shadow="never">
                <div slot="header" class="clearfix">
                    <span>List Projects</span>
                    <el-button style="float: right; padding: 3px 0" type="text" @click="() => $refs.projectForm.open()">Create Project</el-button>
                </div>

                <Pagination :data="paginationProject" />
                <div v-for="project in projects" :key="project.id" class="mb-4 md:mb-6">
                    <ElCard shadow="never" body-style="padding: 0">
                        <div class="flex items-center justify-between h-24">
                            <nuxt-link
                                :to="`/projects/${project.slug}?sort_by=RECENTLY_UPDATE`"
                                class="flex w-7/12 sm:w-3/5 md:w-1/2 xl:w-3/5 justify-start"
                            >
                                <div class="hidden w-24 xl:flex justify-center items-center">
                                    <Ionicon
                                        name="document"
                                        size="md"
                                        class="not-italic text-base h-14 text-primary-500"
                                        variant="filled"
                                    />
                                </div>
                                <div class="flex flex-col p-4 w-full lg:max-w-xs xl:max-w-lg">
                                    <nuxt-link
                                        :to="`/projects/${project.slug}?sort_by=RECENTLY_UPDATE`"
                                        class="font-bold text-neutral-800 break-words hover:text-blue-700 mb-2 text-base"
                                    >
                                        <p class="truncate">
                                            {{ project.name }}
                                        </p>
                                    </nuxt-link>
                                    <p class="text-neutral-400 font-medium text-base truncate">
                                        {{ project.description }}
                                    </p>
                                </div>
                            </nuxt-link>

                            <div class="flex lg:w-1/2 xl:w-2/5 justify-end items-center">
                                <div class="flex flex-col gap-1 items-center justify-center w-20 md:w-24 lg:w-36">
                                    <nuxt-link :to="`projects/${project.slug}/settings/users`" class="flex -space-x-4 cursor-pointer">
                                        <ElAvatar
                                            v-for="user in project.users.slice(0.3)"
                                            :key="user.id"
                                            class="w-10 h-10 border-2 border-white rounded-full"
                                            :src="user.avatar_url"
                                        />
                                    </nuxt-link>
                                    <span class="hidden lg:block text-neutral-400 text-xs font-medium">
                                        {{ project.users.length }} people in project
                                    </span>
                                </div>

                                <Time title="Created time" :start-time="project.created_at" class="hidden xl:flex" />
                                <div class="mr-5">
                                    <ElButton
                                        :disabled="!project.permission.write"
                                        @click.prevent="editProject(project)"
                                    >
                                        <Ionicon
                                            name="pencil"
                                            variant="filled"
                                        />
                                    </ElButton>

                                    <ElButton
                                        :disabled="!project.permission.admin"
                                        @click.prevent="() => $refs.dialog.open()"
                                    >
                                        <Ionicon
                                            name="trash"
                                            variant="filled"
                                        />
                                    </ElButton>
                                </div>
                            </div>
                        </div>
                    </ElCard>
                </div>
                <Pagination :data="paginationProject" />
                <ProjectForm ref="projectForm" :save="saveProject"/>
            </ElCard>
        </div>
        <div class="my-10 mt-10">
            <UserForm ref="form" :save="save" />
            <ElCard class="w-full" shadow="never">
                <div slot="header" class="clearfix">
                    <span>List Users</span>
                    <el-button style="float: right; padding: 3px 0" type="text" @click="() => $refs.form.open()">Invite Member</el-button>
                </div>
                <div v-if="permissions.length > 0" class="mt-4">
                    <UserList
                        :permissions="permissions"
                        :edit="edit"
                        :loading="loading"
                        :index-clicked-delete="indexClickedDelete"
                        :owner-id="organization.owner.id"
                        :remove="remove"
                    />

                    <Pagination :data="pagination" />
                </div>
            </ElCard>
        </div>
    </div>

    <div v-else class="mx-20 my-10">
        <OrganizationForm :save="saveOrganization" :server-errors="serverErrors" />
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import _concat from 'lodash/concat';
    import _assign from 'lodash/assign';
    import _omit from 'lodash/omit';
    import _filter from 'lodash/filter';
    import _findIndex from 'lodash/findIndex';
    import Time from '~/components/common/Time.vue';
    import {
        store, getProjects, update
    } from '~/api/projects';
    import {
        getOrganizations, getUsers, inviteUser, updatePermissionUser, removeUser, store as storeOrganization, update as updateOrganization
    } from '~/api/organizations';
    import role from '~/mixins/role';
    import UserForm from '~/components/projects/users/UserForm.vue';
    import ProjectForm from '~/components/projects/ProjectForm.vue';
    import UserList from '~/components/projects/users/List.vue';
    import UserFilter from '~/components/projects/users/UserFilter.vue';
    import Pagination from '~/components/common/Pagination.vue';
    import OrganizationForm from '~/components/organizations/OrganizationForm.vue';
    import _mapValues from 'lodash/mapValues';

    export default {
        layout: 'blank',
        components: {
            Time,
            UserForm,
            UserList,
            UserFilter,
            Pagination,
            ProjectForm,
            OrganizationForm,
        },
        mixins: [role],
        middleware: ['auth'],
        inject: ['setBreadcrumb'],

        async asyncData({ params, query }) {

            const {data : {data: organization } } =  await getOrganizations();
            console.log(organization)
            if(organization) {
                const { data: {data : projects, meta: paginationProject} } = await getProjects(organization.slug ,  {...query});
                const { data: { data, meta } } = await getUsers(organization.slug,  {...query});

                return {
                    organization,
                    projects,
                    paginationProject,
                    permissions: data,
                    pagination: meta,
                    loading: false,
                    indexClickedDelete: 0,
                    loadingDelete: false,
                    editableTabsValue: '0',
                    serverErrors: {},
                    editing: false,
                };
            } else {
                return {
                    organization,
                    serverErrors: {},
                    editing: false,
                }
            }


        },
        watchQuery: true,

        methods: {
            editOrganization(){
                this.editing = true;
                console.log('sasa')
            },
            openUserForm() {
                this.$refs.form.open();
            },
            async remove(permission) {
                try {
                    const slug = this.organization.slug;

                    this.loading = true;
                    this.indexClickedDelete = permission.id;
                    await this.$confirm(`Do you want to remove user <b>${permission.user.name}</b>?`, 'Remove user', {
                        dangerouslyUseHTMLString: true,
                    });

                    await removeUser(slug, permission.id);

                    this.permissions = _filter(this.permissions, (item) => item.id !== permission.id);
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

            async saveOrganization(data) {
                const action = data.id ? this.updateOrganization(data) : this.createOrganization(data);
            },

            async createOrganization(data) {
                try {
                    const { data : { data: organization } } = await storeOrganization(data);
                    location.reload();
                    this.$message.success('Organization create success');
                    this.serverErrors = {};
                } catch (error) {
                    if (error.response.status === 422) {
                        this.serverErrors = _mapValues(error.response.data.errors, '0');
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }                 
                }
            },

            async updateOrganization(data) {
                try {
                    const { data : { data: organization } } = await updateOrganization(data.id, data);
                    this.organization = organization;
                    this.$message.success('Organization update success');
                    this.serverErrors = {};
                    this.editing = false;
                } catch (error) {
                    if (error.response.status === 422) {
                        this.serverErrors = _mapValues(error.response.data.errors, '0');
                    } else {
                        this.$message.error('Something went wrong, please try again later');
                    }                 
                }
            },

            async cancel() {
                this.editing = false;
            },

            editProject(project) {
                this.$refs.projectForm.open(project);
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

            async saveProject(data) {
                const action = data.id ? this.updateProject(data) : this.createProject(data);

                await action;
                this.$refs.projectForm.close();
            },

            async createProject(data) {
                try {
                    const slug  = this.organization.slug;
                    const { data: {data: project} } = await store(slug, data);
                    console.log(project)
                    this.projects = _concat(project, this.projects);
                    this.$message.success('Create project success');
                } catch (e) {
                    if (e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    } else if(e.response.status === 422){
                        this.$message.error(e.response.data.message);
                    }
                    else{
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },


            async updateProject(data) {
                try {
                    const slug  = this.organization.slug;
                    const { data: {data: project} } = await update(slug, data.slug, data);
                    const indexParent = _findIndex(this.projects, ['id', project.id]);
                    if (indexParent !== -1) {
                        this.projects.splice(indexParent, 1, project);
                    }
                } catch (e) {
                    if (e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    } else if(e.response.status === 422){
                        this.$message.error(e.response.data.message);
                    } else{
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },

            async create(data) {
                try {
                    const slug  = this.organization.slug;
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
                    } else if(e.response.status === 422){
                        console.log(e.response);
                        this.$message.error(e.response.data.message);
                    }
                    else{
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },

            async update(id, changes) {
                try {
                    const slug  = this.organization.slug;
                    const { data: { data: permission } } = await updatePermissionUser(id, slug, changes);
                    const indexParent = _findIndex(this.permissions, ['id', permission.id]);
                    if (indexParent !== -1) {
                        this.permissions.splice(indexParent, 1, permission);
                    }
                } catch (e) {
                    console.log('s')
                    if (e.response.status === 403) {
                        this.$message.error(e.response.data.message);
                    }
                }
            },
        },
    };
</script>

<style>
    .card-organization{
        width: 48%;
    }
</style>
