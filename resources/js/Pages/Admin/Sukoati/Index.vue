<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';


import { Link } from '@inertiajs/inertia-vue3';
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
</script>

<template>
    <Head>
        <title>Manajemen {{titleTable}} </title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen {{titleTable}}
        </template>
        <template #notif>
            <ToastList/>
        </template>
        <template #header>
            <header-stats>

                <template #kontenheader>
                    
                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">

            <div class="w-full mb-12 px-4">
                <Table @klik="klikMethod" :list=data.data :header=header :namaTitle="`List ${titleTable}`">
                    <template #button>
                       
                        <div class="hidden md:block">
                            
                            <ButtonTambah v-if="buttonTambah" @click="tambah">Tambah</ButtonTambah>
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
                                        <input type="search" id="search" 
                                            v-model="search" v-on:keyup.enter="cari"
                                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Pencarian" required>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </template>

                </Table>
                <div
                            class="flex flex-col items-center w-full px-4 py-2 text-sm text-gray-500 sm:justify-between sm:space-y-0 sm:flex-row">

                            <div id="fromTo"> <p class="flex">Menampilkan&nbsp;<span class="font-bold">{{ data.from }} 
                                </span>&nbsp; sampai &nbsp; <span class="font-bold"> {{ data.to }}
                                </span>&nbsp; dari &nbsp;<span class="font-bold">{{ data.total }}
                                </span>  &nbsp; data</p>
                            </div>

                            <div class="flex items-center justify-between space-x-2">
                                <div id="prev"></div>
                                <div class="flex flex-row   space-x-1" id="halaman">
                                    <template v-if="data.current_page == 1">
                                        <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3>First Page</h3>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                        :href="data.first_page_url" @click.prevent="getHalaman(data.first_page_url)" ><h3>First Page</h3></Link>
                                    </template>
                                    <template  v-for="paging in data?data.links:[]" >
                                        <template v-if="paging.active == false && paging.url == null">
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else-if="paging.active == true && paging.url != null">
                                            
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else>

                                            <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                            :href="paging.url"  @click.prevent="getHalaman(paging.url)"><h3 v-html="paging.label"></h3></Link>
                                        
                                        </template>
                                    </template>
                                    <template v-if="data.current_page == data.last_page">
                                        <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3>Last Page</h3>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                            :href="data.last_page_url" @click.prevent="getHalaman(data.last_page_url)" ><h3>Last Page</h3></Link>
                                    </template>
                                </div>
                                <div id="next"></div>

                            </div>
                        </div>
            </div>

        </div>
        

    </AdminLayout>
    <Modal :show="showModalDetailTable" @close="closeModalDetailTable" :maxWidth="'5xl'">
        <div class="p-2">
            <div class="mx-4 flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold uppercase">
                    DETAIL {{ detailNama }}
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
        header: Object,
        data: Object,
        titleTable : String,
        slug : String,
        dataSearch : String,
        buttonTambah : Boolean
    },
    components: {

    },
    computed: {
     
    },
    data() {
        return {
            showModalDetailTable: false,
            detailNama: null,
            search : this.dataSearch,
            
            
        };
    },
    created(){
      
    },
    methods: {

        tambah() {
            Inertia.get(route(this.slug+'.create'), {}, { replace: true })
        },

        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },

        edit(value) {
            Inertia.get(route(this.slug+'.edit',value.id), {}, { replace: true })
        },

        lihatDetail(value) {
            NProgress.start()
            console.log(value);
            axios.get(route(this.slug+'.show', value.id), {
            })
                .then((res) => {
                    //jika sukses
                    this.showModalDetailTable = !this.showModalDetailTable;
                    NProgress.done()
                    console.log(res);
                    
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
            this.detailNama = null;
        },
        hapus(value) {
            this.objRow = value;
            this.dialogHapus = !this.dialogHapus;
        },
        hapusAksi(){
            this.formTable.delete(route('database.hapus',this.objRow.name), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.items = this.tables;
                        this.dialogHapus = !this.dialogHapus;
                        this.objRow = null;
                        toast.add({
                            message: 'Sukses Hapus Data',
                            category : 'info'
                        })
                    },
                    onError: errors => {
                        toast.add({
                            message: errors.error,
                            category : 'warning',
                            duration : 10000
                        })
                        this.dialogHapus = !this.dialogHapus;
                        this.objRow = null;
                    },
            });
        },
        closeDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        cari(){
            Inertia.get(route(this.slug+'.index'), {
                search: this.search 
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
            
        },
        getHalaman(value){
            Inertia.get(value, {
            
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
        }
    },
};
</script>
