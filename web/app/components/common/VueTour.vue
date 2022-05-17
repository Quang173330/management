<template>
    <div>
        <div v-show="overlay" class="vue-tour-overlay" />
        <v-tour
            name="tour"
            :steps="steps"
            :callbacks="vueTourCallbacks"
            :options="{ highlight: true }"
        >
            <template slot-scope="tour">
                <transition name="fade">
                    <v-step
                        v-if="tour.steps[tour.currentStep]"
                        :key="tour.currentStep"
                        :step="tour.steps[tour.currentStep]"
                        :previous-step="tour.previousStep"
                        :next-step="tour.nextStep"
                        :stop="tour.stop"
                        :skip="tour.skip"
                        :is-first="tour.isFirst"
                        :is-last="tour.isLast"
                        :labels="tour.labels"
                        :highlight="tour.highlight"
                    >
                        <div slot="actions">
                            <ElButton v-if="!tour.isLast" type="primary" @click="tour.skip">
                                Skip
                            </ElButton>
                            <ElButton v-if="!tour.isFirst" type="primary" @click="tour.previousStep">
                                Previous
                            </ElButton>
                            <ElButton v-if="!tour.isLast" type="primary" @click="tour.nextStep">
                                Next
                            </ElButton>
                            <ElButton v-if="tour.isLast" type="primary" @click="tour.stop">
                                Finish
                            </ElButton>
                        </div>
                    </v-step>
                </transition>
            </template>
        </v-tour>
    </div>
</template>
<script>
    import Storage from 'store';
    import _assign from 'lodash/assign';

    export default {
        props: {
            steps: {
                type: Array,
                default: () => [],
            },
            callbacks: {
                type: Object,
                default: () => {},
            },
            name: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
                overlay: false,
            };
        },

        computed: {
            vueTourCallbacks() {
                return _assign({}, this.callbacks, {
                    onStart: this.onStart,
                    onSkip: this.onFinish,
                    onFinish: this.onFinish,
                    onStop: this.onFinish,
                });
            },
        },

        methods: {
            onStart() {
                this.overlay = true;
            },

            onFinish() {
                const triggedVueTour = JSON.parse(Storage.get('vue_tour', '[]'));

                if (!triggedVueTour.includes(this.name)) {
                    triggedVueTour.push(this.name);
                }

                Storage.set('vue_tour', JSON.stringify(triggedVueTour));

                this.overlay = false;
            },
        },
    };
</script>

<style lang="scss">
    .v-tour__target--highlighted {
        box-shadow: none;
    }

    .vue-tour-overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0,0,0,.75);
        z-index: 999;
    }
</style>
