<template>
    <span>
      <i :class="iconClasses"></i>
    </span>
  </template>
  
  <script>
  export default {
    props: {
      icon: {
        type: Array,
        required: true,
      },
    },
    computed: {
      iconClasses() {
        // Assuming you're using Font Awesome's syntax for class names
        return ['fas', ...this.icon].join(' ');
      },
    },
  };
  </script>
  
  <style scoped>
  /* You can add custom styling for your icon here if needed */
  </style>
  