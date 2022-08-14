<template>
    <ElDialog v-if="organization" :visible.sync="show" append-to-body>
        <div class="flex justify-between mb-6">
            <h2 class="text-lg font-bold">
                {{ organization.name }}
            </h2>
        </div>
        <h3 class="text-lg font-bold">
            List Projects
        </h3>
        <div class="flex justify-between">
            <ElTable :data="organization.projects" fit>
                <ElTableColumn label="Name">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.name }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Description">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.description }}</span>
                    </template>
                </ElTableColumn>
            </ElTable>
        </div>
        <h3 class="text-lg font-bold mt-6">
            List Users
        </h3>
        <div class="flex justify-between">
            <ElTable :data="organization.permissions" fit>
                <ElTableColumn label="User">
                    <template slot-scope="{ row }">
                        <div class="flex items-center">
                            <ElAvatar
                                v-if="row.user.avatar_url"
                                :src="row.user.avatar_url"
                                size="large"
                                class="mr-2"
                            />
                            <Ionicon v-else name="person-circle" class="ml-px mr-2 w-10 h-10" />
                            <div>
                                <h4 class="font-medium">
                                    {{ row.user.name }}
                                </h4>
                                <div>{{ row.user.email }}</div>
                            </div>
                        </div>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Permission">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ role(row) }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Status" width="100px">
                    <template slot-scope="{ row }">
                        <ElSwitch
                            v-model="row.user.is_active"
                            v-tooltip
                            active-color="#13ce66"
                            disabled
                        />
                    </template>
                </ElTableColumn>
            </ElTable>
        </div>
    </ElDialog>
</template>

<script>
    import _findIndex from 'lodash/findIndex';
    import {
        updateMonitor,
    } from '~/api/admin/projects';

    export default {
        props: {
            organization: {
                type: Object,
            },
        },
        data: () => ({
            show: false,
            loadingActiveMonitor: false,
            indexMonitor: null,
        }),

        methods: {
            open() {
                this.show = true;
            },
            role(permission) {
                if (!permission.user.is_active) {
                    return 'Invited member';
                }

                if (permission.admin) {
                    return 'Admin';
                }

                if (permission.write) {
                    return 'Manager';
                }

                return 'Member';
            },
        },
    };
</script>
