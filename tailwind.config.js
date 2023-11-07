const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    mode: 'jit',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js',
        './resources/js/vueform.config.js', // or where `vueform.config.js` is located
        './node_modules/@vueform/vueform/themes/tailwind/**/*.vue',
        './node_modules/@vueform/vueform/themes/tailwind/**/*.js',
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
            'w-0',
            'w-px',	
            'w-0.5',	
            'w-1',
            'w-1.5',	
            'w-2',	
            'w-2.5',	
            'w-3',	
            'w-3.5',	
            'w-4',	
            'w-5',	
            'w-6',	
            'w-7',	
            'w-8',
            'w-9',	
            'w-10',	
            'w-11',	
            'w-12',	
            'w-14',	
            'w-16',	
            'w-20',	
            'w-24',	
            'w-28',	
            'w-32',	
            'w-36',	
            'w-40',	
            'w-44',	
            'w-48',	
            'w-52',	
            'w-56',	
            'w-60',	
            'w-64',	
            'w-72',	
            'w-80',	
            'w-96',
            'w-auto'

        
    ],

    theme: {
        minHeight: {
            '1/2': '50%',
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            minHeight: (theme) => ({
                ...theme('spacing'),
            }),
        
        },
    
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tw-elements/dist/plugin'),
        require('tailwind-animatecss'),
        require('@vueform/vueform/tailwind'),
    ],
    // daisyui: {
    
    //     prefix: "daisy-",
    //     themes: false,
    //   },
};
