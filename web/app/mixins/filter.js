import _flow from 'lodash/flow';
import _omit from 'lodash/fp/omit';
import _set from 'lodash/fp/set';

export default {
    methods: {
        filter(name) {
            const value = this[name];

            // Merge if value is not empty and remove the query if value is empty
            const mergeQuery = value ? _set(name, value) : _omit(name);

            const query = _flow(
                mergeQuery,
                _omit('page'),
            )(this.$route.query);

            this.$router.push({ query });
        },
    },
};
