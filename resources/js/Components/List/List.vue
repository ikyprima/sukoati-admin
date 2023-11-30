<template>
    <div class="flex flex-row ">
        <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-2" draggable="true"
            @dragstart="startDrag($event, item)" @drop="onDrop($event, item)" @dragover.prevent  
             @dragenter="highlight = true"
             @dragleave="highlight = false"  
              :class="{'bg-red-500': highlight, 'bg-white': !highlight}" 
             >
            <div class="flex-1 pl-1">
                <div class="font-medium text-blueGray-700 w-64 uppercase" :class="[`translate-x-[${this.depth}rem]`]">
                    <i
                        :class="[item.children.length > 0 ? 'fas fa-folder-open opacity-75' : ' fas fa-file text-blueGray-300']">
                    </i>
                    {{ item.title }}
                </div>
                <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{ title }}</div> -->
            </div>
            
            <div class=" inline-flex rounded-md shadow-sm " role="group">
            <button type="button" 
            v-on:click="handleClickadd(item)"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500 rounded-l-lg
                shadow transition ease-in-out duration-150  
                hover:bg-blue-500 hover:text-white 
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]">
                <i class="fas fa-lg fa-plus "></i>
            </button>
            <button type="button" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500  
                shadow transition ease-in-out duration-150  
                hover:bg-orange-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-orange-500 focus:text-white focus:z-[1]">
                <i class="fas fa-lg fa-pencil-alt"></i>
            </button>
            <button type="button" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500  
                shadow transition ease-in-out duration-150  
                hover:bg-emerald-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]">
                <i class="fas fa-lg fa-file-alt"></i>
            </button>
            <button type="button" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border border-blue-500 rounded-r-md 
                shadow transition ease-in-out duration-150  
                hover:bg-red-500 hover:text-white
                focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-red-500 focus:text-white ">
                <i class="fas fa-lg fa-trash-alt"></i>
            </button>
            </div>
            
            <!-- <div class=" inline-flex rounded-md shadow-sm border border-black" role="group">
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                    <i class="fas fa-lg fa-plus"></i>

                </button>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                    <i class="fas fa-lg fa-pencil-alt"></i>
                </button>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                    <i class="fas fa-lg fa-file-alt"></i>
                </button>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-r-md hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                    <i class="fas fa-lg fa-trash-alt"></i>
                </button>
            </div> -->
        </div>
    </div>
    <template v-if="item.children">
        <List v-for="menu in item.children" :item="menu" :depth="kedalaman + 1"  @clickadd="clickadd" />
    </template>
</template>
<script>


export default {

    emits: ['clickadd'],
    props: ['item', 'depth'],

    data() {
        return {
            formChild: this.$inertia.form({
                id_parent: null,
                is_parent: null,
                id_menu : null 
            }),
        
            kedalaman: this.depth,
            highlight: false

        };

    },
    
    methods: {
        clickadd(value){
            this.$emit('clickadd', value);
        },
        handleClickadd(value) {
            this.$emit('clickadd', value);
        },
        startDrag(evt, item) {
            evt.dataTransfer.dropEffect = 'move'
            evt.dataTransfer.effectAllowed = 'move'

            evt.dataTransfer.setData('itemID', item.id);
            evt.dataTransfer.setData('isParent', item.is_parent);
        
        
        },
        onDrop(evt, list) {
            this.highlight = false;
            const itemID = evt.dataTransfer.getData('itemID');
            this.formChild.id_parent = list.id;
            this.formChild.id_menu = list.id_menu;
            this.formChild.is_parent = Number(evt.dataTransfer.getData('isParent'));
        
            if (parseInt(itemID) !== list.id) {

                this.formChild.put(route('menu.update.child', itemID), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {

                    }
                })
            }


        },

    },
    components: {

    },
    computed: {

    },
};
</script>
