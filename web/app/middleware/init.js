export default ({ store, error }) => {
    if (!store.state.initError) {
        return;
    }

    const { response } = store.state.initError;
    const statusCode = response ? response.status : 500;

    error({ statusCode });
};
