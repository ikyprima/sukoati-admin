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
        <title>Add Builder Form</title>
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
                                            class="mt-1 block w-full" placeholder="controller name" />
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
                                            class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                            <thead class="border-b bg-gray-100 font-medium dark:border-neutral-500">
                                                <tr>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Field
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Input Type
                                                    </th>
                                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                                        Display Name
                                                    </th>
                                                    <th scope="col"
                                                        class="border-r px-4 py-4 dark:border-neutral-500 text-left">
                                                        Option Details
                                                    </th>

                                                </tr>
                                            </thead>
                                            <transition-group>
                                                <draggable :list="formBuilder.fieldOptions" :animation="300" item-key="name"
                                                    :key="item => item.id" tag="tbody" 
                                                    >
                                                    <template v-slot:item="{ element, index }">
                                                        <tr class=" border-b border-gray-200 " >
                                                            <td
                                                                class="whitespace-nowrap border-r px-1 py-1  w-1/5 text-left font-medium dark:border-neutral-500">
                                                                <ul class="pl-2 list-none">
                                                                    <li class="pb-2"><b class="italic text-lg underline ">{{
                                                                        element.field }}</b> </li>
                                                                    <li><b>Type</b> : {{ element.type }}</li>
                                                                    <li><b>Key</b> : {{ element.key }}</li>
                                                                    <li><b>Required</b> : {{ element.required }}</li>
                                                                </ul>

                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap border-r px-2 py-2 align-top w-8 font-medium dark:border-neutral-500">
                                                                <select class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                                        ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                                        focus:ring-indigo-600 sm:text-sm sm:leading-6 w-28" v-model="formBuilder.fieldOptions[index].inputType"
                                                                        :name="'inputType'+index">
                                                                        <template v-for="option in masterInputType">
                                                                            <option :value="option">
                                                                                {{ option }}
                                                                            </option>
                                                                        </template>
                                                                    </select>
                                                            </td>
                                                            <td
                                                                class="whitespace-nowrap border-r px-2 py-2 align-top w-8 font-medium dark:border-neutral-500">
                                                                <input type="text" class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset
                                                                ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset
                                                                focus:ring-indigo-600 sm:text-sm sm:leading-6 w-36" v-model="formBuilder.fieldOptions[index].display_name"
                                                                :name="'displayName'+index">
                                                            </td>
                                                            <td class="px-4 text-left py-4 ">
                                                        
                                                                    <vue-jsoneditor
                                                                        v-model="formBuilder.fieldOptions[index].detail"
                                                                        :mainMenuBar="false"
                                                                        :mode="'text'"
                                                                    />
                                                                
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
        action : String

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
            masterInputType:['Text','Number','Password','Date'],
            formBuilder: this.$inertia.form({
                table: this.data.table,
                slug: this.data.slug,
                display_name: this.data.display_name,
                display_name_plural: this.data.display_name_plural,
                model_name: null,
                controller: null,
                fieldOptions: Object.values(this.data.fieldOptions).map((item,index) => {
                    let order = index+1;
                    return {
                        order:order,
                        field: item.field,
                        type: item.type,
                        key: item.key,
                        required: item.notnull,
                        inputType: 'Text',
                        display_name: this.formatText(item.name),
                        detail: {}
                    }
                }),

            }),
    
        };
    },

    computed: {
    
    },

    validations() {

    },


    methods: {
        kembali() {
            Inertia.get(route('builder.index'), {}, { replace: true })
        },
        simpan() {
            if (this.action === 'update') {
                this.formBuilder.put(route('database.update'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.master.splice(1); //hapus semua dari index 1
                        this.formBuilder.reset();
                    },
                    onError: (errors) => {
                        console.log(errors);
                    }
                })
            }else{
                this.formBuilder.post(route('builder.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.master.splice(1); //hapus semua dari index 1
                        this.formBuilder.reset();
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


