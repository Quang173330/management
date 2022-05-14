import {
    formatDistanceStrict,
} from 'date-fns';

import { parseDateString } from '~/utils/date';

/**
 * @param {Date|string|number} date
 * @param {string} fromFormat
 */
export default (date, fromFormat) => {
    const now = new Date();
    const then = typeof date === 'string' ? parseDateString(date, fromFormat) : date;

    return formatDistanceStrict(then, now, { addSuffix: true });
};
