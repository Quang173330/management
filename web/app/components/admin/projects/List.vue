<template>
    <ul class="py-5">
        <li v-for="project in projects" :key="project.id" class="mb-5">
            <Item :project="project" />
        </li>
    </ul>
</template>

<script>
    import Item from './Item.vue';

    export default {
        components: {
            Item,
        },

        props: {
            projects: {
                type: Array,
                required: true,
            },
        },
    };
</script>
