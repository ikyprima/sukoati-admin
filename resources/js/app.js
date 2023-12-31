import './bootstrap';
// import './tw-element';

import '../css/app.css';
import "@fortawesome/fontawesome-free/css/all.min.css";
// import "../css/tailwind.css"; disable karena bentrok dengan vueform





import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueForm from '@vueform/vueform'
import vueformConfig from './vueform.config'
// import VueMultiselect from 'vue-multiselect'



const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ 
        
            render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mixin({ methods: { 
                hasAnyPermission: function (permissions) {

                    var allPermissions = this.$page.props.auth.can;
                    var hasPermission = false;
                    permissions.forEach(function(item){
            
                        var check = allPermissions.includes(item);
                      // console.log(check); //returns true
                        if (check)
                        {
                        // value exists in array
                        //write some codes
                        hasPermission = true;  
                        }
                      // if(allPermissions[item]) 
                      // hasPermission = true;     
                    });
                
                    return hasPermission;
                    // return hasPermission;
                    // return allPermissions;
                },
            } });
            // myApp.component('VueMultiselect', VueMultiselect)
            myApp.use(VueForm, vueformConfig); //gunakan sebagai plugin
            myApp.mount(el);
            return myApp;

    },
});

InertiaProgress.init({ color: '#4B5563' });
