<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";

import { Head } from '@inertiajs/inertia-vue3';
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
                @clickedit="clickedit" @clichapus="clickHapus" :list=listPegawai?listPegawai.data:[] :header=setting
                    namaTitle='MASTER PEGAWAI'>
                    <template #button>
                        <div class="hidden md:block">

                            <button
                                class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded-full shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button" @click="tambahPegawai">
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
                            <li class="page-item" v-for="paging in listPegawai?listPegawai.links:[]" :key="paging.id">
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
                        Tambah Pegawai
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
                                    NIK</label>
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
                            " v-model="formpegawai.nik" />
                                <p v-if="formpegawai.errors.nik" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.nik }}</p>
                            </div>
                            
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    NAMA</label>
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
                            " v-model="formpegawai.nama" />
                                <p v-if="formpegawai.errors.nama" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.nama }}</p>
                            </div>
                            
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Jenis Kelamin</label>
                                    <vue-multiselect @select="selectjekel" v-model="selectedjekel"   :options="optionsjekel" 
                        placeholder="Select one" label="nama" track-by="id"></vue-multiselect>
                                <p v-if="formpegawai.errors.id_kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.id_kategori }}</p>
                            </div>
                        



                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Pangkat</label>
                                    <vue-multiselect @select="selectpangkat" v-model="selectedpangkat"   :options="listPangkat" 
                        placeholder="Select one" label="nama_pangkat" track-by="id"></vue-multiselect>
                                <p v-if="formpegawai.errors.id_kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.id_kategori }}</p>
                            </div>
                        
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Jabatan</label>
                                    <vue-multiselect @select="selectjabatan" v-model="selectedjabatan"   :options="listJabatan" 
                        placeholder="Select one" label="nama_jabatan" track-by="id"></vue-multiselect>
                                <p v-if="formpegawai.errors.id_kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.id_kategori }}</p>
                            </div>
                        
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative mb-2">
                                <label for="exampleFormControlInpu3" class="form-label inline-block mb-2 text-gray-700">
                                    Pendidikan</label>
                                    <vue-multiselect @select="selectpendidikan" v-model="selectedpendidikan"   :options="listPendidikan" 
                        placeholder="Select one" label="nama_pendidikan" track-by="id"></vue-multiselect>
                                <p v-if="formpegawai.errors.id_kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                    formpegawai.errors.id_kategori }}</p>
                            </div>
                        
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
        listPendidikan: Object,
        listPangkat: Object,
        listJabatan: Object,
        listPegawai: Object,

    },
    components: {
        VueMultiselect,
        
    },



    data() {
        return {
            url: null,
            showModal: false,
            dialogHapus: false,
            setUbahPegawai: null,
            setHapusBarang: null,

            selectedpangkat : null,
            selectedjabatan : null,
            selectedpendidikan : null,

            selectedjekel : null,

            formpegawai: this.$inertia.form({
                nik: null,
                nama: null,
                jekel :null,
                id_jabatan :null,
                id_pangkat :null,
                id_pendidikan :null,
            }),
            optionsjekel: [
                { id: 1, nama: 'Laki-Laki' },
                { id: 2, nama: 'Perempuan' },
                
            ],
            editMode: false,
            selected: null,
            

        

            setting: [ //seting table
                {

                    title: 'NIK',
                    field: 'nik',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Nama',
                    field: 'nama',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Jenis Kelamin',
                    field: 'jekel',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Pangkat',
                    field: 'pangkat',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Jabatan',
                    field: 'jabatan',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
                },
                {

                    title: 'Pendidikan',
                    field: 'pdd',
                    fieldfoto: '',
                    type: 'string',
                    baseurl: '',
                    size: 'auto',
                    align: 'left'
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
      
        tambahPegawai() {
            this.editMode = false;
            this.setUbahPegawai = true;
            this.showModal = !this.showModal;
            this.formpegawai.reset()
            this.formpegawai.clearErrors()

        },
        simpan() {

           
            if (this.editMode == true) {

                this.formpegawai.put(route('master.pegawai.update', this.setUbahPegawai.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.setUbahPegawai = null;
                        this.formpegawai.reset('nama');
                     
                        // this.pagings(this.path+'?page='+this.halaman);
                    }
                })

            } else {
                this.formpegawai.post(route('pegawai.simpan'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.setUbahPegawai = null;
                    
                    },
                })
            }

        },

        clickedit(value) { //klik ubah

            // console.log(value);

            this.formpegawai.reset()
            this.formpegawai.clearErrors()
            this.editMode = true;
            this.showModal = !this.showModal;
            this.setUbahPegawai = value;
            this.formpegawai.nama = value.nama;
            
            this.selectedpangkat= {
                'id' : value.id_kategori,
                'nama' : value.kategori
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
            this.formpegawai.delete(route('master.satuan.hapus', this.setHapusBarang.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.dialogHapus = !this.dialogHapus;
                    this.setHapusBarang = null;
                    this.formpegawai.reset()
                    // this.pagings(this.path+'?page='+this.halaman);
                }

            })

        },
        
        previewImage(e) {
            const file = e.target.files[0];
            // this.url = URL.createObjectURL(file);
        },

        selectpangkat(value){
        
            this.formpegawai.id_pangkat= value.id;
        
        },
        selectjabatan(value){
        
            this.formpegawai.id_jabatan= value.id;
        
        },
        selectpendidikan(value){
        
            this.formpegawai.id_pendidikan= value.id;
        
        },
        selectjekel(value){
        
            this.formpegawai.jekel= value.id;
    
        },
    



    },


};
</script>
<style>
@import 'https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css';
</style>
