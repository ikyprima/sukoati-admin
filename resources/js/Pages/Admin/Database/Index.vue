<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import Table from "@/Components/Tables/Table.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import NProgress from 'nprogress'
</script>

<template>
    <Head>
        <title>Manajemen Menu</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen database
        </template>

        <template #header>
            <header-stats>

                <template #kontenheader>

                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">

            <div class="w-full mb-12 px-4">
                <Table @klik="klikMethod" :list=filteredItems :header=setting namaTitle='LIST TABLE MySQL'>
                    <template #button>

                        <div class="hidden md:block">
                            <ButtonTambah @click="tambah">Tambah</ButtonTambah>
                        </div>

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
    <Modal :show="showModalDetailTable" @close="closeModalDetailTable" :maxWidth="'5xl'">
        <div class="p-2">
            <div class="mx-4 flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold uppercase">
                    DETAIL TABLE {{ detailTableNama }}
                </h3>
            </div>

            <div class="relative p-6 flex-auto animatecss animatecss-fadeIn">
                <div class="overflow-hidden">
                    <table class="w-full border border-collapse table-auto">
                        <thead class="">
                            <tr class="text-base font-bold text-left bg-gray-50">
                                <th class="px-4 py-3 border-b-2 border-pink-500">Field</th>
                                <th class="px-4 py-3 border-b-2 border-blue-500 ">Type</th>
                                <th class="px-4 py-3 border-b-2 border-green-500 text-center">Null</th>
                                <th class="px-4 py-3 border-b-2 border-red-500 text-center">Key</th>
                                <th class="px-4 py-3 border-b-2 border-purple-500">Default</th>
                                <th class="px-4 py-3 border-b-2 border-yellow-500">Extra</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-normal text-gray-700">
                            <template v-for="( data, index ) in detailTable" :key="index">
                                <tr class="py-10 border-b border-gray-200 hover:bg-gray-100">
                                    <td class="px-4  py-4">
                                        {{ data.name }}
                                    </td>
                                    <td class="px-4  py-4">
                                        {{ data.type }}
                                    </td>
                                    <td class="px-4 text-center py-4">
                                        {{ data.notnull }}
                                    </td>
                                    <td class="px-4 text-center py-4">
                                        {{ data.key }}
                                    </td>
                                    <td class="px-4  py-4">
                                        {{ data.default }}
                                    </td>
                                    <td class="px-4 py-4">
                                        {{ data.extra }}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4 flex justify-end mr-6 mb-4">
                <SecondaryButton @click="closeModalDetailTable">
                    Tutup
                </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>

export default {
    props: {
        dataTypes: Object,
        tables: Object
    },
    components: {

    },
    computed: {
        filteredItems() {
            return this.items.filter(item => {
                return item.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    },
    data() {
        return {
            showModalDetailTable: false,
            detailTable: null,
            detailTableNama: null,
            search: '',
            items: this.tables,
            setting: [ //seting header table
                {
                    title: 'Nama Table',
                    field: 'name',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                // {
                //     title: 'tes kostum',
                //     field: null,
                //     type: 'costum',
                //     data :[
                //         {
                //             text : '',
                //             type : 'button',
                //             action : 'lihatDetail',
                //             class : 'border-blue-500 hover:bg-emerald-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                //             icon : 'fas fa-lg fa-file-alt'
                //         },
                //     ], 
                //     size: 'auto',
                //     align: 'center'
                // },
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
                            action: 'lihatDetail',
                            class: 'border-t border-b border-blue-500 hover:bg-emerald-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                            icon: 'fas fa-lg fa-file-alt'
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
                // {
                //     title: 'Aksi',
                //     field: null,
                //     type: 'button-edit-delete',
                //     size: 20,
                //     align: 'center'
                // },

            ],
        };
    },
    methods: {

        tambah() {
            Inertia.get(route('database.create'), {}, { replace: true })
        },

        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },

        lihatDetail(value) {
            NProgress.start()
            axios.get(route('database.show', value.name), {
            })
                .then((res) => {
                    //jika sukses
                    this.detailTableNama = value.name;
                    this.showModalDetailTable = !this.showModalDetailTable;
                    NProgress.done()
                    this.detailTable = res.data;
                    console.log(res);
                    
                    // console.log(Object.keys(res.data).length); 
                })
                .catch((error) => {
                    //jika error.response.status Check status code
                    NProgress.done()
                    this.showModalDetailTable = false;

                }).finally(() => {
                    //selesai 
                    NProgress.done();

                });

        },
        closeModalDetailTable() {
            this.showModalDetailTable = !this.showModalDetailTable;
            this.detailTable = null;
            this.detailTableNama = null;
        },

        edit(value) {
            Inertia.get(route('database.edit',value.name), {}, { replace: true })
        },

        hapus(value) {

        },
    },
};
</script>
