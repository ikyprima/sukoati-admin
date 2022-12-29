<template>
  <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
    <div class="rounded-t mb-0 px-4 py-6 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-lg" :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
            <!-- Lists {{ $page.props.flash.appName }} -->
          
            Menu 
            
          </h3>
        </div>
        <div
          class="relative w-full px-4 max-w-full flex-grow flex-1 text-right"
        >
        <slot name="button" />
         
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">

      <div class="flex flex-col container mt-2  mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow">
        <Accordion title="consectetur adipiscing elit">
                    Lorem ipsum dolor sit amet, consectetur adipiscin  </Accordion>
                    <Accordion title="consectetur adipiscing elit">
                    Lorem ipsum dolor sit amet, consectetur adipiscin  </Accordion>
                    <Accordion title="consectetur adipiscing elit">
                    Lorem ipsum dolor sit amet, consectetur adipiscin  </Accordion>
      </div>

    </div>
  </div>
</template>
<script>
import TableDropdown from "@/Components/Dropdowns/TableDropdown.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Accordion from "@/Components/Cards/CardAccordion.vue";
import { Inertia } from '@inertiajs/inertia'
export default {


  data() {

    return {
      isOpen: false,
     
    };
  },
  components: {
    TableDropdown,
    PrimaryButton,
    Accordion
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
    onClickChild(value) {
    
    }
    , 
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
