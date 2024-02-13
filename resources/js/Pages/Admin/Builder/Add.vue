<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import Card from "@/Components/Cards/Card.vue";
import Headers from "@/Components/Headers/Headers.vue";
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import ToastList from '@/Components/Notifications/ToastList.vue';
import { useVuelidate } from '@vuelidate/core'
import { required, helpers } from '@vuelidate/validators'
import toast from '@/Stores/toast.js';
import draggable from "vuedraggable";
import VueJsoneditor from 'vue3-ts-jsoneditor';

</script>

<template>
    <Head>
        <title>{{title}}</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            Form Builder
        </template>
        <template #notif>

            <ToastList />

        </template>

        <template #header>

            <headers>

                <template #kontenheader>

                    <card :minheigth="'min-h-0'">
                        <template #headercard>

                            <div
                                class="pt-2 pb-2 z-1 -mt-8 mx-4 rounded-xl bg-gradient-to-r from-emerald-500 to-lime-400 shadow-lg">
                                <div class="flex flex-wrap items-center">
                                    <div class="max-w-full flex-grow p-4 ml-4">
                                        <h3 class="font-semibold text-lg"
                                            :class="[color === 'light' ? 'text-white' : 'text-white']">
                                            Table Info
                                        </h3>
                                    </div>
                                    <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right p-4 mr-4">
                                        <div class="hidden md:block">
                                            <PrimaryButton v-on:click="kembali"
                                                class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">
                                                Kembali</PrimaryButton>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>


                        <div class="bg-white overflow-hidden w-full transform transition-all sm:w-full sm:mx-auto ">
                            <div class="relative px-6 pb-4 mx-2 flex-auto">
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mt-2 ">
                                    <div class="relative  ">

                                        <InputLabel for="tableName" value="Table Name" class="" />
                                        <TextInput id="tableName" ref="tableNameInput" type="text" class="mt-1 block w-full"
                                            v-model="formBuilder.table" placeholder="table name" />
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                                    <div class="relative  ">
                                        <InputLabel for="displayName" value="Display Name" class="" />
                                        <TextInput id="displayName" ref="displayNameInput" type="text"
                                            class="mt-1 block w-full" v-model="formBuilder.display_name"
                                            placeholder="display name" />
                                    </div>
                                    <div class="relative  ">
                                        <InputLabel for="urlSlug" value="URL Slug" class="" />
                                        <TextInput id="urlSlug" ref="urlSlugInput" type="text" class="mt-1 block w-full"
                                            v-model="formBuilder.slug" placeholder="URL slug" />
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mt-2 ">
                                    <div class="relative  ">
                                        <InputLabel for="modelName" value="Model Name" class="" />
                                        <TextInput id="modelName" ref="modelNameInput" type="text" class="mt-1 block w-full"
                                            v-model="formBuilder.model_name" placeholder="model name" />
                                    </div>
                                    <div class="relative  ">
                                        <InputLabel for="controllerName" value="Controller Name" class="" />
                                        <TextInput id="controllerName" ref="controllerNameInput" type="text"
                                            class="mt-1 block w-full" v-model="formBuilder.controller" placeholder="controller name" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </card>
                </template>
            </headers>
        </template>

        <div class="flex flex-wrap mt-4 ">
            <div class="w-full mb-12 ">
                <card :minheigth="'min-h-32'">
                    <template #headercard>
                        <div class="rounded-t mb-0 px-4 pt-6 border-0">
                            <div class="flex flex-wrap items-center">
                                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-lg"
                                        :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                                        Row Table
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="bg-white overflow-hidden px-8 pb-4 w-full transform transition-all sm:w-full sm:mx-auto ">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table
                                            class="min-w-full border text-center text-sm font-light dark:border-gray-300">
                                            <thead class="border-b bg-gray-100 font-medium dark:border-gray-300">
                                                <tr>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-gray-300">
                                                        Field
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-gray-300">
                                                        Visibility
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-gray-300">
                                                        Input Type
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-gray-300">
                                                        Display Name
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-4 py-4 dark:border-gray-300 text-left">
                                                        Option Details
                                                    </th>
                                                    <th v-if="action == 'edit'" scope="col"
                                                        class="border-r px-4 py-4 dark:border-gray-300 text-center">
                                                        Action
                                                    </th>

                                                </tr>
                                            </thead>
                                            <transition-group>
                                                <draggable :list="formBuilder.fieldOptions" :animation="300" item-key="name"
                                                    :key="item => item.id" tag="tbody" 
                                                    >
                                                
                                                    <template v-slot:item="{ element, index }">
                                                  
                                                        <tr >
                                                           
                                                            <td
                                                                class="whitespace-nowrap border align-top px-1 py-1  w-1/5 text-left font-medium dark:border-gray-300 " 
                                                                 
                                                                >
                                                              
                                                                <ul class="pl-2 list-none">
                                                                    
                                                                    <li class="pb-2"><b class="italic text-lg underline ">{{
                                                                        element.field }}</b> </li>
                                                                    <li><b>Type</b> : {{ element.type }}</li>
                                                                    <li><b>Key</b> : {{ element.key }}</li>
                                                                    <li><b>AutoIncrement</b> : {{ element.autoincrement }}</li>
                                                                    <li><b>Required</b> : {{ element.required }}</li>
                                                                </ul>
                                                                
                                                              
                                                               
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap border px-1 py-1  align-top w-8 text-left font-medium dark:border-gray-300 "
                                                                  >
                                                                <ul class="pl-2 list-none">
                                                                   
                                                                        <li class="m-1">
                                                                            
                                                                            <div class="form-check"><input class="form-check-input appearance-none h-4 w-4 border border-gray-300 
                                                                                rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none 
                                                                                transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                                                v-model="element.browse"
                                                                                type="checkbox"  :disabled="element.autoincrement ? true : false">
                                                                                <label class="form-check-label inline-block text-gray-800" >Browse</label></div>
                                                                           
                                                                            </li>
                                                                        <li  class="m-1">
                                                                            <div class="form-check"><input class="form-check-input appearance-none h-4 w-4 border border-gray-300 
                                                                                rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none 
                                                                                transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                                                v-model="element.read"
                                                                                type="checkbox" :disabled="element.autoincrement ? true : false">
                                                                                <label class="form-check-label inline-block text-gray-800" >Read</label></div>
                                                                        </li>
                                                                        <li  class="m-1">
                                                                            <div class="form-check"><input class="form-check-input appearance-none h-4 w-4 border border-gray-300 
                                                                                rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none 
                                                                                transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                                                v-model="element.edit"
                                                                                type="checkbox" :disabled="element.autoincrement ? true : false">
                                                                                <label class="form-check-label inline-block text-gray-800" >Edit</label></div>
                                                                        </li>
                                                                        <li  class="m-1">
                                                                            <div class="form-check"><input class="form-check-input appearance-none h-4 w-4 border border-gray-300 
                                                                                rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none 
                                                                                transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" 
                                                                                v-model="element.add"
                                                                                type="checkbox" :disabled="element.autoincrement ? true : false">
                                                                                <label class="form-check-label inline-block text-gray-800" >Add</label></div>
                                                                        </li>
                                                                        <li  class="m-1">
                                                                            <div class="form-check"><input class="form-check-input appearance-none h-4 w-4 border border-gray-300 
                                                                                rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none 
                                                                                transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                                                v-model="element.delete"
                                                                                type="checkbox" :disabled="element.autoincrement ? true : false">
                                                                                <label class="form-check-label inline-block text-gray-800" >Delete</label></div>
                                                                        </li>
                                                                    
                                                                </ul>

                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap border px-2 py-2 align-top w-8 font-medium dark:border-gray-300"
                                                                 >
                                                                <select class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                                        ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                                        focus:ring-indigo-600 sm:text-sm sm:leading-6 w-28" v-model="formBuilder.fieldOptions[index].inputType"
                                                                        :name="'inputType'+index"  :disabled="element.autoincrement ? true : false">
                                                                        <template v-for="option in masterInputType">
                                                                            <option :value="option">
                                                                                {{ option }}
                                                                            </option>
                                                                        </template>
                                                                    </select>
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap border px-2 py-2 align-top w-8 font-medium dark:border-gray-300"   >
                                                                <input type="text" class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                                ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                                focus:ring-indigo-600 sm:text-sm sm:leading-6 w-36" v-model="formBuilder.fieldOptions[index].display_name"
                                                                :name="'displayName'+index" :disabled="element.autoincrement ? true : false">
                                                            </td>
                                                            <td class="px-4 border text-left py-4 align-top dark:border-gray-300"   >
                                                        
                                                                    <vue-jsoneditor
                                                                        v-model="formBuilder.fieldOptions[index].detail"
                                                                        :mainMenuBar="false"
                                                                        :mode="'text'"
                                                                        :disabled="element.autoincrement ? true : false"
                                                                    />
                                                                
                                                            </td>
                                                            <td v-if="action == 'edit'"
                                                                class="whitespace-nowrap border px-2 py-2 align-top w-8 font-medium dark:border-gray-300"   >
                                                                <PrimaryButton  v-on="{ click: formBuilder.fieldOptions[index].is_diHapus ? () => kembalikanYangDiHapus(index) : () => hapus(index) }"
                                                                    :class="[element.is_diHapus ? 'bg-indigo-700 border-indigo-700 hover:bg-indigo-800 focus:bg-indigo-800 focus:ring-indigo-300' :
                                                    'bg-red-700 border-red-700 hover:bg-red-800 focus:bg-red-800 focus:ring-red-300']"> 
                                                        
                                                            <template v-if="element.is_diHapus">
                                                                <i class="fas fa-lg fa-sync"></i>
                                                            </template>
                                                            <template v-else>
                                                                <i class="fas fa-lg fa-trash-alt"></i>
                                                            </template>
                                                            </PrimaryButton>
                                                            </td>
                                                        </tr>

                                                    </template>
                                                </draggable>
                                            </transition-group>
                                        </table>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template #footercard>
                        <div class="flex mb-4 mr-6 p-2 justify-end">

                            <PrimaryButton class=" " v-on:click="simpan">
                                <span class="mr-2"> <i class="fas fa-save "></i> </span>
                                Simpan
                            </PrimaryButton>
                        </div>
                    </template>
                </card>
            </div>
        </div>
    </AdminLayout>
</template>

<script>

export default {

    props: {
        color: {
            default: "light",
            validator: function (value) {
                // The value must match one of these strings
                return ["light", "dark"].indexOf(value) !== -1;
            },
        },
        data: Object,
        action : String,
        title: String

    },

    components: {
        draggable
    },
    watch: {

    },
    created() {

    },
    data() {
        return {
            masterInputType:['Text','textarea','Number','password','Date','Radiogroup','select','multiselect'],
            formBuilder:  this.action == 'edit' ? this.dataUpdate() : this.dataTambahBaru()
    
        };
    },

    computed: {
    
    },

    validations() {

    },


    methods: {
        dataTambahBaru(){
            
            return this.$inertia.form(
                //  this.action == 'edit' ? this.data.dataType.name :
                {
                table: this.data.table,
                slug: this.data.slug,
                display_name: this.data.display_name,
                display_name_plural: this.data.display_name_plural,
                // model_name: "App\\Models\\Sukoati\\"+ this.data.table.charAt(0).toUpperCase() + this.data.table.slice(1),
                model_name: this.data.model_names,
                controller: null,
                fieldOptions: Object.values(this.data.fieldOptions).map((item,index) => {
                    let order = index+1;
                    return {
                        order:order,
                        field: item.field,
                        key: item.key,
                        autoincrement : item.autoincrement,
                        required: item.notnull,
                        inputType: 'Text',
                        display_name: this.formatText(item.name),
                        detail: {},
                        browse : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                        read : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                        edit : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                        add : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                        delete : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true
                    }
                }),

            })
        },
        dataUpdate(){
            return this.$inertia.form(
                {
                id:this.data.dataType.id,
                table: this.data.dataType.name,
                slug: this.data.dataType.slug,
                display_name: this.data.dataType.display_name_singular,
                display_name_plural: this.data.dataType.display_name_plural,
                // model_name: "App\\Models\\Sukoati\\"+ this.data.table.charAt(0).toUpperCase() + this.data.table.slice(1),
                model_name: this.data.dataType.model_name,
                controller: this.data.dataType.controller,
                fieldOptions: Object.values(this.data.fieldOptions).map((item,index) => {
                    let order = index+1;
                    let data= this.data.dataType.rows.filter(itemdata => itemdata.field == item.field);
                    
                    if(data.length > 0){
                        return {
                            id: data[0].id,
                            order:order,
                            field: item.field,
                            key: item.key,
                            autoincrement : item.autoincrement,
                            required: item.notnull,
                            inputType: data[0].type,
                            display_name: data[0].display_name,
                            detail: JSON.parse(data[0].details),
                            browse : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:(data[0].browse==1?true:false),
                            read : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:(data[0].read==1?true:false),
                            edit : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:(data[0].edit==1?true:false),
                            add : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:(data[0].add==1?true:false),
                            delete : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:(data[0].delete==1?true:false)
                        }
                    }else{
                        return {
                            order:order,
                            field: item.field,
                            key: item.key,
                            autoincrement : item.autoincrement,
                            required: item.notnull,
                            inputType: 'Text',
                            display_name: this.formatText(item.name),
                            detail: {},
                            browse : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                            read : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                            edit : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                            add : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true,
                            delete : item.field === 'id' || item.field === 'deleted_at' || item.field ==='created_at' || item.field === 'updated_at' ? false:true
                        }
                    }
                    
                }),

            })
        },
        hapus: function (index) {
            
            let field=  this.formBuilder.fieldOptions[index].field;
            let order=  this.formBuilder.fieldOptions[index].order;
            let dataAwal = this.data.fieldOptions[field];
            // const valueAsli = this.objMenuKategori.menu_item[index].title; //kembalikan ke nilai awal jika field nama menu dikosongkan, untuk cek validasi dibackend
            this.formBuilder.fieldOptions[index].is_diHapus = true;
            this.formBuilder.fieldOptions[index].order = order;
            this.formBuilder.fieldOptions[index].field = dataAwal.field;
            this.formBuilder.fieldOptions[index].key = dataAwal.key;
            this.formBuilder.fieldOptions[index].autoincrement = dataAwal.autoincrement;
            this.formBuilder.fieldOptions[index].required = dataAwal.notnull;
            this.formBuilder.fieldOptions[index].inputType = 'Text';
            this.formBuilder.fieldOptions[index].display_name = this.formatText(dataAwal.name);
            this.formBuilder.fieldOptions[index].detail = {};
            this.formBuilder.fieldOptions[index].browse = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:true;
            this.formBuilder.fieldOptions[index].read = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:true;
            this.formBuilder.fieldOptions[index].edit = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:true;
            this.formBuilder.fieldOptions[index].add = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:true;
            this.formBuilder.fieldOptions[index].delete = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:true;
            
            // this.formmenu.menuItem[index].nama_menu = valueAsli;
        },
        kembalikanYangDiHapus: function (index) {
            let field=  this.formBuilder.fieldOptions[index].field;
            let dataAwal = this.data.fieldOptions[field];
            let data= this.data.dataType.rows.filter(itemdata => itemdata.field == field);
            this.formBuilder.fieldOptions[index].is_diHapus = false;
            if(data.length > 0){
                this.formBuilder.fieldOptions[index].inputType = data[0].type;
                this.formBuilder.fieldOptions[index].display_name = data[0].display_name;
                this.formBuilder.fieldOptions[index].detail = JSON.parse(data[0].details);
                this.formBuilder.fieldOptions[index].browse = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:(data[0].browse==1?true:false);
                this.formBuilder.fieldOptions[index].read = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:(data[0].read==1?true:false);
                this.formBuilder.fieldOptions[index].edit = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:(data[0].edit==1?true:false);
                this.formBuilder.fieldOptions[index].add = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:(data[0].add==1?true:false);
                this.formBuilder.fieldOptions[index].delete = dataAwal.field === 'id' || dataAwal.field === 'deleted_at' || dataAwal.field ==='created_at' || dataAwal.field === 'updated_at' ? false:(data[0].delete==1?true:false);
            }
        },

        kembali() {
            Inertia.get(route('builder.index'), {}, { replace: true })
        },
        simpan() {
            if (this.action === 'edit') {
                this.formBuilder.put(route('builder.update'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.formBuilder.reset();
                    },
                    onError: (errors) => {
                        console.log(errors);
                    }
                })
            }else{
                this.formBuilder.post(route('builder.store'), {
                    preserveScroll: false,
                    preserveState: false,
                    onSuccess: () => {
                        // location.reload(true);
                        // this.formBuilder.reset();
                        // Inertia.get(route('builder.index'), {}, { replace: true })
                    },
                    onError: (errors) => {
                        console.log(errors);
                    }
                })
            }
        },
        formatText: function (value) {
            const stringWithSpaces = value.replace(/_/g, ' ');

            const trimmedString = stringWithSpaces.trim();

            return trimmedString; 
        },
    
    },
};
</script>


