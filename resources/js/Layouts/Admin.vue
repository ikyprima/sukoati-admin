<template>
  <div>
    <sidebar />
    
    <div class="relative md:ml-64 bg-blueGray-100">

      <admin-navbar #namaheader>
        <slot name="textnavbar" />
      </admin-navbar> 

      <slot name="header" />
    
      <div class="px-4 md:px-10 mx-auto w-full -m-32 min-h-full ">
        <main>
            <slot />
        </main>
            <footer-admin />
      </div>
      
      
    </div>
  </div>
</template>
<script>
import AdminNavbar from "@/Components/Navbars/AdminNavbar.vue";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";
import FooterAdmin from "@/Components/Footers/FooterAdmin.vue";

export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    FooterAdmin,
  },
};
</script>
