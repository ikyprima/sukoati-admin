<template>

        
        <div class="flex flex-col container  mx-auto w-full items-center justify-center bg-white dark:bg-gray-800  shadow" >
            <div class="flex flex-col divide-y w-full">
                <div class="flex flex-row ">
                    <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4"
                        v-on:click="show = !show" >
                    
                        <div class="flex-1 pl-1">
                            <div class="font-medium text-blueGray-700">{{ title }} </div>
                            <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{ title }}</div> -->
                        </div>
                        <div class="flex flex-row justify-center">
                            <!-- <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div> -->
                            <div class="w-10 text-right flex justify-end">
                                <svg width="20" fill="currentColor" height="20"
                                    class="dark:text-gray-200 text-gray-500"
                                    viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <Transition>
        <div  @dragenter="highlight = true"
                @dragleave="highlight = false"   :class="{'bg-indigo-500': highlight, 'bg-gray-200': !highlight}"  class="flex w-full px-4 py-4 bg-gray-50 border-gray-400 shadow m-3"  @drop="onDrops($event, 0)" v-if="show">
        
            <slot></slot>
        </div>
        

</Transition>
    
    
   
</template>

<script>
export default {
    data: () => {
        return {
            isOpen: true,
            show: false,
            highlight: false
        }
    },
    name: 'Accordion',
    props: {
        title: String,
    },
    methods: {
        onDrops(evt, list) {
            console.log('frro');
        }
    },
}
</script>
<style>
/* .v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
} */
</style>