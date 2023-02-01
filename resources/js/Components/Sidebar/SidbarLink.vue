<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active' , 'icon', 'child' , 'collapsed','isChild','depth']);

const classes = computed(() => props.active
    ? 'text-xs uppercase py-3 font-bold block text-emerald-500 hover:text-emerald-600 '
    : 'text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500'
);

</script>

<template>


    <a v-if="props.child.length > 0 " :class="[classes,'translate-x-['+props.depth+'rem]']"  class="cursor-pointer" :icon="icon" @click.prevent="onClickButton">
        <i :class="[props.active ? props.icon +'opacity-75' : props.icon+'text-blueGray-300'] ">
        </i>
        <span class="pr-[5px]" v-if="props.child.length > 0">
                    <template v-if="props.collapsed"><i class="fas fa-chevron-down"> </i></template>
                    <template v-else ><i class="fas fa-chevron-right"></i></template>
        </span>
        <slot />
        
    
    </a>
    <Link v-else="child" :href="href" :class="[classes,'translate-x-['+props.depth+'rem]']" :icon="icon">
        <i :class="[props.active ? props.icon +'opacity-75' : props.icon+'text-blueGray-300']" >
        </i>
    
        <slot />
    
    </Link>

</template>
<script>
    export default {
   methods: {
     onClickButton (event) {
         this.$emit('clicked')
     }
   }
}

</script>