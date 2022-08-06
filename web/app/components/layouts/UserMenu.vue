<template>
    <ElDropdown>
        <div class="flex items-center">
            <ElAvatar :src="user.avatar_url" class="w-9 h-9" />
            <div class="font-bold xs:test-sm md:text-base xs:ml-2 md:ml-3 flex items-center">
                <p class="truncate">
                    {{ user.name }}
                </p>
                <i class="el-icon-arrow-down el-icon--right xs:ml-3 md:ml-8" />
            </div>
        </div>

        <ElDropdownMenu slot="dropdown">
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
