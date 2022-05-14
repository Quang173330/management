import favicon from './favicon';
import og from './og';
import { mergeWithArrayConcat } from './utils';

const head = {
    title: 'Products Monitoring',

    meta: [
        {
            hid: 'description',
            name: 'description',
            content: 'Sun* Product Quality Platform',
        },
        {
            name: 'viewport',
            content: 'width=device-width, initial-scale=1',
        },
    ],

    link: [
        {
            rel: 'stylesheet',
            href: 'https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&subset=vietnamese',
        },
    ],

    script: [
        {
            type: 'module',
            src: 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.1.2/ionicons/ionicons.esm.js',
        },
        {
            nomodule: '',
            src: 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.1.2/ionicons/ionicons.js',
        },
    ],
};

export default mergeWithArrayConcat(head, favicon, og);
