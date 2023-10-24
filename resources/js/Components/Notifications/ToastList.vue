<script setup>
import ToastListItem from '@/Components/Notifications/ToastListItem.vue';
import toast from "@/Stores/toast.js";


function remove(index) {
    toast.remove(index);
}
</script>
<template>
    <TransitionGroup
    tag="div"
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="fixed top-4 right-10 z-50 space-y-4 w-full max-w-xs">
            <ToastListItem 
            v-for="(item, index) in toast.items" 
            :key="item.key" 
            :message="item.message"
            :duration="3000"
            :category ="item.category"
            @remove="remove(index)"
            />
        </TransitionGroup>
</template>