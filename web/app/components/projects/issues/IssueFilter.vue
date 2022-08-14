<template>
    <div class="content-around">
        <ElSelect
            class="mr-5"
            v-model="type"
            size="medium"
            placeholder="Type"
            clearable
            filterable
            @change="filter('type')"
        >
            <ElOption value="task" label="Task" />
            <ElOption value="feature" label="Feature" />
            <ElOption value="bug" label="Bug" />
        </ElSelect>
        <ElSelect
            class="mr-5"
            v-model="status"
            size="medium"
            placeholder="Status"
            clearable
            filterable
            @change="filter('status')"
        >
            <ElOption value="open" label="Open" />
            <ElOption value="in progress" label="In Progress" />
            <ElOption value="resolved" label="Resolved" />
            <ElOption value="closed" label="Closed" />
        </ElSelect>
        <ElSelect
            class="mr-5"
            v-model="assign"
            size="medium"
            placeholder="Assign"
            clearable
            filterable
            @change="filter('assign')"
        >
            <ElOption
                v-for="item in users"
                :key="item.user.id"
                :value="item.user.id"
                :label="item.user.name"
                class="items-center	flex"
                >
                    <ElAvatar size="small mr-2" :src="item.user.avatar_url"/> {{item.user.name}}
            </ElOption>
        </ElSelect>
        <ElSelect
            class="mr-5"
            v-model="priority"
            size="medium"
            placeholder="Priority"
            clearable
            filterable
            @change="filter('priority')"
        >
            <ElOption value="high" label="High" />
            <ElOption value="normal" label="Normal" />
            <ElOption value="low" label="Low" />
        </ElSelect>
        <ElSelect
            class="mr-5"
            v-model="category"
            size="medium"
            placeholder="Category"
            clearable
            filterable
            @change="filter('category')"
        >
            <ElOption
                v-for="item in categories"
                :key="item.id" :label="item.name"
                :value="item.id"
            />
        </ElSelect>

        <ElSelect
            class="mr-5"
            v-model="milestone"
            size="medium"
            placeholder="Milestone"
            clearable
            filterable
            @change="filter('milestone')"
        >
            <ElOption
                v-for="item in milestones"
                :key="item.id" :label="item.name"
                :value="item.id"
            />
        </ElSelect>

        <ElInput
            v-model="title"
            class="max-w-sm mt-5"
            size="medium"
            placeholder="Filter by title"
            suffix-icon="el-icon-search"
            clearable
            @keyup.native.enter="filter('title')"
            @clear="filter('title')"
        />
    </div>
</template>

<script>
    import filter from '~/mixins/filter';
    import { getUsers, getCategories } from '~/api/projects.js';
    import { get } from '~/api/milestones.js';
    export default {
        mixins: [filter],

        data() {
            const {
                title,
                status,
                type,
                priority,
            } = this.$route.query;

            let {
                assign,
                milestone,
                category,
            } = this.$route.query;
            if(assign) {
                assign = parseInt(assign)
            }
            if(milestone) {
                milestone = parseInt(milestone)
            }
            if(category) {
                category = parseInt(category)
            }

            return {
                title,
                status,
                type,
                assign,
                priority,
                milestone,
                category,
                users: [],
                milestones: [],
                categories: [],
            };
        },
        watch: {
            '$route.query': function watchFilter() {
                this.title = this.$route.query.title ?? null;
                this.status = this.$route.query.status ?? null;
                this.type = this.$route.query.type ?? null;
                this.assign = this.$route.query.assign ? parseInt(this.$route.query.assign) : null
                this.milestone = this.$route.query.milestone ? parseInt(this.$route.query.milestone) : null
                this.category = this.$route.query.category ? parseInt(this.$route.query.category) : null
                this.priority = this.$route.query.priority ?? null;
            },
        },

        created() {
            this.getData();
        },

        methods: {
            async getData() {
                const { slug } = this.$route.params;
                const {data: { data: milestones } } = await get(slug);
                const {data: { data: users } } = await getUsers(slug);
                const {data: { data: categories } } = await getCategories(slug);
                this.milestones = milestones;
                this.users = users;
                this.categories = categories;
            },
        },
    };
</script>