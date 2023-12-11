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
</script>

<template>
    <Head>
        <title>Manajemen Database</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            
            manajemen database
        </template>
        <template #notif>
         
        <ToastList/>

        </template>

        <template #header>

            <headers>
                
                <template #kontenheader>

                    <card :minheigth="'min-h-0'">
                        <template #headercard>
                            <div class="pt-2 pb-2 mx-8 border-b border-solid border-blueGray-200 ">
                                <div class="flex flex-wrap items-center">
                                <div class="max-w-full flex-grow">
                                    <h3 class="font-semibold text-lg"
                                        :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                                        {{ action === 'update' ? 'Update Table' : 'Add Table' }}
                                       
                                    </h3>
                                </div>
                                    <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right">
                                        <div class="hidden md:block">
                                            <PrimaryButton  v-on:click="kembali" class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">Kembali</PrimaryButton>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template> 
                        <div class="bg-white overflow-hidden  w-full transform transition-all sm:w-full sm:mx-auto ">
                            <div class="relative px-6 pb-4 mx-2 flex-auto">
                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                    <div class="relative  ">

                                        <InputLabel value="Name Table" class="" />
                                        <TextInput id="namaTable" ref="namaTableInput" type="text" class="mt-1 block w-full"
                                            placeholder="name table" v-model="tableName" />
                                        <p v-if="v$.tableName.$error" class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            silahkan isi dengan format / karakter yang ditentukan <b>"a-z A-Z 0-9 _"</b> dan
                                            kata selain ['select', 'insert', 'update', 'delete']
                                        </p>
                                    </div>
                                    <div class="relative  ">
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
                                        Column Table
                                    </h3>
                                </div>
                                <div class=" relative md:w-full px-4 md:max-w-full flex-grow flex-1 text-right">
                                    <div class="hidden md:block">
                                        <ButtonTambah v-on:click="simpan">
                                            <div v-if="action === 'update'">
                                                Simpan Perubahan
                                            </div>
                                            <div v-else>
                                                Simpan
                                            </div>
                                        </ButtonTambah>
                                    </div>
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
                                            class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                            <thead class="border-b bg-gray-100 font-medium dark:border-neutral-500">
                                                <tr>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Type
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Length
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-4 py-4 dark:border-neutral-500 text-left">
                                                        Not Null
                                                    </th>
                                                    <th scope="col" class="border-r px-2 py-4 dark:border-neutral-500 ">
                                                        Unsigned
                                                    </th>
                                                    <th scope="col" class="border-r px-2 py-4 dark:border-neutral-500">
                                                        Auto Increment
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500 ">
                                                        Index
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Default
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in formTable.columns" :key="index"
                                                    class="border-b dark:border-neutral-500">
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <input type="text" class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                            ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                            focus:ring-indigo-600 sm:text-sm sm:leading-6 w-40"
                                                            v-model="formTable.columns[index].name"
                                                            @input="(e) => inputNamaKolom(e.target.value, index)"
                                                            @keyup="(e) => cekNamaSama(e.target.value, index)">
                                                        <template v-if="v$.formTable.columns.$errors.length > 0">
                                                            <p v-if="v$.formTable.columns.$each.$response.$errors[index].name[0]"
                                                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                                {{
                                                                    v$.formTable.columns.$each.$response.$errors[index].name[0].$message
                                                                }}
                                                            </p>
                                                        </template>
                                                        <p v-if="formTable.errors['kolom.' + index + '.name']"
                                                            class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ formTable.errors['kolom.' + index + '.name'] }}
                                                        </p>


                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <select class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                            ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                            focus:ring-indigo-600 sm:text-sm sm:leading-6 w-32"
                                                            @change="(e) => pilihType(e, index)">
                                                            <optgroup v-for="(group, name) in master[index].dataType"
                                                                :label="name">
                                                                <template v-for="option in group">
                                                                    <option
                                                                        v-if="formTable.columns[index].type.name == option.name"
                                                                        :value="option.name" selected>
                                                                        {{ option.name }}
                                                                    </option>
                                                                    <option v-else :value="option.name">
                                                                        {{ option.name }}
                                                                    </option>
                                                                </template>

                                                            </optgroup>
                                                        </select>
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <input type="number" min="0" class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                            ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                            focus:ring-indigo-600 sm:text-sm sm:leading-6 w-24"
                                                            v-model="formTable.columns[index].length">
                                                    </td>

                                                    <td
                                                        class="whitespace-nowrap border-r px-2 py-2 text-center w-8 font-medium dark:border-neutral-500">
                                                        <input class="form-check-input appearance-none h-4 w-2 border
                                                        border-gray-300 rounded-sm bg-white 
                                                        checked:bg-blue-600 checked:border-blue-600 
                                                        focus:outline-none transition duration-200 mt-1 
                                                        align-top bg-no-repeat bg-center bg-contain float-center 
                                                        cursor-pointer" type="checkbox"
                                                            v-model="formTable.columns[index].notnull">
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-2 py-2 text-center w-4 font-medium dark:border-neutral-500">
                                                        <input class="form-check-input appearance-none h-4 w-2 border
                                                        border-gray-300 rounded-sm bg-white 
                                                        checked:bg-blue-600 checked:border-blue-600 
                                                        focus:outline-none transition duration-200 mt-1 
                                                        align-top bg-no-repeat bg-center bg-contain float-center 
                                                        cursor-pointer" type="checkbox"
                                                            v-model="formTable.columns[index].unsigned"
                                                            :disabled="formTable.columns[index].type.category !== 'Numbers'"
                                                            @change="(e) => unsignedKlik(item, e, index)">
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-2 py-2 text-center w-8 font-medium dark:border-neutral-500">
                                                        <input class="form-check-input appearance-none h-4 w-2 border
                                                        border-gray-300 rounded-sm bg-white 
                                                        checked:bg-blue-600 checked:border-blue-600 
                                                        focus:outline-none transition duration-200 mt-1 
                                                        align-top bg-no-repeat bg-center bg-contain float-center 
                                                        cursor-pointer" type="checkbox"
                                                            v-model="formTable.columns[index].autoincrement">
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <select class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                            ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                            focus:ring-indigo-600 sm:text-sm sm:leading-6 w-28"
                                                            @change="(e) => pilihIndex(e, index)">
                                                            <template v-for="option in master[index].index">
                                                                <option
                                                                    v-if="index == 0 && formTable.columns[index].name == 'id' && option == 'PRIMARY'"
                                                                    :value="option" selected>
                                                                    {{ option }}
                                                                </option>
                                                                <option v-else :value="option">
                                                                    {{ option }}
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <input
                                                            :type="formTable.columns[index].type.category == 'Numbers' ? 'number' : 'text'"
                                                            :min="formTable.columns[index].type.category == 'Numbers' && formTable.columns[index].unsigned == true ? '0' : ''"
                                                            v-model="formTable.columns[index].default" class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                            ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                            focus:ring-indigo-600 sm:text-sm sm:leading-6 w-32">
                                                    </td>
                                                    <td
                                                        class="whitespace-nowrap border-r px-1 py-1 text-center w-8 font-medium dark:border-neutral-500">
                                                        <PrimaryButton v-on="{ click: () => hapusKolom(index) }"
                                                            class="bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300 focus:bg-red-500">
                                                            <span class="ml-0.5 "> <i class="fas fa-lg fa-trash-alt"></i>
                                                            </span>
                                                        </PrimaryButton>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template #footercard>
                        <div class="flex mb-4 justify-center">
                            <PrimaryButton v-on="{ click: () => tambahKolom() }">
                                <span class="mr-2"> <i class="fas fa-plus "></i> </span>
                                Add column
                            </PrimaryButton>
                            <PrimaryButton class="ml-3" v-on="{ click: () => tambahKolom(1) }">
                                <span class="mr-2"> <i class="fas fa-plus "></i> </span>
                                Add Timestamp
                            </PrimaryButton>
                            <PrimaryButton class="ml-3" v-on="{ click: () => tambahKolom(2) }">
                                <span class="mr-2"> <i class="fas fa-plus "></i> </span>
                                Add Softdelete
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
        dataTypes: Object,
        tables: Object,
        action : String,
        formAction : String

    },
    components: {

    },
    watch: {

        tableName(newTableName) {
            this.formTable.name = newTableName;
            for (let i in this.formTable.indexes) {
                this.formTable.indexes[i].table = newTableName;
            }
        },

    },
    created() {
        if (this.action === 'update') {
            let master = [];
            this.tables.columns.forEach(element => {
                master.push(
                    {
                        dataType: this.dataTypes,
                        index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                    }
                );
            });
            this.master = master;
            this.tableName = this.tables.name;
        }
    },
    data() {
        return {

            v$: useVuelidate(),
            disallowedNames: ['select', 'insert', 'update', 'delete'],
            tableName: null,
            formTable: this.action === 'update' ?this.$inertia.form(this.tables) : this.$inertia.form({
                name: null,
                oldName : '',
                columns: [
                    {
                        name: 'id',
                        oldName : null,
                        type: {
                            name: "integer",
                            category: "Numbers",
                            default: {
                                type: "number",
                                step: "any"
                            }
                        },
                        length: null,
                        fixed: false,
                        unsigned: true,
                        autoincrement: true,
                        notnull: true,
                        default: null,
                        // index : 'PRIMARY'
                    },
                ],
                indexes: [
                    {
                        indexColumns: 0,
                        columns: ['id'],
                        type: 'PRIMARY',
                        name: 'primary',
                        table: null
                    },
                ],
                primaryKeyName: 'primary',
                foreignKeys: [],
                options: {
                    create_options: []
                }

            }),

            master: [
                {
                    dataType: this.dataTypes.types,
                    index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                }

            ],
        };
    },

    computed: {

    },

    validations() {
        return {
            tableName: {
                required,
                regex: helpers.regex(/^[a-zA-Z0-9_][a-zA-Z0-9_]*$/),

                isNotInDisallowedNames(value) {
                    return !this.disallowedNames.includes(value.toLowerCase());
                },
            },

            formTable: {
                columns: {
                    $each: helpers.forEach({
                        name: {
                            required,
                            regex: helpers.withMessage(
                                ({
                                    $pending,
                                    $invalid,
                                    $params,
                                    $model
                                }) => `karakter '${$model}' tidak diperbolehkan `, helpers.regex(/^[a-zA-Z0-9_][a-zA-Z0-9_]*$/)),


                        }
                    })
                },

            },
            isUniqueArray() {
                const names = this.formTable.columns.map(column => column.name);
                const uniqueNames = new Set(names);
                return names.length === uniqueNames.size;
            }
            // isUniqueArray() {
            //     // Mengimplementasikan logika untuk memeriksa unik nama di dalam formTable.columns
            //     const names = this.formTable.columns.map(column => column.name);
            //     const uniqueNames = new Set(names);
            //     // let findDuplicates = arr => arr.reduce((acc, item, index) => {
            //     //     if (arr.indexOf(item) !== index && !acc.includes(item)) {
            //     //         acc.push(item);
            //     //     }
            //     //     return acc;
            //     // }, []);
            //     // const duplicates = findDuplicates(names);
            //     // const result = duplicates.map(value => {
            //     //     return {
            //     //         val: value,
            //     //         index: names.reduce((acc, item, index) => {
            //     //             if (item === value) {
            //     //                 this.formTable.errors['kolom.'+index+'.name']='Duplicate Entri'
            //     //                 acc.push(index);
            //     //             }
            //     //             return acc;
            //     //         }, [])
            //     //     };
            //     // });
            //     // console.log([...new Set(findDuplicates(names))]);   
            //     return names.length === uniqueNames.size;
            // }
        }
    },


    methods: {

        async cekNamaTable(value) {
            const response = await axios.get(route('database.show', value));
            return response.data;
        },
        kembali(){
            Inertia.get(route('database.index'), {}, { replace: true })
        },
        //-------kolom table-------//
        inputNamaKolom: function (e, index) {
            const i = this.formTable.indexes.findIndex(item => item.indexColumns === index);
            if (i !== -1) {
                this.formTable.indexes[i].columns = [e];
            }
        },


        cekNamaSama: function (e, kecualiIndex) {
            //cari value nama 
            const cari = this.formTable.columns.find((element, index) => {
                if (index === kecualiIndex) {
                    return false;
                }
                return element.name === e;
            });
            if (cari) {
                this.formTable.errors['kolom.' + kecualiIndex + '.name'] = 'Duplicate Entri'
            } else {
                delete this.formTable.errors['kolom.' + kecualiIndex + '.name'];
            }
        },

        pilihType: function (e, index) {
            const i = e.target.selectedIndex;
            const option = e.target.options[i];
            const optgroup = option.parentElement;
            const countryGroup = optgroup.getAttribute('label');
            const master = this.master[index]['dataType'][countryGroup]
            this.formTable.columns[index].type = master.find(item => item.name === option.value);
            if (countryGroup !== 'Numbers') {
                this.formTable.columns[index].unsigned = false;
                this.formTable.columns[index].autoincrement = false;

            } else {
                this.formTable.columns[index].default = 0;
                this.formTable.columns[index].unsigned = true;
                // this.formTable.columns[index].autoincrement = true;
            }

        },

        pilihIndex: function (e, index) {

            const i = e.target.selectedIndex;
            const option = e.target.options[i];
            
            const kolom = this.formTable.columns[index].name;
                this.formTable.indexes.forEach((element, index) => {
                    if (element.columns.includes(kolom)) {
                        this.formTable.indexes.splice(index, 1);
                    }
                });

            if (option.value !== '') {
                const tambahFieldIndex = {
                    indexColumns: index,
                    columns: [this.formTable.columns[index].name],
                    type: option.value,
                    name: option.value.toLowerCase(),
                    table: this.formTable.name
                };
                //cari dan cek apakah ada primarykey
                if (option.value === 'PRIMARY') {
                    const cariPrimary = this.formTable.indexes.find((element, index) => {
                        return element.type === 'PRIMARY';
                    });

                    if(cariPrimary){
                        toast.add({
                            message: '`PRIMARY KEY` Sudah Ada',
                            category : 'warning'
                        })

                        e.target.selectedIndex = 0 //pilih index value ''
                    
                    }else{
                        this.formTable.indexes.push(tambahFieldIndex);
                    }
                
                }else{
                    this.formTable.indexes.push(tambahFieldIndex);
                }
                // this.formTable.columns[index].index = option.value;
            } else {
                //jika pilih index  ==  '' maka cari di array indexes dengan indexColumns == index 
                //jika ada hapus.
                // if (this.action === 'update') {
                //     //karna indexColumns tidak ada loop sadolahe
                //     const kolom = this.formTable.columns[index].name;
                //     this.formTable.indexes.forEach((element, index) => {
                //         if (element.columns.includes(kolom)) {
                //             this.formTable.indexes.splice(index, 1);
                //         }
                //     });
                
                // }
                const i = this.formTable.indexes.findIndex(item => item.indexColumns === index);
                if (i !== -1) {
                    this.formTable.indexes.splice(i, 1);
                    // this.formTable.columns[index].index = null;
                }
            }
        },

        unsignedKlik: function (data, e, index) {

            if (e.target.checked && data.type.category === 'Numbers') {
                this.formTable.columns[index].default = 0
            }
        },

        tambahKolom: function (jenis) {
            if (jenis === 1) {
                //jika timestamp
                const cariCreatedAt = this.formTable.columns.find((element, index) => {
                    return element.name === 'created_at';
                });
                if (!cariCreatedAt) {
                    const tambahField = {
                        name: 'created_at',
                        oldName : null,
                        type: {
                            name: "timestamp",
                            category: "Date and Time"
                        },
                        length: null,
                        fixed: false,
                        unsigned: false,
                        autoincrement: false,
                        notnull: false,
                        default: null,
                    };
                    const fieldMaster = {
                        dataType: this.dataTypes.types,
                        index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                    };
                    this.formTable.columns.push(tambahField);
                    this.master.push(fieldMaster);
                }

                const cariUpdatedAt = this.formTable.columns.find((element, index) => {
                    return element.name === 'updated_at';
                });
                if (!cariUpdatedAt) {
                    const tambahFieldUpdated = {
                        name: 'updated_at',
                        oldName : null,
                        type: {
                            name: "timestamp",
                            category: "Date and Time"
                        },
                        length: null,
                        fixed: false,
                        unsigned: false,
                        autoincrement: false,
                        notnull: false,
                        default: null,
                    };
                    const fieldMasterupdated = {
                        dataType: this.dataTypes.types,
                        index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                    };
                    this.formTable.columns.push(tambahFieldUpdated);
                    this.master.push(fieldMasterupdated);
                }

            } else if (jenis === 2) {
                //jika softdelete
                const cariDeletedAt = this.formTable.columns.find((element, index) => {
                    return element.name === 'deleted_at';
                });
                if (!cariDeletedAt) {
                    const tambahField = {
                        name: 'deleted_at',
                        oldName : null,
                        type: {
                            name: "timestamp",
                            category: "Date and Time"
                        },
                        length: null,
                        fixed: false,
                        unsigned: false,
                        autoincrement: false,
                        notnull: false,
                        default: null,
                    };
                    const fieldMaster = {
                        dataType: this.dataTypes.types,
                        index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                    };
                    this.formTable.columns.push(tambahField);
                    this.master.push(fieldMaster);
                }
            } else {
                const tambahField = {
                    name: null,
                    oldName : null,
                    type: {
                        name: "integer",
                        category: "Numbers",
                        default: {
                            type: "number",
                            step: "any"
                        }
                    },
                    length: null,
                    fixed: false,
                    unsigned: false,
                    autoincrement: false,
                    notnull: false,
                    default: null,
                    // index : null
                };
                const fieldMaster = {
                    dataType: this.action === 'update' ? this.dataTypes : this.dataTypes.types,
                    index: ['', 'INDEX', 'UNIQUE', 'PRIMARY'],
                };
                this.master.push(fieldMaster);
                this.formTable.columns.push(tambahField);

            }

        },

        hapusKolom: function (index) {
            //hapus
            this.master.splice(index, 1);
            this.formTable.columns.splice(index, 1);
            delete this.formTable.errors['kolom.' + index + '.name'];
            //hapus indexes jika ada
            const i = this.formTable.indexes.findIndex(item => item.indexColumns === index);
            if (i !== -1) {
                this.formTable.indexes.splice(i, 1);

            }
        },

        //-------batas kolom table-------//

        simpan() {
        
            
            this.v$.$validate();

            if (!this.v$.$error) {
                const cekTable = this.cekNamaTable(this.tableName);
                cekTable.then(result => {
                    if (Object.keys(result).length > 0 && this.action !== 'update') {
                        toast.add({
                            message: 'Table Sudah Ada Di Database',
                            category : 'warning'
                        })
                    
                    }else if(this.formTable.columns.length == 0){
                        toast.add({
                            message: 'Silahkan Tambah Kolom',
                            category : 'warning'
                        })
                    }
                    else {
                        if (this.action === 'update') {
                            this.formTable.put(route('database.update'), {
                                preserveScroll: true,
                                preserveState: true,
                                onSuccess: () => {
                                    this.master.splice(1); //hapus semua dari index 1
                                    this.formTable.reset();
                                },
                                onError: (errors) => {
                                    console.log(errors);
                                }
                            })
                        }else{
                            this.formTable.post(route('database.store'), {
                                preserveScroll: true,
                                preserveState: true,
                                onSuccess: () => {
                                    this.master.splice(1); //hapus semua dari index 1
                                    this.formTable.reset();
                                },
                                onError: (errors) => {
                                    console.log(errors);
                                }
                            })
                        }
                    }
                }).catch(error => {
                    toast.add({
                            message: error,
                            category : 'warning'
                        })
                    console.error('Terjadi kesalahan:', error);
                });
                

            } else {
                console.error('error, ','saat validasi');
            }


        },
    },
};
</script>