<template>
    <ul class="py-5">
        <li v-for="organization in organizations" :key="organization.id" class="mb-5">
            <Item :organization="organization" />
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
            organizations: {
                type: Array,
                required: true,
            },
        },
    };
</script>
