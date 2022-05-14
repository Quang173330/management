import _get from 'lodash/get';
import _mapValues from 'lodash/mapValues';
import _flow from 'lodash/flow';
import _startCase from 'lodash/fp/startCase';
import _lowerCase from 'lodash/fp/lowerCase';
import _upperFirst from 'lodash/fp/upperFirst';

const validation = {
    required: '{field} is required',
    type: '{field} must be a valid {value}',
    pattern: '{field} must match the pattern {value}',
    min: '{field} must be at least {value} charaters',
    max: '{field} must not be longer than {value} characters',
    length: '{field} must be {value} characters',
    enum: '{field} must be a value in {value}',
};

const getValidationMessage = (rule, { field, value }) => {
    const msg = _get(validation, rule)
        .replace('{field}', field)
        .replace('{value}', value);

    return _flow(
        _startCase,
        _lowerCase,
        _upperFirst,
    )(msg);
};

function collectServerError(errors) {
    return _mapValues(errors, '0');
}

function parseValue(value) {
    if (typeof value !== 'string') {
        return value;
    }

    if (value === 'true') {
        return true;
    }

    if (value === 'false') {
        return false;
    }

    if (/,/.test(value)) {
        return value.split(',');
    }

    const number = Number(value);
    if (!Number.isNaN(number)) {
        return number;
    }

    return value;
}

function handleError(error) {
    if (error === false) {
        return;
    }

    if (error.response) {
        if (error.response.status === 419) {
            this.$message.error('Your session has expired, try reloading the page');
        } else if (error.response.status === 422) {
            this.serverErrors = collectServerError(error.response.data.errors);
        } else if (error.response.data.message) {
            this.$message.error(error.response.data.message);
        } else {
            this.$message.error('Something went wrong, please try again later');
        }
    } else {
        throw error;
    }
}

export default {
    data: () => ({
        processing: false,
        serverErrors: {},
        rules: [],
    }),

    computed: {
        formRules() {
            return _mapValues(this.rules, (spec, fieldName) => {
                if (typeof spec !== 'string') {
                    return spec;
                }

                let field = fieldName;

                return spec.split('|').map((rule) => {
                    const [main, ...options] = rule.split(';');

                    const [assert, is = true] = main.split(':');
                    const value = parseValue(is);

                    if (assert === 'name') {
                        field = value;
                        return null;
                    }

                    const extras = options.reduce((acc, opt) => {
                        const [extraField, extraFieldValue] = opt.split(':');

                        return {
                            ...acc,
                            [extraField]: parseValue(extraFieldValue),
                        };
                    }, {});

                    return {
                        [assert]: value,
                        message: getValidationMessage(assert, { field, value, extras }),
                        ...extras,
                    };
                }).filter(Boolean);
            });
        },
    },

    methods: {
        async submit(form, send) {
            this.serverErrors = {};

            try {
                this.processing = true;

                if (form.model) {
                    await form.validate();
                }

                const response = await send(form.model);
                this.$emit('saved', response ? response.data : null);
            } catch (error) {
                handleError.call(this, error);
            } finally {
                this.processing = false;
            }
        },

        clearError(form) {
            if (form) {
                form.clearValidate();
            }
            this.serverErrors = {};
        },

        resetForm(form) {
            if (form) {
                form.resetFields();
            }
        },
    },
};
