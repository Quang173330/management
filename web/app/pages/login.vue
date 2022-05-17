<template>
    <div class="w-screen h-screen bg-cover relative bg-red-300">
        <div class="absolute inline-block inset-0 w-72 h-60 m-auto border rounded text-center bg-opacity-30 bg-white">
            <button
                class="box-border relative top-1/2 py-0 px-4 text-left border-0
leading-8 rounded-sm text-base text-white bg-blue-800 focus:bg-purple-700
focus:outline-none active:shadow-sm"
                @click="loginGoogle"
            >
                Login with Google
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        middleware: ['guest'],
        methods: {
            loginGoogle() {
                window.location.href = '/api/login/google';
            },
        },
    };
</script>