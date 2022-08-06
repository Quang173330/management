import _filter from 'lodash/filter';
import _maxBy from 'lodash/maxBy';
import _map from 'lodash/map';
import _findKey from 'lodash/findKey';
import _omitBy from 'lodash/omitBy';
import _isNil from 'lodash/isNil';

export default {
    methods: {
        updateActiveItem(ref) {
            const keys = _omitBy(_map(ref.items, 'route'), _isNil);
            const matches = _filter(keys, (key) => (key === this.$route.path || (this.$route.path.startsWith(key) && key !== '/')));

            if (matches.length) {
                if (_maxBy(matches, 'length') === '/') {
                    this.active = 'home';
                } else {
                    this.active = _findKey(ref.items, { route: _maxBy(matches, 'length') });
                }
            } else {
                this.active = null;
            }
        },
    },
};
