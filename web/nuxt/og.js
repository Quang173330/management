import { APP_URL } from './env';

export default {
    meta: [
        {
            hid: 'og:title',
            property: 'og:title',
            content: 'Products Monitoring',
        },
        {
            hid: 'og:description',
            property: 'og:description',
            content: 'Sun* Product Quality Platform',
        },
        {
            hid: 'og:image',
            property: 'og:image',
            content: `${APP_URL}/icon.png`,
        },
        {
            hid: 'og:url',
            property: 'og:url',
            content: APP_URL,
        },
        {
            hid: 'og:type',
            property: 'og:type',
            content: 'website',
        },
        {
            hid: 'twitter:title',
            name: 'twitter:title',
            content: 'Sun* CI',
        },
        {
            hid: 'twitter:card',
            name: 'twitter:card',
            content: 'summary',
        },
    ],
};
