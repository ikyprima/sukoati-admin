<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
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
</script>

<template>
    <Head>
        <title>Manajemen Menu </title>
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
                <Table @klik="klikMethod" :list=data :header=header :namaTitle="`List ${titleTable}`">
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
                    

                </Table>

            </div>

        </div>

    </AdminLayout>
    

</template>

<script>

export default {
    props: {
        header: Object,
        data: Object,
        titleTable : String
        
    },
    components: {

    },
    computed: {
     
    },
    data() {
        return {
         
        
        };
    },
    created(){
      
    },
    methods: {

        tambah() {
            Inertia.get(route('database.create'), {}, { replace: true })
        },

        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },

        edit(value) {
            Inertia.get(route('database.edit',value.name), {}, { replace: true })
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
    },
};
</script>
