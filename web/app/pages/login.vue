<template>
    <div class="w-screen h-screen flex md:flex-row flex-col">
        <div class="w-full order-2 md:order-1 flex items-center justify-center">
            <div class="md:ml-15">
                <div class="mb-7 text-center md:text-left">
                    <h3 class="text-emerald-500 text-4xl font-extrabold">
                        Get's started
                    </h3>
                    <span class="text-neutral-400">Only log-in with G-Suite</span>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                    <button
                        class="flex gap-5 items-center justify-center py-2.5 px-4 bg-emerald-500 rounded w-80 md:w-60"
                        @click="loginGoogle"
                    >
                        <Ionicon name="logo-google" class="text-white" size="md" />
                        <span class="truncate text-white font-bold">Login with Google</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        layout: 'login',
        middleware: ['guest'],
        methods: {
            loginGoogle() {
                window.location.href = '/api/login/google';
            },
        },
    };
</script>

<style lang="scss" scoped>
    .bg {
        background: url('~assets/images/login.jpg');
    }
</style>
