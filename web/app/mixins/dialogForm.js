import _clone from 'lodash/clone';
import formMixin from './form';

export default (getDefaultFormValues) => ({
    mixins: [formMixin],

    data: () => ({
        show: false,
        editing: null,
        form: getDefaultFormValues(),
    }),

    watch: {
        editing(to) {
            this.form = to ? _clone(to) : getDefaultFormValues();
        },
    },

    methods: {
        open(runner) {
            this.editing = runner;
            this.show = true;
        },

        close() {
            this.show = false;
        },

        clear(form) {
            this.editing = null;
            this.form = getDefaultFormValues();
            this.$nextTick(() => {
                this.clearError(form);
            });
        },
    },
});
