export default ({ store, redirect }) => {
    if (store.state.auth.user) {
        if (window.location.pathname !== '/') {
            redirect(`/${window.location.search.slice(13)}`);
        } else {
            redirect('/');
        }
    }
};
