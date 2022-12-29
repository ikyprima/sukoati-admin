<template>
  <!-- Header -->
  <div class="relative bg-emerald-600 md:pt-32 pb-32 pt-12">
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
import CardStats from "@/Components/Cards/CardStats.vue";

export default {
  components: {
    CardStats,
  },
};
</script>
