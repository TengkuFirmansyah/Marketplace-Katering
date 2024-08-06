<template>
  <div
    class="aside-user d-flex align-items-sm-center justify-content-center py-5"
  >
    <div class="symbol symbol-50px">
      <img :src="getAssetPath('media/avatars/blank.png?>')" alt="" />
    </div>

    <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
      <div class="d-flex">
        <div class="flex-grow-1 me-2">
          <a href="#" class="text-white text-hover-primary fs-6 fw-semibold">{{user.name}}</a>

          <span class="text-light fw-semibold d-block fs-8 mb-1">{{user.email}}</span>

          <div class="d-flex align-items-center text-warning fs-9">
            <span class="bullet bullet-dot bg-success me-1"></span>Login
          </div>
        </div>

        <div class="me-n2" style="position: absolute;right: 10px;top: 50px;">
          <a
            href="#"
            class="btn btn-icon btn-sm btn-active-color-primary mt-n2"
            data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-start"
            data-kt-menu-overflow="true"
          >
            <KTIcon icon-name="setting-2" icon-class="text-light fs-1" />
          </a>

          <UserMenu />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent } from "vue";
import UserMenu from "@/layouts/default-layout/components/menus/UserAccountMenu.vue";
import JwtService from "@/core/services/JwtService";

export default defineComponent({
  name: "kt--aside-toolbar",
  components: {
    UserMenu,
  },
  setup() {
    return {
      user : JwtService.getUser(),
      getAssetPath,
    };
  },
});
</script>
