<template>
    <ElDropdown>
        <div>
            Projects<i class="el-icon-arrow-down el-icon--right"></i>
        </div>
        <ElDropdownMenu slot="dropdown">
            <ElDropdownItem v-for="project in projects" :key="project.id">
                <ElButton type="text">
                    {{ project.name }}
                </ElButton>
            </ElDropdownItem>
        </ElDropdownMenu>
    </ElDropdown>
</template>

<script>
    import { mapState } from 'vuex';

    export default {

        data() {
            return {
                defaultActiveSubmenu: [],
            };
        },

        computed: {
            ...mapState('projects', ['projects']),
        },
    };
</script>
