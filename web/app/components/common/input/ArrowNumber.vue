<template>
    <div class="flex flex-col input-number gap-1">
        <span class="h-3.5" @click="change(1)">
            <Ionicon name="arrow-up" class="w-3.5 h-3.5 text-primary-500 cursor-pointer" />
        </span>
        <span class="h-3.5" @click="change(-1)">
            <Ionicon name="arrow-down" class="w-3.5 h-3.5 text-primary-500 cursor-pointer" />
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: [String, Number],
                required: true,
            },
            name: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
                number: parseInt(this.value, 10),
            };
        },

        watch: {
            value(value) {
                this.number = parseInt(value, 10);
            },
        },

        methods: {
            change(number) {
                this.number += number;

                if (this.number < 0) {
                    this.number = 0;
                }
                this.$emit('change', { name: this.name, value: this.number.toString() });
            },
        },
    };
</script>

<style lang="scss">
    .input-number .ion {
        background-color: theme('colors.lightgray');
        border-radius: 4px;
    }
</style>
