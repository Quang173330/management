import Vue from 'vue';

import Ionicon from '~/components/Ionicon.vue';

Vue.config.ignoredElements = ['ion-icon'];

export default () => {
    Vue.component('Ionicon', Ionicon);
};
