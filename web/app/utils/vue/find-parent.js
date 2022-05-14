export default function findParent(vnode, name, attr = '_componentTag', maxSteps = 5) {
    let steps = 1;
    let parent = vnode.$parent;

    while (parent && parent.$options[attr] !== name && steps <= maxSteps) {
        parent = parent.$parent;
        steps += 1;
    }

    return parent && parent.$options[attr] === name ? parent : null;
}
