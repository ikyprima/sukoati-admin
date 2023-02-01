<template>

    <li class="items-center">

        <SidebarLink :href="route().has(item.name_route)?route(item.name_route):'' " :child="item.children" @clicked="toggleCollapsed" :collapsed="collapsed"
            :depth="kedalaman" :isChild="isChild" :active="route().current(item.name_route)" :icon="'fas fa-tv mr-2 text-sm'">
            {{ item.title }}
        </SidebarLink>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none" v-if="item.children" v-show="collapsed">
            <Menu v-for="item in item.children" :item="item" :items="item.children" :key="item.id"
                :depth="kedalaman + 1" :isChild="item.children">
            </Menu>
        </ul>


        <!-- <Menu v-if="item.children" :item="item.children" v-show="collapsed" />  -->
    </li>

</template>

<script>
import SidebarLink from "@/Components/Sidebar/SidbarLink.vue";

export default {


    props: ['item', 'isChild', 'depth'],
    data() {
        return {
            collapsed: false,
            kedalaman: this.depth,
        
        };
    },
    methods: {
        toggleCollapsed() {
            this.collapsed = !this.collapsed;
        },
    },
    components: {
        SidebarLink,
    }
};
</script>
  