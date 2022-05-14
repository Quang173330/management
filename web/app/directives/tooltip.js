import Tippy from 'tippy.js';
import _find from 'lodash/find';

const placements = [
    'top', 'top-start', 'top-end',
    'right', 'right-start', 'right-end',
    'bottom', 'bottom-start', 'bottom-end',
    'left', 'left-start', 'left-end',
];

/**
 * @param {string[]} modifiers
 */
const getPlacement = (modifiers) => _find(placements, (p) => modifiers[p] === true) || 'bottom';

/**
 * @param {Element} el
 * @param {string[]} modifiers
 */
function createTooltip(el, modifiers) {
    if (!el.hasAttribute('title')) {
        return;
    }

    if (shouldShowTooltip(el, modifiers)) {
        const content = el.getAttribute('title');
        const placement = getPlacement(modifiers);

        Tippy(el, {
            content,
            placement,
            animation: 'shift-away-subtle',
            theme: 'translucent',
            ignoreAttributes: true,
            allowHTML: true,
        });
    }

    el.removeAttribute('title');
}

/**
 * @param {Element} el
 * @param {string[]} modifiers
 */
function updateTooltip(el, modifiers) {
    if (!shouldShowTooltip(el, modifiers)) {
        el._tippy.destroy();
        return;
    }

    if (el.hasAttribute('title')) {
        el._tippy.setContent(el.getAttribute('title'));
        el.removeAttribute('title');
    }

    const placement = getPlacement(modifiers);

    if (el._tippy.placement !== placement) {
        el._tippy.setProps({ placement });
    }
}

/**
 * @param {Element} el
 * @param {string[]} modifiers
 */
function shouldShowTooltip(el, modifiers) {
    return !modifiers.overflow || el.scrollWidth > el.clientWidth;
}

export default {
    /**
     * @param {Element} el
     * @param {object} binding
     * @param {string[]} binding.modifiers
     */
    inserted: (el, { modifiers }) => {
        createTooltip(el, modifiers);
    },

    /** @param {Element} el */
    update: (el, { modifiers }) => {
        if (el._tippy) {
            updateTooltip(el, modifiers);
        } else {
            createTooltip(el, modifiers);
        }
    },

    /** @param {Element} el */
    unbind: (el) => {
        if (el._tippy) {
            el._tippy.destroy();
        }
    },
};
