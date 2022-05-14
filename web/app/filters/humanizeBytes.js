import _find from 'lodash/find';
import _findLast from 'lodash/findLast';

const table = [
    { exp: 0, unit: 'bytes', text: 'bytes' },
    { exp: 10, unit: 'kb', text: 'KB' },
    { exp: 20, unit: 'mb', text: 'MB' },
    { exp: 30, unit: 'gb', text: 'GB' },
    { exp: 40, unit: 'tb', text: 'TB' },
    { exp: 50, unit: 'pb', text: 'PB' },
];

/**
 * @param   {number} size
 * @param   {number} exp
 * @returns {number}
 */
function round(size, exp) {
    return exp >= 10 ? size.toFixed(2) : Math.floor(size);
}

/**
 * @param   {number} size
 * @param   {string} unit
 * @returns {string}
 */
export default (size = 0, unit = 'bytes') => {
    const fromExp = _find(table, { unit }).exp;

    const exp = size > 0 ? Math.log2(size * (2 ** fromExp)) : fromExp;
    const range = _findLast(table, (row) => exp >= row.exp);

    const rounded = range.unit !== unit
        ? round(size / (2 ** (range.exp - fromExp)), range.exp)
        : size;

    return `${rounded} ${range.text}`;
};
