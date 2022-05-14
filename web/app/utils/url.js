export class URLGenerator {
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    generate(path, opts = {}) {
        const url = new URL(this.baseURL);

        const { hash, query = {} } = opts;

        url.pathname = path;
        url.hash = hash || '';
        url.search = new URLSearchParams(query);

        return url.toString();
    }
}
