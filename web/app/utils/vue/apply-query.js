import _flow from 'lodash/flow';
import _omit from 'lodash/fp/omit';
import _set from 'lodash/fp/set';

export default function queryAdd(queries, name, value, overrides = []) {
    // Merge if value is not empty and remove the query if value is empty
    const mergeQuery = value ? _set(name, value) : _omit(name);

    return _flow(
        mergeQuery,
        _omit(overrides),
    )(queries);
}
