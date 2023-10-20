<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import ButtonCard from "@/Components/Buttons/ButtonCard.vue";
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AdminLayout>
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <Link :href="route().has('master.kategori')?route('master.kategori'):'' " >
                
                        <ButtonCard  statSubtitle="Master" statTitle="Kategori" cursor="cursor-pointer"  ></ButtonCard>
                        
                    </Link>
                    
                    </div>
                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <Link :href="route().has('master.satuan')?route('master.satuan'):'' " >
                
                        <ButtonCard  statSubtitle="Master" statTitle="Satuan" cursor="cursor-pointer"  ></ButtonCard>
                        
                    </Link>
                    
                    </div>
                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <Link :href="route().has('master.barang')?route('master.barang'):'' " >
                
                        <ButtonCard  statSubtitle="Master" statTitle="Barang" cursor="cursor-pointer"  ></ButtonCard>
                        
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
    methods: {
        tes () {
           console.log('tes');
          },
    },

    
};
</script>