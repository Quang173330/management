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
        <el-table class="mt-5" :data="tableData" style="width: 100%">
            <el-table-column prop="date" label="Issue Type" width="150" />
            <el-table-column prop="name" label="Title" width="120" />
            <el-table-column prop="name" label="Assign" width="120" />
            <el-table-column prop="name" label="Status" width="120" />
            <el-table-column prop="name" label="Priority" width="120" />
            <el-table-column prop="name" label="Created" width="120" />
            <el-table-column prop="name" label="Start Date" width="120" />
            <el-table-column prop="name" label="Due Date" width="120" />
            <el-table-column prop="state" label="Estimate Hours" width="120"/>
            <el-table-column prop="city" label="Actual Hours" width="120"/>
            <el-table-column prop="address" label="Updated" width="300"/>
            <el-table-column prop="zip" label="Registered By" width="120"/>
            <el-table-column prop="zip" label="Story Points" width="120"/>
            <el-table-column fixed="right" label="Actions" width="120">
            <template slot-scope="scope">
                <el-button
                @click.native.prevent="deleteRow(scope.$index, tableData)"
                type="text"
                >
                    Edit <i class="el-icon-edit"/>
                </el-button>
            </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
  methods: {
    deleteRow(index, rows) {
      rows.splice(index, 1);
    },
  },
  data() {
    return {
      tableData: [
        {
          date: "2016-05-03",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-02",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-04",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-01",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-08",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-06",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-07",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
               {
          date: "2016-05-03",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-02",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-04",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-01",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-08",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-06",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-07",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
      ],
    };
  },
};
</script>
