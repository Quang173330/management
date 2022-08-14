<template>
    <ElDropdown>
        <div>
            Projects<i class="el-icon-arrow-down el-icon--right"></i>
        </div>
        <ElDropdownMenu slot="dropdown">
            <ElDropdownItem v-for="project in projects" :key="project.id">
                <ElButton @click="changeProject(project.slug)" type="text">
                    {{ project.name }}
                </ElButton>
            </ElDropdownItem>
        </ElDropdownMenu>
    </ElDropdown>
</template>

<script>
    import { mapState } from 'vuex';
    import { getProject } from '~/api/projects.js';
    export default {

        data() {
            return {
                defaultActiveSubmenu: [],
            };
        },

        computed: {
            ...mapState('projects', ['projects']),
            ...mapState('organization', ['organization']),
        },

        methods: {
            async changeProject(slug) {
                const {data: {data: project} } = await getProject(this.organization.slug, slug); 
                this.$store.commit('project/setProject', project);
                this.$router.push(`/projects/${project.slug}`);
            }
        }
    };
</script>
