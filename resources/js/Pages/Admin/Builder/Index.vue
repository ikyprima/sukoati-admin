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
        <title>Builder Menu </title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            builder table 
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
    <Table @klik="klikMethod" :list=tables :header=setting namaTitle='LIST TABLE MySQL'>
        <template #button>

           

            <div class="md:min-w-full md:hidden block">
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <button
                            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                            type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                </div>
            </div>

        </template>
        <template #pencarian>
            <div class="w-full lg:w-full mt-5 ">

                <div class="grid grid-cols-1 ">
                    <div class="text-lg font-bold">

                    </div>
                    <div class=" text-white rounded-md ">

                        <label for="search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="search" v-model="search" v-on:keyup.enter="cari"
                                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="cari table" required>

                        </div>

                    </div>

                </div>
            </div>

        </template>

    </Table>

</div>

</div>

    </AdminLayout>
</template>

<script>

export default {
  
   props:{
    dataTypes: Object,
    tables: Object
   },
   
    components: {
        
       
    },
    computed: {
     
    },
   
    data() {

        return {
            setting: [ //seting header table
                {
                    title: 'Nama Table',
                    field: 'name',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Prefix',
                    field: 'prefix',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Slug',
                    field: 'slug',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                
                {
                    title: 'Aksi',
                    field: null,
                    type: 'button-group',
                    data: [
                        {
                            text: '',
                            type: 'button',
                            action: 'edit',
                            class: 'border rounded-l-2xl border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                            icon: 'fas fa-lg fa-pencil-alt'
                        },
                        {
                            text: '',
                            type: 'button',
                            action: 'tambah',
                            class: 'border-t border-b border-blue-500 hover:bg-emerald-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                            icon: 'fas fa-lg fa-plus'
                        },
                        {
                            text: '',
                            type: 'button',
                            action: 'hapus',
                            class: 'border rounded-r-2xl border-blue-500  hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white  focus:z-[1]',
                            icon: 'fas fa-lg fa-trash-alt'
                        },
                    ],
                    size: 20,
                    align: 'center'
                },
            

            ],
       
        };
    },
    created() {

    },
    methods: {
    
    },
};
</script>


