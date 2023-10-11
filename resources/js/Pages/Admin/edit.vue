<script setup>
    import AdminLayout from '@/Layouts/Admin.vue';
    import CardTable from "@/Components/Cards/CardTable.vue";
    import HeaderStats from "@/Components/Headers/HeaderStats.vue";
    import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
    import Modal from '@/Components/Modal.vue';
    import Dialog from '@/Components/Dialog.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head,Link } from '@inertiajs/inertia-vue3';
    import FormStepper from '@/Components/Forms/FormStepper.vue';
    import { useVuelidate } from '@vuelidate/core'
    import { required, email } from '@vuelidate/validators'

</script>

<template>
    <Head title="Role" />
    <AdminLayout>
        <template #textnavbar>
            ROLE
        </template> 
        <template #header>
            <header-stats>
                <template #kontenheader>
                    
                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4 animatecss animatecss-fadeInLeft ">
            <div class="w-full mb-12 px-4 min-h-full ">
                <card-table   @clickedit="clickedit" @clickhapus="clickhapus" :list=role.data :header=setting>
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
                            <li class="page-item" v-for="paging in role?role.links:[]" :key="paging.id">
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
        <FormStepper :header="stepper" :currentStep="currentStep" @directStep="directStep" @nextStep="nextStep" @prevStep="prevStep" :batasStep="batasStep">
            <div v-for="(step, index) in stepper" :key="index" :class="{ 'hidden': currentStep !== index }">
                <div v-if="index === 0" class="animatecss animatecss-fadeInLeft">
                    <div class="font-bold text-gray-600 text-xs leading-8 uppercase h-6 mx-2 mt-3">Full tess</div>
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full flex-1 mx-2 svelte-1l8159u">
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input v-model="name" placeholder="First Name" class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                                <div v-if="v$.name.$error">Name field has an error.</div>
                            </div>
                        <div class="w-full flex-1 mx-2 svelte-1l8159u">
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="Last Name" class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Username</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="Just a hint.." class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Your Email</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="jhon@doe.com" class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                    </div>
                </div>
                <div v-if="index === 1"  class="animatecss animatecss-fadeInLeft">
                    
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Username</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="Just a hint.." class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Your Email</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="jhon@doe.com" class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                    </div>
                </div>
                <div v-if="index === 2"  class="animatecss animatecss-fadeInLeft">
                    
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Username</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="Just a hint.." class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                        <div class="w-full mx-2 flex-1 svelte-1l8159u">
                            <div class="font-bold h-6 mt-3 text-gray-600 text-xs leading-8 uppercase"> Your Email</div>
                            <div class="bg-white my-2 p-1 flex border border-gray-200 rounded svelte-1l8159u">
                                <input placeholder="jhon@doe.com" class="p-1 px-2 appearance-none outline-none w-full text-gray-800"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="flex justify-between mt-8">
                <button @click="prevStep" :disabled="currentStep === 0" class="bg-gray-300 px-4 py-2 rounded">Previous</button>
                <button @click="nextStep" :disabled="currentStep === stepper.length - 1" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
            </div> -->
    </FormStepper>
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
                            <InputLabel for="role" value="Role" class="" />
                            <TextInput
                                id="role"
                                ref="roleInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Role"
                                v-model="formrole.role"
                            />
                            <p v-if="formrole.errors.role" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formrole.errors.role }}
                            </p>
                        </div>
                        
                    </div>
                

                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                        
                        <template v-for="(chunk, index) in chunkedData" :key="index">
                            <div class="relative mb-4"  >
                                <div class="form-check" v-for="( data, index )  in chunk" :key="data.id"  >
                                
                                    <input class="form-check-input appearance-none h-4 w-4 border
                                        border-gray-300 rounded-sm bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 
                                        focus:outline-none transition duration-200 mt-1 
                                        align-top bg-no-repeat bg-center bg-contain float-left 
                                        mr-2 cursor-pointer" type="checkbox" v-bind:value="data.id" v-bind:id="data.id" v-model="formrole.permission">
                                    <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                        {{data.name}} 
                                    </label>
                                </div>
                            </div >
                        </template>
                    </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': formrole.processing }" :disabled="formrole.processing">
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
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': formrole.processing }" :disabled="formrole.processing">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
    </Dialog>
</template>

<script>
    export default {
        components: {
            FormStepper
        },
        props: {
            role: Object,
            permission: Object
        },
        computed: {
            chunkedData() { 
                return this.chunkArray(this.permission, 10);
            }
        },
        
        data() {
            return {
                v$: useVuelidate(),
                name:null,
                showModal: false,
                dialogHapus:false,
                editMode: false,
                objrole : null,
                formrole: this.$inertia.form({
                    role: null,
                    permission : []
                }),
                currentStep: 0,
                batasStep : 0,
                formData: {
                // Your form data goes here
                    step1Data: 'satu',
                    step2Data: 'dua',
                //              ...
                },
                setting: [ //seting header table
                    {
                        title: 'Role',
                        field: 'name',
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
                stepper: [ //step wizard
                    {
                        title: 'data personal',
                        
                    },
                    {
                        title: 'tes2',
                      
                    },
                    {
                        title: 'tes3',
                      
                    },
                ],
            };
        },
        validations () {
            return {
                name: { required }, // Matches this.firstName
                
            }
        },
        methods: {
            nextStep() {
                this.v$.$validate();
                if (!this.v$.$error) {
                // if ANY fail validation
                    if (this.currentStep < this.stepper.length - 1) {
                        this.currentStep++;
                        }
                    if (this.batasStep <= this.currentStep ) {
                        this.batasStep = this.currentStep;
                    }
                } 
            
            },
            prevStep() {
                if (this.currentStep > 0) {
                this.currentStep--;
                }
            },
            directStep(value) {
                this.v$.$validate();
                if (!this.v$.$error) {
                    this.currentStep = value;
                }
            
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
                this.objrole = null;
                this.showModal = !this.showModal;
                this.formrole.reset()
                this.formrole.clearErrors()
            },
            closeModal(){
                this.editMode = false;
                this.showModal = !this.showModal;
                this.formrole.reset();
                this.formrole.clearErrors()
            },
            clickedit(value){
                this.editMode = true;
                this.objrole = value;
                this.showModal = !this.showModal;
                this.formrole.reset()
                this.formrole.clearErrors()
                this.formrole.role = value.name;
                this.formrole.permission =  _.map(value.permission, 'id')
                
            },
            clickhapus(value){
        
                this.objrole = value;
                this.dialogHapus = !this.dialogHapus;
            
            },
            closeDialogHapus: function () {
                this.dialogHapus = !this.dialogHapus;
            },
            simpan() {
                if (this.editMode == true) {
                    this.formrole.put(route('role.update', this.objrole.id), {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            this.showModal = !this.showModal;
                            this.objrole = null;
                            this.formrole.reset();
                        }
                    })

                } else {
                    this.formrole.post(route('role.store'), {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            this.showModal = !this.showModal;
                            this.objrole = null;
                            this.formrole.reset();
                        },
                    })
                }

            },
            hapus(){
                this.formrole.delete(route('role.delete', this.objrole.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.dialogHapus = !this.dialogHapus;
                        this.objrole = null;
                    }
                })
            },
              
        }
    };
</script>
