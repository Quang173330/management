<template>
    <ElDropdown>
        <ElAvatar :src="user.avatar_url" />
        <ElDropdownMenu slot="dropdown">
            <ElDropdownItem>{{ user.name }}</ElDropdownItem>

            <ElDropdownItem v-if="user.is_admin">
                <nuxt-link to="/admin" class="flex items-center" target="_blank">
                    <Ionicon name="cog" size="md" class="mr-2" />
                    <span class="truncate">Site admin</span>
                </nuxt-link>
            </ElDropdownItem>

            <ElDropdownItem>
                <ElButton type="text" icon="el-icon-right" @click="logout">
                    Logout
                </ElButton>
            </ElDropdownItem>
        </ElDropdownMenu>
    </ElDropdown>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        computed: {
            ...mapState('auth', ['user']),
        },

        methods: {
            ...mapActions('auth', ['logout']),
        },
    };
</script>
