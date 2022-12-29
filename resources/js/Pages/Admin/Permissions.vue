<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import CardTable from "@/Components/Cards/CardTable.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import CardStats from "@/Components/Cards/CardStats.vue";
import { Head } from '@inertiajs/inertia-vue3';

</script>

<template>

    <Head title="Role" />

    <AdminLayout>
        
        <template #header>
            <header-stats>
                <template #kontenheader>

                    <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                        <card-stats statSubtitle="PEGAWAI" statTitle="924" statArrow="down" statPercent="1.10"
                            statPercentColor="text-orange-500" statDescripiron="Since yesterday"
                            statIconName="fas fa-users" statIconColor="bg-pink-500" />
                    </div>

                </template>
            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <card-table :list=list />
            </div>

        </div>
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

    
};
</script>