const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js'
    
        
        
    ],
    safelist: [
    
            'translate-x-[1rem]',
            'translate-x-[2rem]',
            'translate-x-[3rem]',
            'translate-x-[4rem]',
            'translate-x-[5rem]',
            'translate-x-[6rem]',
            'translate-x-[7rem]',
            'translate-x-[8rem]',
            'translate-x-[9rem]',
            'translate-x-[10rem]',
            'translate-x-[11rem]',
            'translate-x-[12rem]',
        
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tw-elements/dist/plugin')
    ],
    // daisyui: {
    
    //     prefix: "daisy-",
    //     themes: false,
    //   },
};
