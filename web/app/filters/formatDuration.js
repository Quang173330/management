import _flow from 'lodash/flow';
import _floor from 'lodash/fp/floor';
import _padCharsStart from 'lodash/fp/padCharsStart';

/**
 * @param   {number} time Total amount of time
 * @param   {number} a Amount of seconds the larger magnitude unit is worth
 * @param   {number} b Amount of seconds this unit is worth
 * @param   {number} zeroPad Amount of zero to pad start
 * @returns {string}
 */
function toUnit(time, a, b, zeroPad = 0) {
    return _flow(
        _floor,
        _padCharsStart('0', zeroPad),
    )((time % a) / b);
}

/**
 * Turn a time duration in seconds to a hour:minutes:seconds format
 *
 * @param   {number|string} time Time duration in seconds
 * @returns {string}
 */
export default (time) => {
    if (Number.isNaN(parseInt(time, 10))) {
        return '';
    }

    const days = Math.floor(time / 86400);
    const hours = toUnit(time, 86400, 3600);
    const minutes = toUnit(time, 3600, 60);
    const seconds = toUnit(time, 60, 1);

    if (days > 0) {
        return `${days} ${days > 1 ? 'days' : 'day'} ${hours}h ${minutes}m ${seconds}s`;
    }

    if (hours > 0) {
        return `${hours}h ${minutes}m ${seconds}s`;
    }

    if (minutes > 0) {
        return `${minutes}m ${seconds}s`;
    }

    return `${seconds}s`;
};
