import {
    formatDistanceToNow, parseISO,
} from 'date-fns';

/**
 * @param {Date|string} time
 */
export default (time) => formatDistanceToNow(parseISO(time), { addSuffix: true });
