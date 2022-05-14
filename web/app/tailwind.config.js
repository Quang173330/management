const colors = require('./tailwindcss/colors');

module.exports = {
    important: true,
    purge: false,
    future: {
        purgeLayersByDefault: true,
        removeDeprecatedGapUtilities: true,
    },
    theme: {
        fontFamily: {
            sans: [
                'Roboto',
                '-apple-system',
                'BlinkMacSystemFont',
                '"Segoe UI"',
                '"Helvetica Neue"',
                'Arial',
                'sans-serif',
                '"Apple Color Emoji"',
                '"Segoe UI Emoji"',
                '"Segoe UI Symbol"',
            ],
            mono: [
                'SFMono-Regular',
                'Menlo',
                'Monaco',
                'Consolas',
                'Liberation Mono',
                'Courier New',
                'monospace',
            ],
        },
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            xxl: '1440px',
        },
        colors: colors.theme,
        container: {
            screens: {
                sm: '640px',
                md: '768px',
                lg: '1024px',
                xl: '1280px',
            },
        },
        colorScheme: {
            black: '#282a36',
            red: '#ff5c57',
            green: '#5af78e',
            yellow: '#f3f99d',
            blue: '#57c7ff',
            purple: '#ff6ac1',
            cyan: '#9aedfe',
            white: '#f1f1f0',
            background: '#282a36',
            foreground: '#eff0eb',
            ghost: '#c0c4cc',
            blankBackground: '#f2f2f2',
        },
    },
    variants: {
        borderWidth: ['first'],
    },
    plugins: [],
};
