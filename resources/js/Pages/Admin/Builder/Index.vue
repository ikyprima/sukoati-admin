<script setup>
import AdminLayout from '@/Layouts/Admin.vue';

import Card from "@/Components/Cards/Card.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
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
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import draggable from "vuedraggable";

</script>

<template>
    <Head>
        <title>Manajemen Menu </title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen database
        </template>
        <template #notif>
            <ToastList />
        </template>
        <template #header>
            <header-stats>

                <template #kontenheader>
                
                </template>
                

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">

            <div class="w-full mb-12 px-4">
                <card :minheigth="'min-h-0'">
                    <template #headercard>
                        <div class="pt-2 pb-2 mx-8 border-b border-solid border-blueGray-200 ">
                            <div class="flex flex-wrap items-center">
                                <div class="max-w-full flex-grow">
                                    <h3 class="font-semibold text-lg">
                                        Form Builder

                                    </h3>
                                
                                </div>
                                <div class="relative md:w-full md:max-w-full flex-grow flex-1 text-right">
                                    <div class="hidden md:block">
                                        <PrimaryButton
                                            class="bg-red-600 hover:bg-red-400 focus:bg-red-400 focus:ring-red-600">Kembali
                                        </PrimaryButton>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                        <template>
                        
                        </template>
                        
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Sport</th>
                                </tr>
                            </thead>
                          
                                <transition-group>
                                    <draggable 
                                       
                                        :list="list"
                                        :animation="200"
                                        @start="dragging = true"
                                        @end="dragging = false"
                                        item-key="name"
                                        :key="item => item.id"
                                        tag="tbody"
                                        >
                                        <template v-slot:item="{ element, index }">
                                            <tr class="border-b border-gray-200 hover:bg-gray-100 " :key="element.name">
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2 "
                                                    scope="row">{{ element.id }}</td>
                                                <td
                                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2">
                                                    {{ element.name }}</td>
                                                <td
                                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2">
                                                    {{ element.sport }}</td>
                                            </tr>
                                        </template>
                                    </draggable>
                                </transition-group>
                            
                        </table>
                    </template>
                    <div>

                    </div>

                </card>
            </div>

        </div>

    </AdminLayout>
</template>

<script>

export default {
    name: "table-example",
    display: "Table",
    order: 8,
   
    components: {
        draggable,
       
    },
    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        },
    },
   
    data() {

        return {
            schema: {
            name: { type: 'text', label: 'Name' },
            email: { type: 'text', label: 'Email' }
            },
            list: [{ id: 1, name: "Abby", sport: "basket" },
            { id: 2, name: "Brooke", sport: "foot" },
            { id: 3, name: "Courtenay", sport: "volley" },
            { id: 4, name: "David", sport: "rugby" }],
            dragging: false,
            enabled: true,
       
        };
    },
    created() {

    },
    methods: {
    
    },
};
</script>
<style scoped>
.flip-list-move {
    transition: transform 0.5s;
}

.no-move {
    transition: transform 0s;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}

.list-group {
  min-height: 20px;
}

.list-group-item {
  cursor: move;
}

.list-group-item i {
  cursor: pointer;
}
</style>

