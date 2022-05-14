<template>
    <ion-icon v-bind="styles" :name="iconName" class="ion hydrated" />
</template>

<script>
    export default {
        props: {
            name: String,

            variant: {
                type: String,
                default: 'outline',
            },

            size: {
                type: [String, Number],
                default: 'base',
            },
        },

        computed: {
            iconName() {
                return this.variant === 'filled' || this.name.startsWith('logo-')
                    ? this.name
                    : `${this.name}-${this.variant}`;
            },

            styles() {
                if (typeof this.size === 'number') {
                    return {
                        style: {
                            width: `${this.size}px`,
                            height: `${this.size}px`,
                        },
                    };
                } if (typeof this.size === 'string') {
                    return {
                        class: `ion--${this.size}`,
                    };
                }

                return null;
            },
        },
    };
</script>

<style lang="scss">
    .ion {
        &--xs {
            width: .875rem;
            height: .875rem;
        }

        &--sm {
            width: 1rem;
            height: 1rem;
        }

        &--base {
            width: 1.125rem;
            height: 1.125rem;
        }

        &--md {
            width: 1.25rem;
            height: 1.25rem;
        }

        &--lg {
            width: 1.5rem;
            height: 1.5rem;
        }

        &--xl {
            width: 1.75rem;
            height: 1.75rem;
        }

        &--2xl {
            width: 2rem;
            height: 2rem;
        }

        &--3xl {
            width: 2.5rem;
            height: 2.5rem;
        }
    }
</style>
