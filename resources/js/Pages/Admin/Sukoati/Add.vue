<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import AppIcon from "@/Components/Icon/AppIcon.vue";
import Card from "@/Components/Cards/Card.vue";
import Headers from "@/Components/Headers/Headers.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ToastList from '@/Components/Notifications/ToastList.vue';
import toast from '@/Stores/toast.js';
import draggable from "vuedraggable";
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia'
</script>

<template>
    <Head>
        <title>Tambah {{ display_name }}</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            Form Tambah Data
        </template>
        <template #notif>

            <ToastList />

        </template>

        <template #header>

            <headers>

                <template #kontenheader>

                    <Vueform>
                        <!-- <TextElement input-type="number" rules="min=0"/> -->

                    </Vueform>
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
                                            {{ display_name }}
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
                    <!-- <div class="max-w-full flex-grow p-4 ml-4">
                                        <h3 class="font-semibold text-lg"
                                            :class="[color === 'light' ? 'text-white' : 'text-white']">
                                            {{ display_name }}
                                        </h3>
                                        <Vueform>
                                            <DatesElement name="dates" />
                                        </Vueform>
                                    </div> -->
                    <div class="bg-white w-full transform transition-all sm:w-full sm:mx-auto ">
                        
        
                            <div class="relative pt-4 px-6 pb-4 mx-2 flex-auto">
                              
                                <Vueform :endpoint="false" @submit="simpan" ref="form$" v-model="data" sync :schema="schema">
                                
                                </Vueform>
                            
                            </div>
                            
                        </div>
                    <template #footercard>
                    
                    </template>
                </card>
            </div>
        </div>
        
    </AdminLayout>
</template>


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
        slug : String,
        action : String, 
        display_name : String,
        isiData : Object

    },
    
    components: {
        draggable,
        AppIcon
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
            data : this.isiData?this.isiData:{},
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
            Inertia.get(route(this.slug+'.index'), {}, { replace: true })
        },
        simpan() {
            if (this.action === '.update') {
                this.$inertia.put(route(this.slug+this.action, this.isiData.id), _.omit(this.data, ['id']) ,{
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                            if(this.$page.props.flash.message != null){
                                toast.add({
                                    message: this.$page.props.flash.message,
                                    category : 'info'
                                });
                            }
                        },
                        onFinish:()=>{
                            this.$page.props.flash.message = null;
                            this.$refs.form$.resetValidators();
                            this.$refs.form$.clearMessages()
                        },
                        onError: (errors) => {
                            toast.add({
                                    message: this.$page.props.errors.error ,
                                    category : 'warning',
                                    duration : 10000
                                });
                            
                            this.$refs.form$.messageBag.append(errors);
                        }
                })

            } else {
                this.$inertia.post(route(this.slug+this.action),this.data, {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            if(this.$page.props.flash.message != null){
                                toast.add({
                                    message: this.$page.props.flash.message,
                                    category : 'info'
                                });
                            }
                            this.data = {}
                        },
                        onFinish:()=>{
                            this.$page.props.flash.message = null;
                            this.$refs.form$.reset()
                            this.$refs.form$.resetValidators();
                            this.$refs.form$.clearMessages()
                        },
                        onError: (errors) => {
                            toast.add({
                                    message: this.$page.props.errors.error ,
                                    category : 'warning',
                                    duration : 10000
                                });
                            this.$refs.form$.messageBag.append(errors);
                        }
                })
            
            }


            
        },
        
    
    },
};
</script>
