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
            v-model="assign"
            size="medium"
            placeholder="Assign"
            clearable
            filterable
            @change="filter('assign')"
        >
            <ElOption
                v-for="item in users"
                :key="item.id" :label="item.name"
                :value="item.id"
            />
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
    </div>
</template>

<script>
    import filter from '~/mixins/filter';
    import { getUsers, getCategories } from '~/api/projects.js';
    import { get } from '~/api/milestones.js';
    export default {
        mixins: [filter],
        async asyncData({ params }) {
            const slug = params;
            const {data: { data: users } } = await getUsers(slug);
            const {data: { data: categories } } = await getCategories(slug);
            return {
                users,
                categories,
            }
        },
        data() {
            const {
                type,
                assign,
                priority,
                milestone,
                category
            } = this.$route.query;            
            return {
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
                this.type = this.$route.query.type ?? null;
                this.assign = this.$route.query.assign ?? null;
                this.priority = this.$route.query.priority ?? null;
                this.milestone = this.$route.query.milestone ?? null;
                this.category = this.$route.query.category ?? null;
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