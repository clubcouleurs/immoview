const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
      content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/tw-elements/dist/js/**/*.js"

  ],
      
    purge: [
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require("tw-elements/dist/plugin.cjs"),
        require('@tailwindcss/typography'),
        ],

};
