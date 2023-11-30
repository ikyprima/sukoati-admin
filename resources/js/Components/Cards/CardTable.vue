<template>
  <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded min-h-[50vh]"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-2 max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-lg" :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
            {{ namaTitle }}
          </h3>
        </div>
        <div class=" relative md:w-full px-4 md:max-w-full flex-grow flex-1 text-right">
          <slot name="button" />
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
            <th v-for="(data, index) in header"
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueblue-300 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
                'text-' + data.align
              ]">
              {{ data.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-for="( data, index ) in list">
            <tr class="border-b border-gray-200  ">
              <template v-for="(datax, index) in header">
                <template v-if="datax.type == 'gambar'">
                  <th
                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center">
                    <img :src="datax.baseurl + data[datax.fieldfoto]" @error="$event.target.src = image"
                      class="h-12 w-12 bg-white rounded-full border" alt="...">
                    <span class="ml-3 font-bold text-blueGray-600"> {{ data[datax.fieldtext] ? data[datax.fieldtext] : '-'
                    }} </span>
                  </th>
                </template>
                <template v-else>
                  <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2 "
                    :class="['text-' + datax.align, 'w-' + datax.size]">
                    <div v-if="datax.type == 'string'">
                      {{ data[datax.field] ? data[datax.field] : '-' }}
                    </div>

                    <div v-else-if="datax.type == 'button'">
                      <div class=" inline-flex rounded-md shadow-sm " role="group">
                        <button type="button" v-on:click="clickedit(data)"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded-l-lg
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-blue-700 dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                          <i class="fas fa-lg fa-pencil-alt"></i>
                        </button>

                        <button type="button" v-on:click="clickhapus(data)"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-500 bg-transparent border border-red-500 rounded-r-md 
                      shadow transition ease-in-out duration-150  
                      hover:bg-red-500 hover:text-white
                      focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white 
                      dark:border-red-700 dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                          <i class="fas fa-lg fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>


                  </td>
                </template>


              </template>

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
import image from "@/img/no-image.png";
export default {


  data() {

    return {
      image: image,
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
    list: {},
    header: Array,
    namaTitle: String

  },
  methods: {
    onClickChild(value) {
      this.status = value

    },
    clickedit(value) {
      this.$emit('clickedit', value);

    },
    clickhapus(value) {
      this.$emit('clickhapus', value);

    }


  }
};
</script>
