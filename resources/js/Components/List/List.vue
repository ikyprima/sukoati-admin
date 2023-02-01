<template>

    <div class="flex flex-row ">
        <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-2" draggable="true"
            @dragstart="startDrag($event, item)" @drop="onDrop($event, item)" @dragover.prevent @dragenter.prevent>
            <div class="flex-1 pl-1">
                <div class="font-medium text-blueGray-700" :class="[`translate-x-[${this.depth}rem]`]">
                    <i
                        :class="[item.children.length > 0 ? 'fas fa-folder-open opacity-75' : ' fas fa-file text-blueGray-300']">
                    </i>

                    {{ item.title }}



                </div>

                <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{ title }}</div> -->
            </div>
            <div class=" inline-flex rounded-md shadow-sm border border-black" role="group">
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
            </div>
        </div>
    </div>
    <template v-if="item.children">
        <List v-for="menu in item.children" :item="menu" :depth="kedalaman + 1" />
    </template>


</template>

<script>


export default {


    props: ['item', 'depth'],

    data() {
        return {
            formChild: this.$inertia.form({
                id_parent: null
            }),
            kedalaman: this.depth,

        };

    },
    methods: {
        startDrag(evt, item) {
            evt.dataTransfer.dropEffect = 'move'
            evt.dataTransfer.effectAllowed = 'move'

            evt.dataTransfer.setData('itemID', item.id)
        },
        onDrop(evt, list) {
            //    console.log('drop');
            const itemID = evt.dataTransfer.getData('itemID')
            console.log(parseInt(itemID));
            this.formChild.id_parent = list.id
            console.log(list.id);
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
