<template>
    <div class="min-h-full py-4 bg-white">
        <div class="pb-6">
            <ProjectInformation :current-project="currentProject" :update="update" :server-errors="serverErrors" />
        </div>
        <h1 class="font-bold text-xl text-neutral-800 mb-4">
            List Categories
        </h1>
        <div>
            <ElButton type="primary" class="float-right" @click="() => $refs.categoryForm.open()">Add Category</ElButton>
            <ElTable class="mt-5" :data="categories">
                <ElTableColumn label="Name" >
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.name }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Issues">
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.total_issue }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Created at">
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.created_at | formatDate }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Action" width="200">
                    <template slot-scope="{ row }">
                        <ElButton size="mini" @click.prevent="editCategory(row)">Edit</ElButton>
                        <ElButton size="mini" @click.prevent="destroyCategory(row)">Delete</ElButton>
                    </template>
                </ElTableColumn>
            </ElTable>
            <CategoryForm ref="categoryForm" :save="saveCategory" />
        </div>

        <h1 class="font-bold mt-5 text-xl text-neutral-800 mb-4">
            List Milestones
        </h1>
        <div>
            <ElButton type="primary" class="float-right" @click="() => $refs.milestoneForm.open()">Add Milestone</ElButton>
            <ElTable class="mt-5" :data="milestones">
                <ElTableColumn label="Name" >
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.name }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Issues">
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.total_issue }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Created at">
                    <template slot-scope="{ row }">
                        <span class="font-medium truncate">{{ row.created_at | formatDate }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Action" width="200">
                    <template slot-scope="{ row }">
                        <ElButton size="mini" @click.prevent="editMilestone(row)">Edit</ElButton>
                        <ElButton size="mini" @click.prevent="destroyMilestone(row)">Delete</ElButton>
                    </template>
                </ElTableColumn>
            </ElTable>
            <MilestoneForm ref="milestoneForm" :save="saveMilestone" />
        </div>
    </div>
</template>

<script>
    import _mapValues from 'lodash/mapValues';
    import _concat from 'lodash/concat';
    import _findIndex from 'lodash/findIndex';
    import _filter from 'lodash/filter';
    import { mapState } from 'vuex';
    import {
        update,
        getCategories,
        storeCategory,
        updateCategory,
        destroyCategory
    } from '~/api/projects';
    import { get, store as storeMilestone, update as updateMilestone, destroy as destroyMilestone } from '~/api/milestones.js';
    import ProjectInformation from '~/components/projects/settings/ProjectInformation.vue';
    import CategoryForm from '~/components/projects/categories/CategoryForm.vue';    
    import MilestoneForm from '~/components/projects/milestones/MilestoneForm.vue';    

    export default {
        components: {
            ProjectInformation,
            CategoryForm,
            MilestoneForm,
        },
        inject: ['setBreadcrumb'],
        props: {
            currentProject: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                serverErrors: {},
            };
        },

        async asyncData({ params, query }) {
            const { slug } = params;

            const {data: { data: milestones } } = await get(slug);
            const {data: { data: categories } } = await getCategories(slug);
            return {
                milestones, categories
            };
        },
        computed: {
            ...mapState('organization', ['organization']),
            links() {
                const { slug } = this.$route.params;
                return [
                    { icon: 'folder-open', title: `${this.currentProject.name}`, link: `/projects/${slug}` },
                    { icon: 'cog', title: 'Settings', link: `/projects/${slug}/settings` },
                ];
            },
        },
        watch: {
            currentProject() {
                this.setBreadcrumb(this.links);
            },
        },
        created() {
            this.setBreadcrumb(this.links);
        },
        methods: {

            async saveCategory(data) {
                const action = data.id ? this.updateCategory(data) : this.createCategory(data);

                await action;
                this.$refs.categoryForm.close();
            },

            editCategory(category) {
                this.$refs.categoryForm.open(category);
            },
            async createCategory(data) {
                try {
                    const { slug } = this.$route.params;
                    const { data: {data: category} } = await storeCategory(slug, data);
                    this.categories = _concat(category, this.categories);
                    this.$message.success('Create category success');
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

            async updateCategory(data) {
                try {
                    const { slug } = this.$route.params;
                    const { data : { data: category } } = await updateCategory(slug, data.id, data);
                    const indexParent = _findIndex(this.categories, ['id', category.id]);
                    if (indexParent !== -1) {
                        this.categories.splice(indexParent, 1, category);
                    }
                    this.$message.success('Update category success');
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

            editMilestone(milestone) {
                this.$refs.milestoneForm.open(milestone);
            },


            async saveMilestone(data) {
                const action = data.id ? this.updateMilestone(data) : this.createMilestone(data);

                await action;
                this.$refs.milestoneForm.close();
            },

            async createMilestone(data) {
                try {
                    const { slug } = this.$route.params;
                    const { data: {data: milestone} } = await storeMilestone(slug, data);
                    this.milestones = _concat(milestone, this.milestones);
                    this.$message.success('Create milestone success');
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

            async updateMilestone(data) {
                try {
                    const { slug } = this.$route.params;
                    const { data : { data: milestone } } = await updateMilestone(slug, data.id, data);
                    const indexParent = _findIndex(this.milestones, ['id', milestone.id]);
                    if (indexParent !== -1) {
                        this.milestones.splice(indexParent, 1, milestone);
                    }
                     this.$message.success('Update milestone success');
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


            async update(data) {
                try {
                    const slug  = this.organization.slug;
                    const { data: {data: project} } = await update(slug, data.slug, data);
                    this.currentProject = project;
                    this.$message.success('Update project success');
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

            async destroyCategory(category) {
                try {
                    await this.$confirm(`Do you want to delete <b>${category.name}</b>?`, 'Delete category', {
                        dangerouslyUseHTMLString: true,
                    });
                    await destroyCategory(this.currentProject.slug, category.id);
                    this.categories = _filter(this.categories, (item) => item.id !== category.id);
                    this.$message.success('Success remove category');
                } catch (e) {
                    console.log(e)
                    if (e !== 'cancel') {
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },

            async destroyMilestone(milestone) {
                try {
                    await this.$confirm(`Do you want to delete <b>${milestone.name}</b>?`, 'Delete milestone', {
                        dangerouslyUseHTMLString: true,
                    });
                    await destroyMilestone(this.currentProject.slug, milestone.id);
                    this.milestones = _filter(this.milestones, (item) => item.id !== milestone.id);
                    this.$message.success('Success remove milestone');
                } catch (e) {
                    console.log(e)
                    if (e !== 'cancel') {
                        this.$message.error('Something went wrong, please try again later');
                    }
                }
            },
        },
    };
</script>