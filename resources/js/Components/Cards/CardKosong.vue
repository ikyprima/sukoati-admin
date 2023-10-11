<template>
  <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
    <div class="rounded-t mb-0 px-4 py-6 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-lg" :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
            <!-- Lists {{ $page.props.flash.appName }} -->

            LIST MENU

          </h3>
        </div>
        <div class=" relative md:w-full px-4 md:max-w-full flex-grow flex-1 text-right">


          <slot name="button" />

        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">

      <div
        class="flex flex-col container mt-2 mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow">

        <Accordion v-for='i in list' :id="i.id" :title="i.name" :posisi = "i.posisi" @clickaddHeaderMenu= "mclickaddHeaderMenu"
          @clickEditHeaderMenu="mclickEditHeaderMenu">
          <div
            class="flex flex-col container  ml-8 w-full items-center justify-center bg-white  dark:bg-gray-800  shadow">
            <div class="flex flex-col divide-y w-full " >
              
                <List v-for="menu in i.menu_item"  :item="menu" @clickadd="clickadds" :depth="0" />
              
            </div>
          </div>
        </Accordion>

      </div>

    </div>
  </div>
</template>
<script>
import TableDropdown from "@/Components/Dropdowns/TableDropdown.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Accordion from "@/Components/Cards/CardAccordion.vue";
import List from "@/Components/List/List.vue";
import draggable from 'vuedraggable'

import { Inertia } from '@inertiajs/inertia'
export default {
 
  emits: ['clickadd','clickaddHeaderMenu','clickEditHeaderMenu'],
  data() {

    return {
      isOpen: false,
    

    };
  },
  components: {
    TableDropdown,
    PrimaryButton,
    Accordion, List,
    draggable
  },
  props: {
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
    list: {},
    header: Array

  },
  methods: {
    
    mclickaddHeaderMenu(value){
      
      this.$emit('clickaddHeaderMenu', value);
    },
    mclickEditHeaderMenu(value){
      const index = this.list.findIndex(item => item.id === value.id);
      this.$emit('clickEditHeaderMenu', this.list[index]);
    },
    clickadds(value){
      this.$emit('clickadd', value);
    },
    tes() {
      Inertia.post('/admin/test', {
        headers: {
          'Custom-Header': 'value',
        },
        onSuccess: () => {
          console.log('sukses');
        },
        onFinish: visit => {
          console.log('finis');
        },
      })
      // Inertia.get('/tes', { search: 'John' }, { replace: true })
      // console.log('tes');


    },
  }
};
</script>
