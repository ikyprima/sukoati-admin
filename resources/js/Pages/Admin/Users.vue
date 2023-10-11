<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/Cards/CardTable.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import { Head,Link } from '@inertiajs/inertia-vue3';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import Modal from '@/Components/Modal.vue';
import Dialog from '@/Components/Dialog.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
// import { Select, initTE } from "tw-elements";
// initTE({ Select });
</script>

<template>

    <Head title="Role" />

    <AdminLayout>
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <card-table   @clickedit="clickedit" @clickhapus="clickhapus" :list=listuser.data :header=setting>
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
                            <li class="page-item" v-for="paging in listuser?listuser.links:[]" :key="paging.id">
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
                    <template v-if="editMode == true">
                        Ubah
                    </template>
                    <template v-else>
                        Tambah
                    </template>
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="user" value="Nama User" class="" />
                            <TextInput
                                id="user"
                                ref="userInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Nama User"
                                v-model="formuser.name"
                            />
                            <p v-if="formuser.errors.name" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formuser.errors.name }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                            <InputLabel for="username" value="Username" class="" />
                            <TextInput
                                id="username"
                                ref="usernameInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Username"
                                v-model="formuser.username"
                            />
                            <p v-if="formuser.errors.username" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formuser.errors.username }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                            <InputLabel for="email" value="Email" class="" />
                            <TextInput
                                id="email"
                                ref="emailInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Email"
                                v-model="formuser.email"
                            />
                            <p v-if="formuser.errors.email" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formuser.errors.email }}
                            </p>
                        </div>
                        <template v-if="editMode == true">
                            <div class="relative mb-2">
                                <input class="form-check-input appearance-none h-4 w-4 border
                                    border-gray-300 rounded-sm bg-white 
                                    checked:bg-blue-600 checked:border-blue-600 
                                    focus:outline-none transition duration-200 mt-1 
                                    align-top bg-no-repeat bg-center bg-contain float-left 
                                    mr-2 cursor-pointer" type="checkbox"  v-bind:id="'id_update_password'" v-model="formuser.updatepassword" 
                                    >
                                <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                    Ubah Password ?
                                </label>
                            
                            </div>
                        </template>
                        <template v-if="editMode == false || formuser.updatepassword == true ">
                            <div class="relative mb-2">
                            <InputLabel for="password" value="Password" class="" />
                            <TextInput
                                id="password"
                                ref="passwordInput"
                                type="password"
                                class="mt-1 block w-full"
                                placeholder="Password"
                                v-model="formuser.password"
                            />
                            <p v-if="formuser.errors.password" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formuser.errors.password }}
                            </p>
                        </div>
                        </template>
                        
                        <div class="relative mb-2 ">
                            
                        
                            <fieldset class='p-3 border border-2'>
                                <legend class="block font-medium text-sm text-gray-700">Berikan Role Ke Pengguna</legend>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                        
                                    <template v-for="(chunk, index) in chunkArray(role,10)" :key="index">
                                        <div class="relative mb-1"  >
                                            <div class="form-check" v-for="( data, index )  in chunk" :key="data.id"  >
                                            
                                                <input class="form-check-input appearance-none h-4 w-4 border
                                                    border-gray-300 rounded-sm bg-white 
                                                    checked:bg-blue-600 checked:border-blue-600 
                                                    focus:outline-none transition duration-200 mt-1 
                                                    align-top bg-no-repeat bg-center bg-contain float-left 
                                                    mr-2 cursor-pointer" type="checkbox"  v-bind:value="data.id" v-bind:id="'role_'+data.id" v-model="formuser.role" 
                                                    @change="roleklik(data,$event)">
                                                <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                                    {{data.name}} 
                                                </label>
                                            </div>
                                        </div >
                                    </template>
                                </div>
                            </fieldset>
                        
                        </div>
                        <div class="relative mb-2 ">
                        
                            <fieldset class='p-3 border border-2'>
                                <legend class="block font-medium text-sm text-gray-700">Berikan Permission Ke Pengguna</legend>
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-4"> 
                                    <template v-for="(chunk, index) in chunkArray(masterPermission,10)" :key="index">
                                        <div class="relative mb-1"  >
                                            <div class="form-check" v-for="( data, index )  in chunk" :key="data.id"  >
                                                    <input class="form-check-input appearance-none h-4 w-4 border
                                                    border-gray-300 rounded-sm bg-white 
                                                    checked:bg-blue-600 checked:border-blue-600 
                                                    focus:outline-none transition duration-200 mt-1 
                                                    align-top bg-no-repeat bg-center bg-contain float-left 
                                                    mr-2 cursor-pointer" type="checkbox" 
                                                    :disabled="data.status == false"
                                                    v-bind:value="data.id" 
                                                    v-bind:id="'permission_'+data.id" 
                                                    v-model="formuser.permission" 
                                                    >
                                                    <label class="form-check-label inline-block text-gray-800  " for="flexCheckDefault">
                                                        {{data.name}} 
                                                    </label>
                                                
                                            
                                                
                                            </div>
                                        </div >
                                    </template>
                                </div>
                            </fieldset>
                            
                        </div>
                    </div>
                

                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                        
                    
                        </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': formuser.processing }" :disabled="formuser.processing">
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
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': formuser.processing }" :disabled="formuser.processing">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
    </Dialog>
</template>

<script>

export default {
    props:{
        listuser : Object,
        role : Object,
        permission : Object
    },

    data() {
        return {
            
            showModal: false,
            dialogHapus:false,
            editMode: false,
            objuser : null,
            masterPermission : [],
            formuser: this.$inertia.form({
                name: null,
                username: null,
                email: null,
                role : [],
                permission : [],
                password: null,
                updatepassword : null
            }),
            setting: [ //seting header table
                    {
                        title: 'Name',
                        field: 'name',
                        type: 'string',
                        size: 'auto',
                        align: 'left'
                    },
                    {
                        title: 'Username',
                        field: 'username',
                        type: 'string',
                        size: 'auto',
                        align: 'left'
                    },
                    {
                        title: 'Email',
                        field: 'email',
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
    computed: {
    
    },
    methods: {
        roleklik : function(value,event) {
            var targetIds = _.map(value.permissions, 'id'); //pluck id permissions pada role
        
            // var newKey = 'status';
            // var newValue = false; 
            if (event.target.checked) {
                targetIds.sort((a, b) => b - a); // Urutkan secara menurun untuk menghindari perulangan indeks
    
                targetIds.forEach(id => {
                    const index = this.masterPermission.findIndex(item => item.id === id);
                    if (index !== -1) {
                        this.masterPermission.splice(index, 1);
                    }
                });
            }else{
                value.permissions.forEach(element => {
                    this.masterPermission.push(element);
                });
                this.masterPermission.sort((a, b) => a.id - b.id);
            
            }

            // if (event.target.checked) {
            //     // alert('isSelected');
            //     var targetObjs = this.masterPermission.filter(item => targetIds.includes(item.id));
            //     targetObjs.forEach(obj => {
            //         // Menambahkan kunci baru ke objek
            //         obj[newKey] = newValue;
            //     });   
            //     console.log('check');
            // }else{
            //     var targetObjs = this.masterPermission.filter(item => targetIds.includes(item.id));
            //     targetObjs.forEach(obj => {
            //         // Menghapus kunci dari objek
            //         delete obj[newKey];
            //     });
            //     console.log('uncheck');
            // }
            
        },
        chunkArray(arr, size) {
            const chunks = [];
            for (let i = 0; i < arr.length; i += size) {
            chunks.push(arr.slice(i, i + size));
            }
            return chunks;
        },
        tambahData() {
            this.editMode = false;
            this.objuser = null;
            this.showModal = !this.showModal;
            this.formuser.reset()
            this.formuser.clearErrors()
            this.masterPermission.splice(0);
            this.permission.forEach(element => {
                this.masterPermission.push(element);
            });
            
        },
        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
            this.formuser.reset();
            this.formuser.clearErrors();
        
        },
        clickedit(value){
            this.masterPermission.splice(0);
            value.permission.forEach(element => {
                this.masterPermission.push(element);
            });
            this.editMode = true;
            this.objuser = value;
            this.showModal = !this.showModal;
            this.formuser.reset()
            this.formuser.clearErrors()
            this.formuser.name = value.name;
            this.formuser.username = value.username;
            this.formuser.email = value.email;
            this.formuser.role =  value.role
            this.formuser.permission = value.id_directpermission;
            
        },
        clickhapus(value){
            this.objuser = value;
            this.dialogHapus = !this.dialogHapus;
        
        },
        closeDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        simpan() {
            if (this.editMode == true) {
                this.formuser.put(route('user.update', this.objuser.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objuser = null;
                        this.formuser.reset();
                    }
                })

            } else {
                this.formuser.post(route('user.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.showModal = !this.showModal;
                        this.objuser = null;
                        this.formuser.reset();
                    },
                })
            }

        },
        hapus(){
            this.formuser.delete(route('user.delete', this.objuser.id), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.dialogHapus = !this.dialogHapus;
                    this.objuser = null;
                }
            })
        }
    },

    
};
</script>