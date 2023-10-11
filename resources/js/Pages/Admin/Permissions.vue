<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import CardTable from "@/Components/Cards/CardTable.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import CardStats from "@/Components/Cards/CardStats.vue";
import { Head,Link } from '@inertiajs/inertia-vue3';

import DangerButton from '@/Components/DangerButton.vue';

import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/Dialog.vue';

</script>

<template>

    <Head title="Role" />

    <AdminLayout>
        <template #textnavbar>
            Permission
        </template> 
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <!-- <card-stats statSubtitle="PEGAWAI" statTitle="924" statArrow="down" statPercent="1.10"
                            statPercentColor="text-orange-500" statDescripiron="Since yesterday"
                            statIconName="fas fa-users" statIconColor="bg-pink-500" /> -->
                    </div>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table @clickedit="clickedit" @clickhapus="clickhapus" :list=permission.data :header=setting namaTitle='PERMISSION'> 
                    <template #button>
                        <div class="hidden md:block">
                            <ButtonTambah @click="tambahData">Tambah</ButtonTambah>
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
                            <li class="page-item" v-for="paging in permission?permission.links:[]" :key="paging.id">
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
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Tambah
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="permission" value="Permission" class="" />
                            <TextInput
                                id="permission"
                                ref="permissionInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Permission"
                                v-model="formpermission.permission"
                            />
                            <p v-if="formpermission.errors.permission" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formpermission.errors.permission }}
                            </p>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': formpermission.processing }" :disabled="formpermission.processing">
                <div v-if="editMode == true">
                    Simpan Perubahan
                </div>
                <div v-else>
                    Simpan
                </div>
                </PrimaryButton>
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogHapus" @close="closeDialogHapus()">
        <div class="md:flex items-center">
        
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">Hapus Data</p>
                <p class="text-sm text-gray-700 mt-1">Anda Yakin Akan Menghapus Data Yang Dipilih?
                </p>
            </div>
        </div>
    
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button v-on:click="hapus()"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': formpermission.processing }" :disabled="formpermission.processing">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
        </Dialog>

    
</template>

<script>

export default {
    
    props: {
        permission: Object,

    },
    data() {
        return {
            showModal: false,
            dialogHapus:false,
            editMode: false,
            objpermission : null,
            formpermission: this.$inertia.form({
                permission: null,
            }),

            setting: [ //seting header table
                {

                    title: 'Permission',
                    field: 'name',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Guard',
                    field: 'guard_name',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Controller',
                    field: 'controller',
                    type: 'string',
                    size: 'auto',
                    align: 'left'
                },
                {
                    title: 'Function',
                    field: 'function',
                    type: 'string',
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
        tambahData() {
            this.editMode = false;
            this.objpermission = null;
            this.showModal = !this.showModal;
            this.formpermission.reset()
            this.formpermission.clearErrors()
        },
        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
            this.formpermission.reset();
            this.formpermission.clearErrors()
        },
        clickedit(value){
            this.editMode = true;
            this.objpermission = value;
            this.showModal = !this.showModal;
            this.formpermission.reset()
            this.formpermission.clearErrors()
            this.formpermission.permission = value.name;
        },
        clickhapus(value){
        
            this.objpermission = value;
            this.dialogHapus = !this.dialogHapus;
        
        },
        closeDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        simpan() {
            if (this.editMode == true) {
                this.formpermission.put(route('permissions.update', this.objpermission.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objpermission = null;
                        this.formpermission.reset();
                        // this.pagings(this.path+'?page='+this.halaman);
                    }
                })

            } else {
                this.formpermission.post(route('permissions.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objpermission = null;
                        this.formpermission.reset();
                    },
                })
            }

        },
        hapus(){
            this.formpermission.delete(route('permission.hapus', this.objpermission.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.dialogHapus = !this.dialogHapus;
                    this.objpermission = null;
                
                }

            })
        }
    },

    
};
</script>