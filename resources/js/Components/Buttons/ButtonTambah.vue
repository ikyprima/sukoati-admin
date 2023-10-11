<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-emerald-800
        border border-transparent rounded-md font-semibold text-xs text-white mr-1 ml-1
        uppercase tracking-widest shadow transition ease-in-out duration-150 
        hover:bg-emerald-700 hover:shadow-lg 
        focus:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 
        active:bg-emerald-900">
        <slot />
    </button>
</template>
