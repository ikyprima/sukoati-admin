<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import Card from "@/Components/Cards/Card.vue";
import Headers from "@/Components/Headers/Headers.vue";
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import ToastList from '@/Components/Notifications/ToastList.vue';
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'
import toast from '@/Stores/toast.js';
import draggable from "vuedraggable";
import VueJsoneditor from 'vue3-ts-jsoneditor';

</script>

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
                                            <PrimaryButton v-on:click="kembali"
                                                class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">
                                                Kembali</PrimaryButton>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </template>

                    <div class="bg-white overflow-hidden w-full transform transition-all sm:w-full sm:mx-auto ">
                            <div class="relative px-6 pb-4 mx-2 flex-auto">
                                
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mt-2 ">
                                    <Vueform :schema="schema"></Vueform>
                                </div>
                                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                                    <div class="relative  ">
                                        <InputLabel for="displayName" value="Display Name" class="" />
                                        <TextInput id="displayName" ref="displayNameInput" type="text"
                                            class="mt-1 block w-full" 
                                            placeholder="display name" />
                                    </div>
                                    <div class="relative  ">
                                        <InputLabel for="urlSlug" value="URL Slug" class="" />
                                        <TextInput id="urlSlug" ref="urlSlugInput" type="text" class="mt-1 block w-full"
                                            placeholder="URL slug" />
                                    </div>
                                </div>
                               
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
        form: Object,
        action : String,
        slug : String

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
        
            schema: {
                name: { type: 'text', label: 'Name' },
                email: { 
                    type: 'text',
                    inputType: 'password',
                    label: 'Passwordsss',
                    columns : {container: 12, label: 3, wrapper: 12 },
                    overrideClass:{
                        inputContainer: 'border border-gray-300 w-full transition-all rounded-sm shadow-sm',
                        inputContainer_default: 'border-black',
                        inputContainer_focused: '',
                        inputContainer_md: '',
                    }
                }
            }
        };
    },

    computed: {
    
    },

    validations() {

    },


    methods: {
        kembali() {
            Inertia.get(route('builder.index'), {}, { replace: true })
        },
        simpan() {
            if (this.action === 'update') {
                this.formBuilder.put(route('database.update'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.formBuilder.reset();
                    },
                    onError: (errors) => {
                        console.log(errors);
                    }
                })
            }else{
                this.formBuilder.post(route('builder.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.formBuilder.reset();
                    },
                    onError: (errors) => {
                        console.log(errors);
                    }
                })
            }
        },
        
    
    },
};
</script>


