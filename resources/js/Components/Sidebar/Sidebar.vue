<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Brand -->

      <Link :href="route('dashboard')"
        class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0">
     Sukoati Admin
      </Link>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <notification-dropdown />
        </li>
        <li class="inline-block relative">
          <user-dropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow">
        <!-- Collapse header -->
        <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
          <div class="flex flex-wrap">
            <div class="w-6/12">


              <Link :href="route('dashboard')"
                class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0">
              Sukoati Admin
              </Link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input type="text" placeholder="Search"
              class="border-0 px-3 py-2 h-12 border border-solid border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
          </div>
        </form>
        <!-- Divider -->
        <div v-for="(data, index) in $page.props.menu">


          <hr class="my-4 md:min-w-full" />
          <!-- Heading -->
          <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
            {{ data.header }}
          </h6>
          <!-- Navigation -->
          <!-- <ul class="md:flex-col md:min-w-full flex flex-col list-none">
            <li class="items-center">

              <SidebarLink v-for="( data, index ) in data.menu" :key="data.id" :href="route().has(data.name_route)?route(data.name_route):''"
                :active="route().current(data.name_route)" :icon="'fas fa-tv mr-2 text-sm'">
                {{ data.title }}

              </SidebarLink>

            </li>

          </ul> -->
          <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <MenuItem v-for="item in data.menu" :item="item" :items="item.children" :key="item.id" :isChild="false" :depth="0">
          </MenuItem> 
        </ul>
        </div>
       
        

      </div>
    </div>
  </nav>
</template>


<script>
import NotificationDropdown from "@/Components/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import SidebarLink from "@/Components/Sidebar/SidbarLink.vue";
import MenuItem from "@/Components/Sidebar/Menu.vue";


import { Link } from '@inertiajs/inertia-vue3';

export default {

  data() {
    return {
      collapseShow: "hidden",
      menuItems: [
        {
          id: 1,
          name: 'Home',
          url: 'menu.index',
          children: [
            {
              id: 2, name: 'Submenu 1', url: '/submenu1',
              children: [
                { id: 3, name: 'Submenu dah 1.1', url: 'dashboard' },
                { id: 4, name: 'Submenu 1.2', url: '/submenu2' },
              ],
            },
            { id: 5, name: 'Submenu 2', url: '/submenu2' },
          ],
        },
        {
          id: 6,
          name: 'About',
          url: '/about',
          children: [
            { id: 7, name: 'Submenu 1', url: '/submenu about' },
            { id: 8, name: 'Submenu 2', url: '/submenu2 about' },
          ],
        },
      ],
      list: [
        {
          id: 1,
          url: 'dashboard',
          name: 'Dashboard',
          active: route().current('dashboard'),
          icon: 'fas fa-tv mr-2 text-sm'
        }


      ],
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
  },
  components: {
    NotificationDropdown,
    UserDropdown,
    Link,
    SidebarLink,
    MenuItem
  },
};
</script>
