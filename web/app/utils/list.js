import _findIndex from 'lodash/findIndex';
import _merge from 'lodash/merge';

/**
 * @param {Array} list
 * @param {Object} item
 * @param {string} key
 *
 * @returns {Array}
 */
export function put(list, item, key = 'id') {
    const updatedIndex = _findIndex(list, { [key]: item[key] });

    if (updatedIndex === -1) {
        return list;
    }

    const updatedItem = _merge({}, list[updatedIndex], item);

    return [
        ...list.slice(0, updatedIndex),
        updatedItem,
        ...list.slice(updatedIndex + 1),
    ];
}
