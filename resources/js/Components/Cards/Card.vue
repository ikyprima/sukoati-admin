<template>
  <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-xl rounded-lg"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">

    <slot name="headercard" />
    <div class="block w-full ">

      <div class="flex flex-col container mt-2 mb-2 mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 "
        :class="[heigth, minheigth]">
        <slot />
      </div>
    </div>
    <slot name="footercard" />
  </div>
</template>
<script>

export default {

  emits: [],
  data() {

    return {


    };
  },
  components: {

  },
  props: {
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
    heigth: {
      default: "",
      type: String
    },
    minheigth: {
      default: "min-h-screen",
      type: String
    }



  },
  methods: {


  }
};
</script>
