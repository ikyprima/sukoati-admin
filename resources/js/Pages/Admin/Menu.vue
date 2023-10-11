<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import Multiselect from '@vueform/multiselect'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Card from "@/Components/Cards/CardKosong.vue";
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue';
Inertia.reload({ only: ['admin/menu'] });

</script>

<template>
    <Head>
        <title>Manajemen Menu</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen menu
        </template>

        <template #header>
            <header-stats>

                <template #kontenheader>

                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card :list=listMenu.data @clickadd="clickadd" @clickaddHeaderMenu="mclickaddMenuKategori"
                    @clickEditHeaderMenu="mclickEditMenuKategori">
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
                </card>
            </div>

        </div>


    </AdminLayout>

    <Modal :show="showModalTambahMenuKategori" @close="closeModalTambahMenuKategori">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">

                <h3 v-if="editModeMenuKategori" class="text-xl font-semibold uppercase">
                    Ubah Kategori Menu {{ objMenuKategori.name }}
                </h3>
                <h3 v-else class="text-xl font-semibold uppercase">
                    Tambah Menu Pada Kategori
                    {{ objMenuKategori.title }} | {{ objMenuKategori.posisi == 0 ? 'Dashboard Admin' : 'Home Page' }}
                </h3>

            </div>
            <div class="relative p-6 flex-auto ">
                <template v-if="editModeMenuKategori">
                    <form @submit.prevent>
                        <div class="grid grid-cols-1 md:grid-cols-1 ">
                            <div class="relative mb-2 ">
                                <InputLabel value="Posisi" class="" />
                                <div class="mt-1 block w-full">
                                    <Multiselect v-model="formmenu.posisi" class="mt-1 block w-full" :options="posisi" />
                                </div>
                                <p v-if="formmenu.errors.posisi" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    {{ formmenu.errors.posisi }}
                                </p>
                            </div>


                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-1 ">
                            <div class="relative mb-2 ">
                                <InputLabel for="kategori" value="Kategori" class="" />

                                <TextInput id="kategori" ref="kategoriInput" type="text" class="mt-1 block w-full"
                                    placeholder="nama kategori" v-model="formmenu.kategori" />

                                <p v-if="formmenu.errors.kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                    {{ formmenu.errors.kategori }}
                                </p>
                            </div>
                        </div>
                        <template v-for="(item, index) in formmenu.menuItem" :key="index">
                            <div class="relative box-border border-2 p-2 mt-2 md:box-content shadow-lg rounded "
                                :class="[item.is_diHapus ? 'border-rose-500' : null]">
                                <div v-if="item.is_diHapus"
                                    class="ribbon absolute -top-2 -left-2 h-40 w-40 overflow-hidden before:absolute before:top-0 before:right-0 before:-z-[1] before:border-4 before:border-rose-500 after:absolute after:left-0 after:bottom-0 after:-z-[1] after:border-4 after:border-rose-500">
                                    <div
                                        class="z-10 absolute -left-14 top-[43px] w-60 -rotate-45 bg-gradient-to-br from-rose-600 via-rose-400 to-rose-500 py-2.5 text-center text-white shadow-md">
                                        DIHAPUS</div>
                                </div>
                                <Transition :duration="{ enter: 500, leave: 500 }">
                                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                        <div class="relative  ">
                                            <InputLabel value="Nama Menu" class="" />
                                            <div class="relative w-full  ">
                                                <TextInput :id="'menu-' + index" ref="menuInput" type="text"
                                                    class="mt-1 block w-full  " placeholder="nama menu"
                                                    v-model="item.nama_menu" :disabled="item.is_diHapus ? true : false" />
                                                <button
                                                    v-on="{ click: item.is_diHapus ? () => updateKembalikanYangDiHapus(index) : () => updateHapus(index) }"
                                                    class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white
                                                    rounded-r-lg
                                                    border 
                                                    focus:ring-4 focus:outline-none"
                                                    :class="[item.is_diHapus ? 'bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-blue-300' :
                                                        'bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300']">
                                                    <template v-if="item.is_diHapus">
                                                        <i class="fas fa-lg fa-sync"></i>
                                                    </template>
                                                    <template v-else>
                                                        <i class="fas fa-lg fa-trash-alt"></i>
                                                    </template>
                                                </button>
                                            </div>
                                            <p v-if="$page.props.errors['menuItem.' + index + '.nama_menu']"
                                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ $page.props.errors['menuItem.' + index + '.nama_menu'] }}
                                            </p>
                                        </div>
                                        <div class="relative  ">
                                            <InputLabel value="Nama Route" />
                                            <div class="mt-1 block w-full">
                                                <Multiselect valueProp="nama"
                                                    v-model="formmenu.menuItem[index]['nama_route']" label="nama"
                                                    class="mt-1 block w-full" :searchable="true" :object="true"
                                                    :options="master[index].namerute"
                                                    :disabled="item.is_diHapus ? true : false" />
                                            </div>
                                        </div>
                                        <div class="relative  ">
                                            <InputLabel value="Role" />
                                            <div class="mt-1 block w-full">
                                                <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['role']"
                                                    label="name" mode="tags" class="mt-1 block w-full"
                                                    @clear="(selectedValue) => roleklik(selectedValue, index, 2)"
                                                    @select="(selectedValue) => roleklik(selectedValue, index, 1)"
                                                    :searchable="true" :options="master[index].role"
                                                    @deselect="(selectedValue) => roleklik(selectedValue, index, 0)"
                                                    :disabled="item.is_diHapus ? true : false" />
                                            </div>
                                        </div>
                                        <div class="relative   ">
                                            <InputLabel value="Permission" />
                                            <div class="mt-1 block w-full">
                                                <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['permission']"
                                                    label="name" mode="tags" :searchable="true"
                                                    :options="master[index].permission"
                                                    :disabled="item.is_diHapus ? true : false" />
                                            </div>
                                        </div>
                                    </div>
                                </Transition>
                            </div>
                        </template>
                    </form>
                </template>
                <template v-else>
                    <form @submit.prevent>

                        <template v-for="(item, index) in formmenu.menuItem" :key="index">
                            <Transition :duration="{ enter: 500, leave: 500 }">
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                    <div class="relative  ">
                                        <InputLabel value="Nama Menu" class="" />
                                        <div class="relative w-full ">
                                            <TextInput :id="'menu-' + index" ref="menuInput" type="text"
                                                class="mt-1 block w-full" placeholder="nama menu"
                                                v-model="item.nama_menu" />
                                            <button v-on="{ click: () => tambahAtauHapus(index) }" class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white
                                                    rounded-r-lg
                                                    border 
                                                    focus:ring-4 focus:outline-none "
                                                :class="[index == 0 ? 'bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-blue-300' :
                                                    'bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300']">
                                                <template v-if="index == 0">
                                                    <i class="fas fa-lg fa-plus"></i>
                                                </template>
                                                <template v-else="index == 0">
                                                    <i class="fas fa-lg fa-trash-alt"></i>
                                                </template>
                                            </button>

                                        </div>
                                        <p v-if="$page.props.errors['menuItem.' + index + '.nama_menu']"
                                            class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{ $page.props.errors['menuItem.' + index + '.nama_menu'] }}
                                        </p>
                                    </div>
                                    <div class="relative  ">
                                        <InputLabel value="Nama Route" />
                                        <div class="mt-1 block w-full">
                                            <Multiselect valueProp="nama" v-model="formmenu.menuItem[index]['nama_route']"
                                                label="nama" class="mt-1 block w-full" :searchable="true" :object="true"
                                                :options="master[index].namerute" />
                                        </div>
                                    </div>
                                    <div class="relative  ">
                                        <InputLabel value="Role" />
                                        <div class="mt-1 block w-full">
                                            <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['role']"
                                                label="name" mode="tags" class="mt-1 block w-full"
                                                @clear="(selectedValue) => roleklik(selectedValue, index, 2)"
                                                @select="(selectedValue) => roleklik(selectedValue, index, 1)"
                                                :searchable="true" :options="master[index].role"
                                                @deselect="(selectedValue) => roleklik(selectedValue, index, 0)" />
                                        </div>
                                    </div>
                                    <div class="relative   ">
                                        <InputLabel value="Permission" />
                                        <div class="mt-1 block w-full">
                                            <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['permission']"
                                                label="name" mode="tags" :searchable="true"
                                                :options="master[index].permission" />
                                        </div>
                                    </div>
                                </div>
                            </Transition>

                        </template>
                    </form>
                </template>

            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalTambahMenuKategori">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpanMenuKategori">
                    <div v-if="editModeMenuKategori">
                        Simpan Perubahan
                    </div>
                    <div v-else>
                        Simpan
                    </div>
                </PrimaryButton>
            </div>
        </div>
    </Modal>


    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold uppercase">
                    TAMBAH MENU
                </h3>
            </div>
            <div class="relative p-6 flex-auto animatecss animatecss-fadeInLeft">
                <form @submit.prevent>
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2 ">
                            <InputLabel value="Posisi" class="" />
                            <div class="mt-1 block w-full">
                                <Multiselect v-model="formmenu.posisi" class="mt-1 block w-full" :options="posisi" />
                            </div>
                            <p v-if="formmenu.errors.posisi" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ formmenu.errors.posisi }}
                            </p>
                        </div>


                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2 ">
                            <InputLabel for="kategori" value="Kategori" class="" />

                            <TextInput id="kategori" ref="kategoriInput" type="text" class="mt-1 block w-full"
                                placeholder="nama kategori" v-model="formmenu.kategori" />

                            <p v-if="formmenu.errors.kategori" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{ formmenu.errors.kategori }}
                            </p>
                        </div>


                    </div>
                    <template v-for="(item, index) in formmenu.menuItem" :key="index">
                        <Transition :duration="{ enter: 500, leave: 500 }">
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                <div class="relative  ">
                                    <InputLabel value="Nama Menu" class="" />
                                    <div class="relative w-full ">
                                        <TextInput :id="'menu-' + index" ref="menuInput" type="text"
                                            class="mt-1 block w-full" placeholder="nama menu" v-model="item.nama_menu" />
                                        <button v-on="{ click: () => tambahAtauHapus(index) }" class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white
                                                    rounded-r-lg
                                                    border 
                                                    focus:ring-4 focus:outline-none "
                                            :class="[index == 0 ? 'bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-blue-300' :
                                                'bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300']">
                                            <template v-if="index == 0">
                                                <i class="fas fa-lg fa-plus"></i>
                                            </template>
                                            <template v-else="index == 0">
                                                <i class="fas fa-lg fa-trash-alt"></i>
                                            </template>
                                        </button>

                                    </div>
                                    <p v-if="$page.props.errors['menuItem.' + index + '.nama_menu']"
                                        class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $page.props.errors['menuItem.' + index + '.nama_menu'] }}
                                    </p>
                                </div>
                                <div class="relative  ">
                                    <InputLabel value="Nama Route" />
                                    <div class="mt-1 block w-full">
                                        <Multiselect valueProp="nama" v-model="formmenu.menuItem[index]['nama_route']"
                                            label="nama" class="mt-1 block w-full" :searchable="true" :object="true"
                                            :options="master[index].namerute" />
                                    </div>


                                </div>
                                <div class="relative  ">
                                    <InputLabel value="Role" />
                                    <div class="mt-1 block w-full">
                                        <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['role']" label="name"
                                            mode="tags" class="mt-1 block w-full"
                                            @clear="(selectedValue) => roleklik(selectedValue, index, 2)"
                                            @select="(selectedValue) => roleklik(selectedValue, index, 1)"
                                            :searchable="true" :options="master[index].role"
                                            @deselect="(selectedValue) => roleklik(selectedValue, index, 0)" />
                                    </div>
                                </div>
                                <div class="relative   ">
                                    <InputLabel value="Permission" />
                                    <div class="mt-1 block w-full">
                                        <Multiselect valueProp="id" v-model="formmenu.menuItem[index]['permission']"
                                            label="name" mode="tags" :searchable="true"
                                            :options="master[index].permission" />
                                    </div>
                                </div>
                            </div>
                        </Transition>

                    </template>
                </form>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan">
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
</template>

<script>

export default {

    props: {
        listMenu: Object,
        role: Object,
        permission: Object,
        namaRoute: Object

    },
    components: {
        Multiselect
    },
    data() {

        return {
            showModalTambahMenuKategori: false,
            objMenuKategori: {}, //parsing dari click acordion, kemudian di tampilkan header modal
            editModeMenuKategori: false,

            showModal: false,
            dialogHapus: false,
            editMode: false,
            objmenu: null,
            formmenu: this.$inertia.form({
                id: null,
                posisi: 0,
                kategori: null,
                menuItem: [
                    {
                        nama_menu: '',
                        role: [],
                        permission: [],
                        nama_route: {},
                    }
                ]
            }),
            master: [
                {
                    role: this.role,
                    permission: this.permission,
                    namerute: this.namaRoute,
                    tes: 1
                }

            ],
            posisi: [
                { value: 0, label: 'Dashboard Admin' },
                { value: 1, label: 'Home Page' },
            ],

        };
    },
    methods: {
        closeModalTambahMenuKategori() {
            this.objMenuKategori = {};
            const fieldMaster = {
                role: this.role,
                permission: this.permission,
                namerute: this.namaRoute
            };
            this.master.push(fieldMaster);
            this.master.splice(1); //hapus semua dari index 1
            this.formmenu.reset()
            this.formmenu.clearErrors()
            this.showModalTambahMenuKategori = !this.showModalTambahMenuKategori;
        },
        mclickaddMenuKategori(value) {
            const fieldMaster = {
                role: this.role,
                permission: this.permission,
                namerute: this.namaRoute
            };
            this.master.push(fieldMaster);
            this.editModeMenuKategori = false;
            this.objMenuKategori = value;
            this.formmenu.id = value.id;
            this.showModalTambahMenuKategori = !this.showModalTambahMenuKategori;
        },

        mclickEditMenuKategori(value) {
            this.editModeMenuKategori = true;
            this.formmenu.menuItem = [];
            this.master = [];
            value.menu_item.forEach(element => {
                const namaRoute = this.namaRoute.filter(item => item.nama === element.name_route);

                if (namaRoute.length == 0) {
                    var nmroute = {};
                } else {
                    var nmroute = namaRoute[0];
                }

                const tambahField = {
                    id_menu: element.id,
                    nama_menu: element.title,
                    role: element.role,
                    permission: element.permission,
                    nama_route: nmroute,
                };
                this.formmenu.menuItem.push(tambahField);
                
                const arrRole = this.role.filter(item=> element.role.includes(item.id));
                const permissionIds = _.flatMap(arrRole, 'permissions');
                const idPermission = _.map(permissionIds, 'id');
                const arrPermission = this.permission.filter(item => !idPermission.includes(item.id));
            
                const fieldMaster = {
                    role: this.role,
                    permission: arrPermission,
                    namerute: this.namaRoute
                };
                this.master.push(fieldMaster);

            });

            this.objMenuKategori = value;
            this.formmenu.id = value.id;
            this.formmenu.kategori = value.name;
            this.formmenu.posisi = value.posisi;
            this.showModalTambahMenuKategori = !this.showModalTambahMenuKategori;

        },
        updateHapus: function (index) {
            const valueAsli = this.objMenuKategori.menu_item[index].title; //kembalikan ke nilai awal jika field nama menu dikosongkan, untuk cek validasi dibackend
            this.formmenu.menuItem[index].is_diHapus = true;
            this.formmenu.menuItem[index].nama_menu = valueAsli;
        },
        updateKembalikanYangDiHapus: function (index) {
            this.formmenu.menuItem[index].is_diHapus = false;
        },

        simpanMenuKategori() {
            if (this.editModeMenuKategori) {
                this.formmenu.transform((data) => ({
                    ...data,
                    is_kategori: 1,
                })).put(route('menu.update', this.objMenuKategori.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModalTambahMenuKategori = !this.showModalTambahMenuKategori;
                        this.objMenuKategori = {};
                        this.master.splice(1); //hapus semua dari index 1
                        this.formmenu.reset();
                    }
                })
            } else {
                this.formmenu.post(route('menu.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModalTambahMenuKategori = !this.showModalTambahMenuKategori;
                        this.objMenuKategori = {};
                        this.master.splice(1); //hapus semua dari index 1
                        this.formmenu.reset();
                    },
                })
            }

        },

        clickadd(value) {
            console.log(value);
        },

        tambahData() {
            this.editMode = false;
            this.objmenu = null;
            this.showModal = !this.showModal;
            this.formmenu.reset()
            this.formmenu.clearErrors()
        },
        closeModal() {
            this.editMode = false;
            this.showModal = !this.showModal;
            // this.formmenu.menuItem.splice(1); //hapus semua dari index 1 (tidak perlu sudah dihandle formmenu.reset())
            this.master.splice(1); //hapus semua dari index 1
            this.formmenu.reset();
            this.formmenu.clearErrors()
        },

        roleklik: function (value, i, e) {

            var role = _.filter(this.master[i].role, { id: value });
            const permissionIds = _.flatMap(role, 'permissions');
            var targetIds = _.map(permissionIds, 'id');
            if (e == 1) {
                targetIds.sort((a, b) => b - a); // Urutkan secara menurun untuk menghindari perulangan indeks

                var arr = this.master[i].permission.filter(item => !targetIds.includes(item.id));
                var arrForm = this.formmenu.menuItem[i].permission.filter(item => !targetIds.includes(item));

                this.master[i].permission = arr;
                this.formmenu.menuItem[i].permission = arrForm;

                // targetIds.forEach(id => {
                //     const index = this.master[0].permission.findIndex(item => item.id === id);

                //     // const indexform = this.formmenu.menuItem[i].permission.indexOf(id); //index pada permission pada form
                //     if (index !== -1) {
                //         this.master[0].permission.splice(index, 1);
                //         // this.formmenu.menuItem[i].permission.splice(indexform, 1);
                //     }
                // });
            } else if (e === 2) {
                this.master[i].permission = this.permission;
            } else {

                permissionIds.forEach(element => {
                    this.master[i].permission.push(element);
                });
                this.master[i].permission.sort((a, b) => a.id - b.id);
            }
        },


        tambahAtauHapus: function (value) {
            if (value == 0) {
                const tambahField = {
                    nama_menu: '',
                    role: [],
                    permission: [],
                    nama_route: {},
                };
                const fieldMaster = {
                    role: this.role,
                    permission: this.permission,
                    namerute: this.namaRoute
                };
                this.master.push(fieldMaster);
                this.formmenu.menuItem.push(tambahField);
            } else {
                this.master.splice(value, 1);
                this.formmenu.menuItem.splice(value, 1);
            }

        },



        simpan() {
            if (this.editMode == true) {
                this.formmenu.put(route('role.update', this.objrole.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objrole = null;
                        this.formrole.reset();
                    }
                })

            } else {
                this.formmenu.post(route('menu.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objmenu = null;
                        this.formmenu.reset();
                    },
                })
            }

        },
        hapus() {
            this.formrole.delete(route('role.delete', this.objrole.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.dialogHapus = !this.dialogHapus;
                    this.objrole = null;
                }
            })
        },

    },


};
</script>
<style scoped>
.drop-zone {
    background-color: #eee;
    margin-bottom: 10px;
    padding: 10px;
}

.drag-el {
    background-color: #fff;
    margin-bottom: 10px;
    padding: 5px;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
