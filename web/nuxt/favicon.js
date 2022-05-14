export default {
    meta: [
        {
            name: 'msapplication-TileColor',
            content: '#2b5797',
        },
        {
            name: 'theme-color',
            content: '#ffffff',
        },
    ],

    link: [
        {
            rel: 'apple-touch-icon',
            sizes: '180x180',
            href: '/apple-touch-icon.png',
        },
        {
            rel: 'icon',
            hid: 'icon',
            type: 'image/png',
            sizes: '32x32',
            href: '/favicon-32x32.png',
        },
        {
            rel: 'icon',
            type: 'image/png',
            sizes: '16x16',
            href: '/favicon-16x16.png',
        },
        {
            rel: 'manifest',
            href: '/site.webmanifest',
        },
        {
            rel: 'mask-icon',
            href: '/safari-pinned-tab.svg',
            color: '#2d559e',
        },
    ],
};
