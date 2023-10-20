<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";

import { Head } from '@inertiajs/vue3';
import CardTable from "@/Components/Cards/CardTable.vue";
import { Link } from '@inertiajs/inertia-vue3';
import VueMultiselect from 'vue-multiselect';
</script>

<template>
    <Head title="Dashboard" />


    <AdminLayout>

        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">


                    </div>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table 
                @clickedit="clickedit" @clichapus="clickHapus" :list=listBarang?listBarang.data:[] :header=setting
                    namaTitle='MASTER BARANG'>
                    <template #button>
                        <div class="hidden md:block">

                            <button
                                class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded-full shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" @click="tambahBarang">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
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

                </card-table>

                <footer class="px-2 py-4 border-t border-gray-100 bg ">
                    <nav aria-label="Page navigation example ">
                        <ul class="flex list-style-none ">
                            <li class="page-item" v-for="paging in listBarang?listBarang.links:[]" :key="paging.id">
                                <div v-if="paging.active == false && paging.url == null">
                                    <a class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                                    border-0
                                    bg-transparent
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-gray-500
                                    pointer-events-none
                                    focus:shadow-none
                                " href="#" tabindex="-1" aria-disabled="false">
                                        <h3 v-html="paging.label"></h3>
                                    </a>
                                </div>
                                <div v-else-if="paging.active == true && paging.url != null">
                                    <Link class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                            
                                    border-0
                                    bg-blue-600
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-white
                                    hover:text-white hover:bg-blue-600
                                    shadow-md
                                    focus:shadow-md
                                " :href="paging.url">{{ paging.label }}
                                    <span class="visually-hidden">(current)</span></Link>
                                </div>
                                <div v-else>
                                    <Link class="
                                    page-link
                                    relative
                                    block
                                    py-1.5
                                    px-3
                            
                                    border-0
                                    bg-transparent
                                    outline-none
                                    transition-all
                                    duration-300
                                    rounded-full
                                    text-gray-800
                                    hover:text-gray-800 hover:bg-gray-200
                                    focus:shadow-none
                                " :href="paging.url">
                                    <h3 v-html="paging.label"></h3>
                                    </Link>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </footer>
            </div>


        </div>
    </AdminLayout>

    <div v-if="showModal"
        class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
        <div class="relative w-auto my-6 mx-auto max-w-3xl min-w-[50%]">

            <!--content-->
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">

                <!--header-->
                <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                    <h3 v-if="!editMode" class="text-3xl font-semibold">
                        Tambah Barang
                    </h3>
                    <h3 v-if="editMode" class="text-3xl font-semibold">
                        Ubah Barang
                    </h3>
                    <button
                        class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                        v-on:click="toggleModal()">
                        <span
                            class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->

                <div class="relative p-12 flex-auto">
                


                    <form @submit.prevent="">


                    
                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Nama Barang</label>
                                <input class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded-lg
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700
                                focus:bg-white
                                focus:border-blue-600
                                focus:outline-none
                            " v-model="formbarang.nama" />
                                <p v-if="formbarang.errors.nama" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.nama }}</p>
                            </div>
                            
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Merk Barang</label>
                                <input class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded-lg
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700
                                focus:bg-white
                                focus:border-blue-600
                                focus:outline-none
                            " v-model="formbarang.merk" />
                                <p v-if="formbarang.errors.merk" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.merk }}</p>
                            </div>
                            
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    SKU</label>
                                <input class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded-lg
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700
                                focus:bg-white
                                focus:border-blue-600
                                focus:outline-none
                            " v-model="formbarang.sku" />
                                <p v-if="formbarang.errors.sku" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.sku }}</p>
                            </div>
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Barcode</label>
                                <input class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded-lg
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700
                                focus:bg-white
                                focus:border-blue-600
                                focus:outline-none
                            " v-model="formbarang.barcode" />
                                <p v-if="formbarang.errors.barcode" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.barcode }}</p>
                            </div>
                            
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Kategori</label>
                                    <vue-multiselect @select="selectkategori" v-model="selectedkategori"   :options="listKategori" 
                        placeholder="Select one" label="nama" track-by="id"></vue-multiselect>
                                <p v-if="formbarang.errors.id_kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.id_kategori }}</p>
                            </div>
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3"
                                    class="form-label inline-block mb-2 text-gray-700">Satuan</label>
                                    <vue-multiselect @select="selectsatuan"  v-model="selectedsatuan"  :options="listSatuan" 
                                placeholder="Select one" label="nama" track-by="id"></vue-multiselect>
                                <p v-if="formbarang.errors.id_satuan" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    {{ formbarang.errors.id_satuan }}</p>
                            </div>



                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Stok Minimal</label>
                                <input class="
                                form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded-lg
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700
                                focus:bg-white
                                focus:border-blue-600
                                focus:outline-none
                            " v-model="formbarang.stok_min" />
                                <p v-if="formbarang.errors.stok_min" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.stok_min }}</p>
                            </div>
                            
                            
                        </div>


                        <div>
                                <label for="File">File Upload</label>
                                <input
                                    type="file"
                                    @change="previewImage"
                                    @input="formbarang.photo = $event.target.files[0]"
                                    ref="photo"
                                    class="
                                        w-full
                                        px-4
                                        py-2
                                        mt-2
                                        border
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                    "
                                />
                                <p v-if="formbarang.errors.photo" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formbarang.errors.photo }}</p>
                            
                            
                            </div>
                    </form>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                    <button
                        class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" v-on:click="toggleModal()">
                        Close
                    </button>


                    <button
                        class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" v-on:click="simpan">
                        <div v-if="editMode == true">
                            Simpan Perubahan
                        </div>
                        <div v-else>
                            Simpan
                        </div>


                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    <div v-if="dialogHapus" class="opacity-25 fixed inset-0 z-40 bg-black"></div>

    <div v-if="dialogHapus"
        class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">

        <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
            <div class="md:flex items-center">
                <div
                    class="rounded-full border border-gray-300 flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                    <i class="bx bx-error text-3xl"></i>
                </div>
                <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                    <p class="font-bold">Delete your account</p>
                    <p class="text-sm text-gray-700 mt-1">You will lose all of your data by deleting your account. This
                        action cannot be undone.
                    </p>
                </div>
            </div>
            <div class="text-center md:text-right mt-4 md:flex md:justify-end">
                <button v-on:click="hapus()"
                    class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2">
                    Ya, Hapus</button>
                <button v-on:click="toggleDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
                  md:mt-0 md:order-1">Batal</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: {
        listSatuan: Object,
        listKategori: Object,
        listBarang: Object,

    },
    components: {
        VueMultiselect,
        
    },

  

    data() {
        return {
            url: null,
            showModal: false,
            dialogHapus: false,
            setUbahBarang: null,
            setHapusBarang: null,
            selectedkategori : null,
            selectedsatuan : null,

            formbarang: this.$inertia.form({
                sku: null,
                nama: null,
                barcode: null,
                merk: null,
                photo: null,
                id_kategori: null,
                id_satuan: null,
                stok_min: null,
                keterangan: null,
                photo:null
            }),
            editMode: false,
            selected: null,
        

            setting: [ //seting table
                {

                    title: 'Nama',
                    fieldtext: 'nama',
                    fieldfoto: 'photo',
                    type: 'gambar',
                    baseurl: '/storage/barang/smalls/',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Merk',
                    field: 'merk',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'SKU',
                    field: 'sku',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                    },
                {

                    title: 'Barcode',
                    field: 'barcode',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                    },
                    {

                    title: 'Satuan',
                    field: 'satuan',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                    },
                    {

                    title: 'Kategori',
                    field: 'kategori',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                    },
                    {

                    title: 'Stok Minimum',
                    field: 'stok_min',
                    type: 'string',
                    size: '20',
                    align: 'center'
                    },
                
                {

                    title: 'Aksi',
                    field: null,
                    type: 'button',
                    size: 20,
                    align: 'center'
                },


            ],
        };
    },
    methods: {
      
        tambahBarang() {
            this.editMode = false;
            this.setUbahBarang = true;
            this.showModal = !this.showModal;
            this.formbarang.reset()
            this.formbarang.clearErrors()

        },
        simpan() {

           
            if (this.editMode == true) {

                this.formbarang.put(route('master.barang.update', this.setUbahBarang.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.setUbahBarang = null;
                        this.formbarang.reset('nama');
                     
                        // this.pagings(this.path+'?page='+this.halaman);
                    }
                })

            } else {
                this.formbarang.post(route('master.barang.simpan'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.setUbahBarang = null;
                    
                    },
                })
            }

        },

        clickedit(value) { //klik ubah

            // console.log(value);

            this.formbarang.reset()
            this.formbarang.clearErrors()
            this.editMode = true;
            this.showModal = !this.showModal;
            this.setUbahBarang = value;
            this.formbarang.nama = value.nama;
            this.formbarang.merk = value.merk;
            this.formbarang.sku = value.sku;
            this.formbarang.barcode = value.barcode;
            this.formbarang.id_kategori = value.id_kategori;
            this.formbarang.id_satuan = value.id_satuan ;
            this.formbarang.stok_min = value.stok_min ;
            this.selectedkategori= {
                'id' : value.id_kategori,
                'nama' : value.kategori
            };
            this.selectedsatuan= {
                'id' : value.id_satuan,
                'nama' : value.satuan
            };


        },

        toggleModal: function () {
            this.showModal = !this.showModal;
        },

        clickHapus(value) { //klik ubah

            this.setHapusBarang = value;
            this.dialogHapus = !this.dialogHapus;


        },
        toggleDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        hapus() {
            this.formbarang.delete(route('master.satuan.hapus', this.setHapusBarang.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.dialogHapus = !this.dialogHapus;
                    this.setHapusBarang = null;
                    this.formbarang.reset()
                    // this.pagings(this.path+'?page='+this.halaman);
                }

            })

        },
        
        previewImage(e) {
            const file = e.target.files[0];
            // this.url = URL.createObjectURL(file);
        },

        selectkategori(value){
           
            this.formbarang.id_kategori= value.id;
        
        },
        selectsatuan(value){
            this.formbarang.id_satuan= value.id;
        
        }



    },


};
</script>
<style>
@import 'https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css';
</style>
