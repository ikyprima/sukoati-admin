<script setup>
import AdminLayout from '@/Layouts/Admin.vue';

import Card from "@/Components/Cards/Card.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Dialog from '@/Components/Dialog.vue';
import Table from "@/Components/Tables/Table.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import NProgress from 'nprogress'
import ToastList from '@/Components/Notifications/ToastList.vue';
import toast from '@/Stores/toast.js';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import draggable from "vuedraggable";

</script>

<template>
    <Head>
        <title>Manajemen Menu </title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen database
        </template>
        <template #notif>
            <ToastList />
        </template>
        <template #header>
            <header-stats>

                <template #kontenheader>
                
                </template>
                

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">

            <div class="w-full mb-12 px-4">
                <card :minheigth="'min-h-0'">
                    <template #headercard>
                        <div class="pt-2 pb-2 mx-8 border-b border-solid border-blueGray-200 ">
                            <div class="flex flex-wrap items-center">
                                <div class="max-w-full flex-grow">
                                    <h3 class="font-semibold text-lg">
                                        Form Builder
                                    </h3>
                                
                                </div>
                                <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right">
                                    <div class="hidden md:block">
                                        <PrimaryButton
                                            class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">Kembali
                                        </PrimaryButton>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                        <template>
                        
                        </template>
                        
                        
                    </template>
                    <div>

                    </div>

                </card>
            </div>

        </div>

    </AdminLayout>
</template>

<script>

export default {
  
   
   
    components: {
        
       
    },
    computed: {
     
    },
   
    data() {

        return {
        
       
        };
    },
    created() {

    },
    methods: {
    
    },
};
</script>


