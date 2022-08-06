<template>
    <ElDialog v-if="project" :visible.sync="show" append-to-body>
        <div class="flex justify-between mb-6">
            <h2 class="text-lg font-bold">
                {{ project.name }}
            </h2>
        </div>
        <h3 class="text-lg font-bold">
            List Monitor
        </h3>
        <div class="flex justify-between">
            <ElTable :data="project.monitors" fit>
                <ElTableColumn label="Name">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.name }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Type">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.type }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Url">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.url }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Method">
                    <template slot-scope="{ row }">
                        <span class="font-medium">{{ row.method }}</span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Regions">
                    <template slot-scope="{ row }">
                        <span v-for="item in row.monitor_regions" :key="item.id" class="font-medium">
                            {{ item.region_name }} - {{ item.worker_name }} <br>
                        </span>
                    </template>
                </ElTableColumn>
                <ElTableColumn label="Status" width="100px">
                    <template slot-scope="{ row }">
                        <ElSwitch
                            v-model="row.is_active"
                            active-color="#13ce66"
                            @change="updateActiveMonitor(row)"
                        />
                        <i
                            v-if="loadingActiveMonitor && indexMonitor === row.id"
                            class="el-icon-loading text-gray-600 ml-2"
                        />
                    </template>
                </ElTableColumn>
            </ElTable>
        </div>
        <h3 class="text-lg font-bold mt-6">
            List User
        </h3>
        <div class="flex justify-between">
            <ElTable :data="project.permissions" fit>
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
            project: {
                type: Object,
            },
        },
        data: () => ({
            show: false,
            loadingActiveMonitor: false,
            indexMonitor: null,
        }),

        created() {
        },

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
            async updateActiveMonitor({ id, ...formData }) {
                this.loadingActiveMonitor = true;
                this.indexMonitor = id;
                await updateMonitor(this.project.slug, id, formData).then(({ data: { data: monitor } }) => {
                    const indexParent = _findIndex(this.project.monitors, ['id', monitor.id]);
                    if (indexParent !== -1) {
                        // eslint-disable-next-line vue/no-mutating-props
                        this.project.monitors.splice(indexParent, 1, monitor);
                    }
                });
                this.loadingActiveMonitor = false;
                this.indexMonitor = null;
                this.$message.success(formData.is_active === true ? 'Success enable monitor' : 'Success disable monitor');
            },
        },
    };
</script>
