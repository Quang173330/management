import _flow from 'lodash/flow';
import _isEmpty from 'lodash/isEmpty';
import _replace from 'lodash/fp/replace';
import _trimChars from 'lodash/fp/trimChars';

function setRouteName(route, parent) {
    route.name = _flow(
        (name) => (parent ? `${parent.name}/${name}` : name),
        _replace(/(^|\/)?:([a-zA-Z0-9?]+)(\/|$)/g, '$1{$2}$3'),
        _trimChars('/'),
    )(route.path);

    if (!_isEmpty(route.children)) {
        route.children.forEach((childRoute) => setRouteName(childRoute, route));
    }
}

export function finalizeRoutes(routes) {
    routes.forEach((route) => setRouteName(route));
}
