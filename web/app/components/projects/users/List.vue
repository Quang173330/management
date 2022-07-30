<template>
    <ul>
        <li v-for="permission in permissions" :key="permission.id" class="mb-4">
            <Item
                :permission="permission"
                :edit="edit"
                :loading="loading"
                :index-clicked-delete="indexClickedDelete"
                :owner-id="ownerId"
                :remove="remove"
            />
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
            permissions: {
                type: Array,
                required: true,
            },
            edit: {
                type: Function,
                required: true,
            },
            loading: {
                type: Boolean,
                required: true,
            },
            indexClickedDelete: {
                type: Number,
                required: true,
            },
            ownerId: {
                type: Number,
                required: true,
            },
            remove: {
                type: Function,
                required: true,
            },
        },
    };
</script>
