<template>
  <div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']"
  >
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
          <h3
            class="font-semibold text-lg"
            :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']"
          >
            Card Tables
          </h3>
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
          
            <th v-for="(data,index) in header"
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              {{ data.nama }}
            </th>
            
            <th
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            ></th>
          
          </tr>
        </thead>
        <tbody>
          <template v-for="( data, index ) in list">
            <tr>
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center"
            >
              
            {{ data.nip }}
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
            {{ data.name }}
            </td>
          
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              
            </td>
            
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-right"
            >
            <button class="text-emerald-500 bg-transparent border border-solid border-emerald-500 hover:bg-emerald-500 hover:text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
              <i class="fas fa-calendar-check"></i>
            </button>
            </td>
          </tr>
          <tr>
            <div class="flex flex-col container max-w-md mt-10 mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow">
  <ul class="flex flex-col divide-y w-full">
    <li class="flex flex-row">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=150&q=80" class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1">
          <div class="font-medium text-black">Jean </div>
          <div class="text-gray-600 dark:text-gray-200 text-sm">Developer</div>
        </div>
        <div class="flex flex-row justify-center">
          <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div>
          <button class="w-10 text-right flex justify-end">
            <svg width="20" fill="currentColor" height="20" class="hover:text-gray-800 dark:hover:text-white dark:text-gray-200 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
              <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z"></path>
            </svg>
          </button>
        </div>
      </div>
    </li>
    <li class="flex flex-row">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil" src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGF2YXRhcnxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=60" class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1">
          <div class="font-medium dark:text-white">Designer</div>
          <div class="text-gray-600 dark:text-gray-200 text-sm">Charlie Moi</div>
        </div>
        <div class="flex flex-row justify-center">
          <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div>
          <button class="w-10 text-right flex justify-end">
            <svg width="20" fill="currentColor" height="20" class="hover:text-gray-800 dark:hover:text-white dark:text-gray-200 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
              <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z"></path>
            </svg>
          </button>
        </div>
      </div>
    </li>
    <li class="flex flex-row">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=150&q=80" class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1">
          <div class="font-medium dark:text-white">CEO</div>
          <div class="text-gray-600 dark:text-gray-200 text-sm">Marine Jeanne</div>
        </div>
        <div class="flex flex-row justify-center">
          <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div>
          <button class="w-10 text-right flex justify-end">
            <svg width="20" fill="currentColor" height="20" class="hover:text-gray-800 dark:hover:text-white dark:text-gray-200 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
              <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z"></path>
            </svg>
          </button>
        </div>
      </div>
    </li>
    <li class="flex flex-row">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil" src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGF2YXRhcnxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=150&q=60" class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1">
          <div class="font-medium dark:text-white">CTO</div>
          <div class="text-gray-600 dark:text-gray-200 text-sm">Boby PArk</div>
        </div>
        <div class="flex flex-row justify-center">
          <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div>
          <button class="w-10 text-right flex justify-end">
            <svg width="20" fill="currentColor" height="20" class="hover:text-gray-800 dark:hover:text-white dark:text-gray-200 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
              <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z"></path>
            </svg>
          </button>
        </div>
      </div>
    </li>
  </ul>
</div>
            
          </tr>
</template>
            
     
       
          
        </tbody>

      </table>
      
    </div>
  </div>
</template>
<script>
import TableDropdown from "@/Components/Dropdowns/TableDropdown.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
export default {


  data() {

    return {
    
      status: false
    };
  },
  components: {
    TableDropdown,
    PrimaryButton
  },
  props: {
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
    list:{},
    header : Array
    
  },
  methods: {
      onClickChild (value) {
        this.status = value
        
      }
  }
};
</script>
