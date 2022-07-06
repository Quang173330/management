<template>
    <div class="m-5">
        <div class="align-center">
            <ElSelect
                v-model="is_active"
                size="medium"
                placeholder="Filter by active"
                clearable
                filterable
                @change="filter('is_active')"
            >
                <ElOption value="true" label="true" />
                <ElOption value="false" label="false" />
            </ElSelect>

            <ElSelect
                v-model="is_active"
                size="medium"
                placeholder="Filter by active"
                clearable
                filterable
                @change="filter('is_active')"
            >
                <ElOption value="true" label="true" />
                <ElOption value="false" label="false" />
            </ElSelect>

            <ElSelect
                v-model="style"
                size="medium"
                placeholder="Filter by style"
                clearable
                filterable
                @change="filter('style')"
            >
                <ElOption value="primary" label="primary" />
                <ElOption value="info" label="info" />
                <ElOption value="warning" label="warning" />
                <ElOption value="danger" label="danger" />
            </ElSelect>

            <ElSelect
                v-model="style"
                size="medium"
                placeholder="Filter by style"
                clearable
                filterable
                @change="filter('style')"
            >
                <ElOption value="primary" label="primary" />
                <ElOption value="info" label="info" />
                <ElOption value="warning" label="warning" />
                <ElOption value="danger" label="danger" />
            </ElSelect>

            <ElDatePicker
                v-model="timeRange"
                class="mr-3"
                type="daterange"
                format="yyyy-MM-dd"
                value-format="yyyy-MM-dd"
                range-separator="-"
                start-placeholder="Start date"
                end-placeholder="End date"
                :picker-options="pickerOptions"
                size="medium"
            />

            <ElInput
                v-model="search"
                class="max-w-sm"
                size="medium"
                placeholder="Filter by title"
                suffix-icon="el-icon-search"
                clearable
                @keyup.native.enter="filter('search')"
                @clear="filter('search')"
            />
        </div>
        <ElTable height="500" class="mt-5" :data="issues" style="width: 100%">
            <ElTableColumn label="Issue Type" width="150" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.type }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Title" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.title }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Assign" width="120" >
                <template slot-scope="{ row }">
                    <span v-if="row.assign !== null" class="font-medium break-normal">{{ row.assign.name }}</span>
                    <span v-else>null</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Milestone" width="120" >
                <template slot-scope="{ row }">
                    <span  v-if="row.milestones.length" class="font-medium break-normal">{{ row.milestones[0].name }}</span>
                    <span v-else>null</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Status" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.status }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Category" width="120" >
                <template slot-scope="{ row }">
                    <span v-if="row.category !== null" class="font-medium break-normal">{{ row.category.name }}</span>
                    <span v-else>null</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Priority" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.priority }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="created_at" label="Created" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.created_at | humanizeTime }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn label="Start Date" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.start_date | humanizeTime }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="due_date" label="Due Date" width="120" >
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.due_date | humanizeTime }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="estimated_hours" label="Estimate Hours" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.estimated_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="actual_hours" label="Actual Hours" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.actual_hours }}</span>
                </template>
            </ElTableColumn>
            <ElTableColumn prop="description" label="Description" width="120">
                <template slot-scope="{ row }">
                    <span class="font-medium break-normal">{{ row.description }}</span>
                </template>
            </ElTableColumn
            <ElTableColumn fixed="right" label="Actions" width="120">
                <el-button
                type="text"
                >
                    Edit <i class="el-icon-edit"/>
                </el-button>
            </ElTableColumn>
        </ElTable>
    </div>
</template>

<script>
    import { get } from '~/api/issues.js';
    import { mapState } from 'vuex';
    export default {
        middleware: ['auth'],
        inject: ['setBreadcrumb'],      
        computed: {
            ...mapState('project', ['project']),
            links() {
                return [
                    { icon: 'home', title: this.project.name, link: '/' },
                ];
            },
        },
        created() {
                this.setBreadcrumb(this.links);
        },
        async asyncData({params}) {
            const { slug } = params;
            const {data: { data: issues } } = await get(slug);
            console.log(issues);
            return {
                issues
            };
        },
    };
</script>
