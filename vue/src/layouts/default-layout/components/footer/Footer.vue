<template>
  <!--begin::Footer-->
  <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div
      class="d-flex flex-column flex-md-row align-items-center justify-content-between"
      :class="{
        'container-fluid': footerWidthFluid,
        'container-xxl': !footerWidthFluid,
      }"
    >
      <!--begin::Copyright-->
      <div class="text-gray-900 order-2 order-md-1">
        <span class="text-muted fw-semibold me-1">2024&copy;</span>
        <a
          href="#"
          target="_blank"
          class="text-gray-800 text-hover-primary"
          >Katering</a
        >
      </div>
      <!--end::Copyright-->

      <!--begin::Menu-->
      <!-- <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
        <li class="menu-item">
          <a href="#" target="_blank" class="menu-link px-2">About</a>
        </li>

        <li class="menu-item">
          <a href="#" target="_blank" class="menu-link px-2">Support</a>
        </li>

        <li class="menu-item">
          <a href="#" target="_blank" class="menu-link px-2">Purchase</a>
        </li>
      </ul> -->
      <!--end::Menu-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Footer-->
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { footerWidthFluid } from "@/layouts/default-layout/config/helper";

export default defineComponent({
  name: "KTFooter",
  setup() {
    return {
      footerWidthFluid,
    };
  },
});
</script>
