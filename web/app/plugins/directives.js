import Vue from 'vue';

import tooltip from '~/directives/tooltip';

export default () => {
    Vue.directive('tooltip', tooltip);
};
