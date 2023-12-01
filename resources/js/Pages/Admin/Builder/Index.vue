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
import ToastList from '@/Components/Notifications/ToastList.vue';
import toast from '@/Stores/toast.js';

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
                            <input type="search" id="search" v-on:keyup.enter="cari"
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
    <Dialog :show="dialogReload" @close="closeDialogReload()">
        <div class="md:flex items-center">
        
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">INFO!!</p>
                <p class="text-sm text-gray-700 mt-1">Untuk Mendapatkan Efek Penambahan "Route-List" Baru Silahkan Reload Halaman
                </p>
            </div>
        </div>
    
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button v-on:click="reload()"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " >
                Ya, Reload</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
    </Dialog>
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
            dialogReload:false,
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
                            action: 'view',
                            class: 'border-t border-b border-r border-blue-500 hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                            icon: 'fas fa-lg fa-file'
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
        if(this.$page.props.flash.message != null){
            this.dialogReload = !this.dialogReload;
            toast.add({
                message: this.$page.props.flash.message,
                category : 'info'
            });
            //buat pesan jika baru buat builder table, jika sukses haruskan reload halaman
           
        }
        this.$page.props.flash.message = null;    
    },
    methods: {
        closeDialogReload: function () {
                this.dialogReload = !this.dialogReload;
        },
        reload(){
            location.reload(true);
        },
        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },
        tambah(value) {
            Inertia.get(route('builder.create',value.name), {}, { replace: true })
        },
        view(value){
            // window.open(route(value.slug+'.index'), '_blank');
            Inertia.get(route(value.slug+'.index'),{},
                { 
                    replace: true,
                    preserveState: false 
                }
            )
        }
    },
};
</script>


