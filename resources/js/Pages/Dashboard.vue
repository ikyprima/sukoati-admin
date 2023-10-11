<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import ButtonCard from "@/Components/Buttons/ButtonCard.vue";
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AdminLayout>
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <Link :href="route().has('pegawai.index')?route('pegawai.index'):'' " >
                
                        <ButtonCard  statSubtitle="Master" statTitle="Pegawai" cursor="cursor-pointer"  ></ButtonCard>
                        
                    </Link>
                    
                    </div>
                    

                </template>
            </header-stats>
        </template>
        
    </AdminLayout>
</template>

<script>

export default {
    data() {
        return {

            list: [

            ],
        };
    },
    methods: {
        tes () {
           console.log('tes');
          },
    },

    
};
</script>