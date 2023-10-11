<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';


import CardTable from "@/Components/Cards/CardTable.vue";
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

</script>

<template>
    <Head>
        <title>Manajemen Menu</title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen database
        </template>

        <template #header>
            <header-stats>

                <template #kontenheader>

                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card-table :list=tables :header=setting namaTitle='LIST TABLE'> 
                    <template #button>
                        <div class="hidden md:block">
                            <ButtonTambah  @click="tambah" >Tambah</ButtonTambah>
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
            </div>

        </div>


    </AdminLayout>



</template>

<script>

export default {

    props: {
        dataTypes: Object,
        tables : Object
    },
    components: {
       
    },
    data() {
        return {
            
            setting: [ //seting header table
                {

                    title: 'Nama Table',
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
        };
    },
    methods: {
        tambah(){
            Inertia.get(route('database.create'),{  }, { replace: true })
        }
    },


};
</script>
