import Vue from 'vue';
import formatDate from '~/filters/formatDate';
import formatDuration from '~/filters/formatDuration';
import formatDiffForHumans from '~/filters/formatDiffForHumans';
import formatNumber from '~/filters/formatNumber';
import humanizeBytes from '~/filters/humanizeBytes';
import humanizeTime from '~/filters/humanizeTime';

export default () => {
    Vue.filter('formatDuration', formatDuration);
    Vue.filter('formatDate', formatDate);
    Vue.filter('formatDiffForHumans', formatDiffForHumans);
    Vue.filter('formatNumber', formatNumber);
    Vue.filter('humanizeBytes', humanizeBytes);
    Vue.filter('humanizeTime', humanizeTime);
};
