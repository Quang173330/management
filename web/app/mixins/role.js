export default {
    methods: {
        mappingRoles(role) {
            return {
                member: {
                    read: true,
                    write: false,
                    admin: false,
                },
                manager: {
                    read: true,
                    write: true,
                    admin: false,
                },
                admin: {
                    read: true,
                    write: true,
                    admin: true,
                },
            }[role];
        },

        convertRoles(permission) {
            if (permission.admin) {
                return 'admin';
            }

            if (permission.write) {
                return 'manager';
            }

            return 'member';
        },
    },
};
