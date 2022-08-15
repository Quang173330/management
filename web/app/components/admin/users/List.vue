<template>
    <ElTable :data="users" fit cell-class-name="pr-6">
        <ElTableColumn label="User">
            <template slot-scope="{ row }">
                <div class="flex items-center">
                    <ElAvatar
                        v-if="row.avatar_url"
                        :src="row.avatar_url"
                        size="large"
                        class="mr-2"
                    />
                    <Ionicon v-else name="person-circle" class="ml-px mr-2 w-10 h-10" />
                    <div v-if="row.name">
                        <h4 class="font-medium">
                            {{ row.name }}
                            <i
                                v-if="row.is_admin"
                                v-tooltip
                                title="Admin"
                                class="el-icon-s-tools text-gray-600 ml-2"
                            />
                            <i
                                v-else
                                v-tooltip
                                title="User"
                                class="el-icon-user-solid text-gray-600 ml-2"
                            />
                        </h4>
                        <div>{{ row.email }}</div>
                    </div>
                    <div v-else>
                        <h4 class="font-medium">
                            {{ row.email }}
                            <i
                                v-if="row.is_admin"
                                v-tooltip
                                title="Admin"
                                class="el-icon-s-tools text-gray-600 ml-2"
                            />
                            <i
                                v-else
                                v-tooltip
                                title="User"
                                class="el-icon-user-solid text-gray-600 ml-2"
                            />
                        </h4>
                    </div>
                </div>
            </template>
        </ElTableColumn>
        <ElTableColumn label="Name">
            <template slot-scope="{ row }">
                <div>{{ row.name }}</div>
            </template>
        </ElTableColumn>
        <ElTableColumn label="Provider">
            <template slot-scope="{ row }">
                <div>{{ row.provider }}</div>
            </template>
        </ElTableColumn>
        <ElTableColumn width="150px">
            <template slot-scope="{ row }">
                <ElButton icon="el-icon-edit" size="mini" @click="edit(row)" />
            </template>
        </ElTableColumn>
    </ElTable>
</template>

<script>
    export default {

        props: {
            users: {
                type: Array,
                required: true,
            },
            update: {
                type: Function,
                required: true,
            },
            edit: {
                type: Function,
                required: true,
            },
            changeActive: {
                type: Function,
                required: true,
            },
        },
        data() {
            return {
                processing: false,
            };
        },

        methods: {
            switchTooltip(isActive) {
                return isActive ? 'Disable user' : 'Enable user';
            },

            toggle() {
                this.processing = !this.processing;
            },

            toggleActive() {
                this.visible = false;
                this.changeActive(this.monitor);
            },
            role(user) {
                return user.is_admin ? 'Admin' : 'User';
            },
        },
    };
</script>
