import { parse, parseISO } from 'date-fns';

/**
 * @param {string} date
 * @param {string|null} fromFormat
 */
export function parseDateString(date, fromFormat) {
    return fromFormat
        ? parse(date, fromFormat)
        : parseISO(date);
}
