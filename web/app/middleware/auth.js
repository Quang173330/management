export default ({ store, redirect }) => {
    if (!store.state.auth.user) {
        if (window.location.pathname !== '/') {
            redirect(`/login?continue=${window.location.pathname}`);
        } else {
            redirect('/login');
        }
    }
};
