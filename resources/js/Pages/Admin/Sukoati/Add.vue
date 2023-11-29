
<template>
    <Head>
        <title>Add Builder Form</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            Form Builder
        </template>
        <template #notif>

            <ToastList />

        </template>

        <template #header>

            <headers>

                <template #kontenheader>

                    
                </template>
            </headers>
        </template>
        <div class="flex flex-wrap mt-4 pt-6  ">
            <div class="w-full mb-12 ">
                <card :minheigth="'min-h-32'">
                    <template #headercard>
                            <div
                                class="pt-2 pb-2 z-1 -mt-8 mx-4 rounded-xl bg-gradient-to-r from-emerald-500 to-lime-400 shadow-lg">
                                <div class="flex flex-wrap items-center">
                                    <div class="max-w-full flex-grow p-4 ml-4">
                                        <h3 class="font-semibold text-lg"
                                            :class="[color === 'light' ? 'text-white' : 'text-white']">
                                            Table Info
                                        </h3>
                                    </div>
                                    <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right p-4 mr-4">
                                        <div class="hidden md:block">
                                            <PrimaryButton @click="kembali"
                                                class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">
                                                Kembali</PrimaryButton>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </template>

                    <div class="bg-white overflow-hidden w-full transform transition-all sm:w-full sm:mx-auto ">
                
        
                            <div class="relative px-6 pb-4 mx-2 flex-auto">
                                <Vueform :endpoint="endpoint" ref="form$" v-model="data" sync :schema="schema">
                                
                                </Vueform>
                            
                            </div>
                            
                        </div>
                    <template #footercard>
                        <div class="flex mb-4 mr-6 p-2 justify-end">

                            <PrimaryButton class=" " v-on:click="simpan">
                                <span class="mr-2"> <i class="fas fa-save "></i> </span>
                                Simpan
                            </PrimaryButton>
                        </div>
                    </template>
                </card>
            </div>
        </div>
        
    </AdminLayout>
</template>



<script setup>



import AdminLayout from '@/Layouts/Admin.vue';
import Card from "@/Components/Cards/Card.vue";
import Headers from "@/Components/Headers/Headers.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';

import ToastList from '@/Components/Notifications/ToastList.vue';

import draggable from "vuedraggable";
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia'


</script>

<script>




export default {
    

    props: {
        color: {
            default: "light",
            validator: function (value) {
                // The value must match one of these strings
                return ["light", "dark"].indexOf(value) !== -1;
            },
        },
        formContainer: Object,
        action : String

    },

    components: {
        draggable
    },
    watch: {

    },
    created() {

    },
    data() {

        return {
            options: {
                    minimizable: false,
                    playerSize: "standard",
                    backgroundColor: '#fff',
                    backgroundStyle: 'color',
                    theme: {
                        controlsView: "standard",
                        active: "light",
                        light: {
                            color: '#3D4852',
                            backgroundColor: '#fff',
                            opacity: '0.7',
                        },
                        dark: {
                            color: '#fff',
                            backgroundColor: '#202020',
                            opacity: '0.7',
                        }
                    }
                },
            data : {},
            schema: this.formContainer
        };
    },

    computed: {
    
    },

    validations() {

    },
    mounted() {
        
    },

    methods: {
        kembali() {
            Inertia.get(route('builder.index'), {}, { replace: true })
        },
        endpoints: {
            submit: {
            url: '/form/submsit',
            method: 'post'
            }
        },
      
        simpan() {
            

            // this.$refs.form$.validate()
            console.log(this.$refs.form$.invalid)
            // if (this.$refs.form$.invalid == false) {
            //     console.log('simpan');
            // }else{
            //     console.log('stop');
            // }
            // if ( this.$refs.form$.validate()) {
            //     this.$inertia.post(route(this.action),this.data, {
            //     preserveScroll: true,
            //     preserveState: true,
            //     onSuccess: () => {
            //         this.data ={}
            //         this.$refs.form$.clearMessages()
            //     },
            //     onError: (errors) => {
            //         console.log(errors);
            //     }
            // })
            // }
        
            
        },
        
    
    },
};
</script>
