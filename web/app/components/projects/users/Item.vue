<template>
    <ElCard
        body-style="padding: 0"
        class="border-0 shadow-main"
    >
        <div
            class="flex items-center justify-between lg:justify-end w-full h-73"
        >
            <div class="lg:flex-1 flex lg:p-4 px-4 lg:px-7 min-w-0 truncate xs:w-4/5 md:w-1/2">
                <div class="flex items-center">
                    <ElAvatar
                        v-if="permission.user.avatar_url"
                        :src="permission.user.avatar_url"
                        class="mr-2 w-12 h-12"
                    />
                    <Ionicon v-else name="person-circle" class="ml-px mr-2 w-10 h-10" />
                    <div>
                        <div class="flex mb-1">
                            <h4 class="font-blod text-base text-neutral-800">
                                {{ name(permission.user) }}
                            </h4>
                            <span
                                class="md:hidden font-medium text-10 pt-1 px-2
                                bg-lightgray cursor-default ml-2 text-neutral-800"
                            >
                                {{ role(permission) }} {{ isOwner(permission) ? '(Owner)' : '' }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-base text-neutral-400">
                                {{ permission.user.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="hidden md:block md:w-1/3 lg:p-4 lg:px-8 items-center
                leading-normal"
            >
                <span class="text-neutral-400 text-xs font-medium">Role</span>
                <div class="my-2">
                    <span class="font-medium text-sm text-neutral-800">
                        {{ role(permission) }} {{ isOwner(permission) ? '(Owner)' : '' }}
                    </span>
                </div>
            </div>

            <div
                class="xs:w-1/5 md:hidden h-full sm:gap-x-2 flex justify-center items-center
                border-l border-background-light-gray text-center"
            >
                <ElButton
                    class="flex justify-center items-center text-system-warning-500
                    p-0 w-7 h-7 border-0 ml-0"
                    @click.stop.prevent="edit(permission)"
                >
                    <Ionicon
                        name="pencil"
                        class="w-7 h-7"
                        variant="filled"
                    />
                </ElButton>
                <ElButton
                    class="flex justify-center items-center text-system-error-500
                    p-0 w-7 h-7 border-0 ml-0"
                    @click.stop.prevent="() => $refs.dialog.open()"
                >
                    <Ionicon
                        name="trash"
                        class="w-7 h-7"
                        variant="filled"
                    />
                </ElButton>
            </div>
            <div
                class="xs:hidden md:flex md:w-60 h-full justify-center
                items-center border-l border-background-light-gray"
            >
                <ElButton
                    class="flex justify-center items-center bg-system-warning-500 text-neutral-0 text-13
                    p-0 w-16 h-8 border-0 ml-0"
                    @click.stop.prevent="edit(permission)"
                >
                    Edit
                </ElButton>
                <ElButton
                    class="flex justify-center items-center bg-system-error-500 text-neutral-0 text-13
                    p-0 w-82 h-8 border-0 ml-2"
                    @click.stop.prevent="remove(permission)"
                >
                    Remove
                </ElButton>
            </div>
        </div>
    </ElCard>
</template>

<script>
    export default {
        props: {
            permission: {
                type: Object,
                required: true,
            },
            edit: {
                type: Function,
                required: true,
            },
            loading: {
                type: Boolean,
                required: true,
            },
            indexClickedDelete: {
                type: Number,
                required: true,
            },
            ownerId: {
                type: Number,
                required: true,
            },
            remove: {
                type: Function,
                required: true,
            },
        },

        methods: {
            name(user) {
                return user.name ?? user.email;
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

            isOwner(permission) {
                return permission.user.id === this.ownerId;
            },
        },
    };
</script>
