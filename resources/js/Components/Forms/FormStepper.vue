<!-- FormStepper.vue -->
<template>
    <!-- component -->
<div class="p-5">
    <div class="mx-4 p-4">
        <div class="flex items-center">
            <template v-for="( data, index ) in header">
                <div class="flex items-center  relative"  
                    :class="[currentStep == index ? 'text-white' :currentStep > index || batasStep >= index ? 'text-teal-600 cursor-pointer' : 'text-gray-300']"
                    v-on="{ click: batasStep >= index ? () => directStep(index) : null }"
                >
                    <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 " 
                        :class="[currentStep == index ? 'bg-teal-600 border-teal-600' :currentStep > index  || batasStep >= index? 'border-teal-600 ' : 'border-gray-300']">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark ">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase "
                        :class="[currentStep >= index || batasStep >= index ? 'text-teal-600' : 'text-gray-500']">
                        {{ data.title }}
                    </div>
                
                </div>
            
                <div v-if="header.length > 0  && index < header.length - 1" 
                    class="flex-auto border-t-2 transition duration-500 ease-in-out " 
                    :class="[currentStep > index ||batasStep > index ? 'border-teal-600 animatecss  animatecss-fadeIn' : 'border-gray-300']"
                    >
                </div>
            </template>
        </div>
    </div>
    <div class="mt-8 p-4">
        <slot />
        
        <div class="flex p-2 mt-4">
            <button class="text-base hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer 
                    hover:bg-gray-200  
                    bg-gray-100 
                    text-gray-700 
                    border duration-200 ease-in-out 
                    border-gray-600 transition"
                    @click="prevStep" >Previous</button>
            <div class="flex-auto flex flex-row-reverse">
                <button class="text-base  ml-2  hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer 
                hover:bg-teal-600  
                bg-teal-600 
                text-teal-100 
                border duration-200 ease-in-out 
                border-teal-600 transition" 
                @click="nextStep" >Next</button>
                <!-- <button class="text-base hover:scale-110 focus:outline-none flex justify-center px-4 py-2 rounded font-bold cursor-pointer 
        hover:bg-teal-200  
        bg-teal-100 
        text-teal-700 
        border duration-200 ease-in-out 
        border-teal-600 transition">Skip</button> -->
            </div>
        </div>
    </div>
</div>
    
  </template>
  
  <script>
  export default {
    props:{
        header: Array,
        currentStep: Number,
        batasStep: Number
    },
    data() {
      return {
        
      };
    },
    methods: {
        
        nextStep() {
            this.$emit('nextStep');
        },
        prevStep() {
            this.$emit('prevStep');
        },
        directStep : function(value) {
            this.$emit('directStep', value);
        }
       
    }
  };
  </script>
  
  <style>
  /* Add your custom styles here if needed */
  </style>
  