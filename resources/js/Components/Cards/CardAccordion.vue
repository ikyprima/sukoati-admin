<template>
    <div class="flex flex-col container  mx-auto w-full items-center justify-center bg-white dark:bg-gray-800  shadow">
        <div class="flex flex-col divide-y w-full">
            <div class="flex flex-row hover:bg-gray-200">
                <div class="select-none cursor-pointer  flex flex-1 p-4" @drop="onDrops($event, id)"
                    @dragover.prevent v-on:click="show = !show">


                    <div class="flex flex-row justify-center">
                        <!-- <div class="text-gray-600 dark:text-gray-200 text-xs">6:00 AM</div> -->
                        <div class="w-10 text-right flex justify-end "
                            :class="[show ? 'rotate-90 -mt-3 p-1' : ' rotate-0 mt-1']">
                            <svg width="20" fill="currentColor" height="20" class="dark:text-gray-200 text-gray-500"
                                viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                                </path>
                            </svg>

                        </div>
                    </div>
                    <div class="flex-1 pl-1">
                        <div class="font-medium text-blueGray-700 uppercase">{{ title }} </div>
                        <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{ title }}</div> -->
                    </div>
                </div>
                <div class=" inline-flex rounded-md shadow-sm m-4" role="group">
                    <button type="button"  v-on:click="handleClickadd({'id' :id ,'title' : title ,'posisi' : posisi })"  class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500 rounded-l-lg
                shadow transition ease-in-out duration-150  
                hover:bg-blue-500 hover:text-white 
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                        <i class="fas fa-lg fa-plus "></i>
                    </button>
                    <button type="button"  v-on:click="handleClickEdit({'id' :id ,'title' : title ,'posisi' : posisi })"  
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500  
                shadow transition ease-in-out duration-150  
                hover:bg-orange-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-orange-500 focus:text-white focus:z-[1]">
                        <i class="fas fa-lg fa-pencil-alt"></i>
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500  
                shadow transition ease-in-out duration-150  
                hover:bg-emerald-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]">
                        <i class="fas fa-lg fa-file-alt"></i>
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500 rounded-r-md 
                shadow transition ease-in-out duration-150  
                hover:bg-red-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-red-500 focus:text-white 
                dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                        <i class="fas fa-lg fa-trash-alt"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>


    <Transition :duration="{ enter: 500, leave: 500 }">
        <!-- <div  @dragenter="highlight = true"
                @dragleave="highlight = false"   :class="{'bg-red-500': highlight, 'bg-white': !highlight}"  class="flex w-full px-4 py-4 bg-gray-50 border-gray-50 shadow m-3"  @drop="onDrops($event, 0)" v-if="show">
        
        </div> -->
        <div class="flex w-full px-4 py-4 bg-gray-50 border-gray-50 shadow m-0 " v-if="show">

            <slot></slot>
        </div>

    </Transition>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
export default {
    emits: ['clickaddHeaderMenu','clickEditHeaderMenu'],
    data: () => {
        return {

            isOpen: true,
            show: false,
            highlight: false,
            formMenu: {
                id_menu: null,

            },

        }
    },
    name: 'Accordion',
    props: {
        id: Number,
        title: String,
        posisi : String
    },
    methods: {
        
        handleClickadd(value) {
            this.$emit('clickaddHeaderMenu', value);
        },
        handleClickEdit(value) {
            this.$emit('clickEditHeaderMenu', value);
        },
        onDrops(evt, id) {

            const itemID = evt.dataTransfer.getData('itemID');
            this.formMenu.id_menu = id
            // console.log(id);
            // console.log(Number(itemID));
            Inertia.put(route('menu.update.parent', Number(itemID)), this.formMenu, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {

                },
                onFinish: visit => {

                },
            })

            // this.formMenu.put(route('menu.update.parent', itemID), {
            //         preserveScroll: true,
            //         preserveState: true,
            //         onSuccess: () => {

            //         }
            //     })
        }
    },
}
</script>
<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>