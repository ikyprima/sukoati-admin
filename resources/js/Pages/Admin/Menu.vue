<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/Cards/CardTable.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import CardStats from "@/Components/Cards/CardStats.vue";
import { Head } from '@inertiajs/inertia-vue3';
import Accordion from "@/Components/Cards/CardAccordion.vue";
import Card from "@/Components/Cards/CardKosong.vue";
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

Inertia.reload({ only: ['admin/menu'] });
</script>

<template>

    <Head title="Role" />

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

                <card :list=listMenu.data :header=header>
                    <template #button>
                        <button class="bg-indigo-500 text-white active:bg-indigo-600 font-bold uppercase text-sm px-6 py-3 rounded-full shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
  <i class="fas fa-plus"></i> Tambah
</button>
                    </template>
                </card>



            </div>


        </div>
    </AdminLayout>
</template>

<script>

export default {

    props: {
        listMenu: Object,

    },
    data() {

        return {
            header: [
                {
                    id: 1,
                    nama: 'NIP'
                },
                {
                    id: 2,
                    nama: "NAMA"
                },
                {
                    id: 3,
                    nama: "JENIS"
                },
                {
                    id: 4,
                    nama: "JABATAN"
                }
            ],

            list: [
                {
                    id: 1,
                    url: 'dashboard',
                    name: 'Dashboard',
                    active: route().current('dashboard'),
                    icon: 'fas fa-tv mr-2 text-sm'
                },
                {
                    id: 2,
                    url: 'profile.edit',
                    name: 'Profile',
                    active: route().current('profile.edit'),
                    icon: 'fas fa-tv mr-2 text-sm'
                },
                {
                    id: 3,
                    url: 'profile.edit',
                    name: 'Profile',
                    active: route().current('profile.edit'),
                    icon: 'fas fa-tv mr-2 text-sm'
                },

            ],
        };
    },


};
</script>
<style>

</style>