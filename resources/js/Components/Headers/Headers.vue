<template>
  <!-- Header -->
  <div class="relative bg-emerald-600 md:pt-10 pb-28 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <!-- Card stats -->
        <div class="flex flex-wrap">

          <slot name="kontenheader"/>

        </div>
      </div>
    </div>
  </div>
</template>

<script>


export default {
  components: {
    
  },
};
</script>
