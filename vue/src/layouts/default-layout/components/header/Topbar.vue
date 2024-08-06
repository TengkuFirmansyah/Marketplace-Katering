<template>
  <div class="d-flex align-items-stretch overflow-auto pt-3 pt-lg-0">
    <!-- <div class="d-flex align-items-center">
      <span
        class="fs-7 fw-bold text-gray-700 pe-4 text-nowrap d-none d-xxl-block"
        >Sort By:</span
      >

      <select
        class="form-select form-select-sm form-select-solid w-100px w-xxl-125px"
      >
        <option value="1" selected>Latest</option>
        <option value="2">In Progress</option>
        <option value="3">Done</option>
      </select>
    </div>

    <div class="d-flex align-items-center">
      <div class="bullet bg-secondary h-35px w-1px mx-5"></div>

      <span class="fs-7 text-gray-700 fw-bold d-none d-sm-block"
        >Impact <span class="d-none d-xxl-inline">Level</span>:</span
      >

      <div class="d-flex align-items-center ps-4" id="kt_toolbar">
        <div
          id="kt_toolbar_slider"
          class="noUi-target noUi-target-primary w-75px w-xxl-150px noUi-sm"
        ></div>

        <span
          id="kt_toolbar_slider_value"
          class="d-flex flex-center bg-light-primary rounded-circle w-35px h-35px ms-4 fs-7 fw-bold text-primary"
          data-bs-toggle="tooltip"
          data-bs-placement="top"
          title="Set impact level"
        >
        </span>
      </div>

      <div class="bullet bg-secondary h-35px w-1px mx-5"></div>
    </div>

    <div class="d-flex align-items-center">
      <span class="fs-7 text-gray-700 fw-bold pe-3 d-none d-xxl-block"
        >Quick Tools:</span
      >

      <div class="d-flex">
        <a
          href="#"
          class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary"
          data-bs-toggle="modal"
          data-bs-target="#kt_modal_invite_friends"
        >
          <KTIcon icon-name="delete-files" icon-class="fs-2" />
        </a>

        <div class="d-flex align-items-center">
          <router-link
            to="/apps/subscriptions/add-subscription"
            class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary"
          >
            <KTIcon icon-name="add-files" icon-class="fs-2" />
          </router-link>
        </div>

        <div class="d-flex align-items-center">
          <a
            href="#"
            class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_create_app"
          >
            <KTIcon icon-name="file-up" icon-class="fs-2" />
          </a>
        </div>
      </div>
    </div> -->
    <div class="d-flex align-items-center">
      <a
        @click="signOut()"
        class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary"
        data-bs-toggle="modal"
        data-bs-target="#kt_modal_create_app"
      >
        <i class="bi bi-box-arrow-right fs-2"></i>
      </a>
    </div>
    <div class="d-flex align-items-center">
      <a
        href="#"
        class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary"
        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
        data-kt-menu-attach="parent"
        data-kt-menu-placement="bottom-end"
      >
        <KTIcon icon-name="night-day" icon-class="theme-light-show fs-2" />
        <KTIcon icon-name="moon" icon-class="theme-dark-show fs-2" />
      </a>
      <KTThemeModeSwitcher></KTThemeModeSwitcher>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted } from "vue";
import noUiSlider, { type target } from "nouislider";
import KTThemeModeSwitcher from "@/layouts/default-layout/components/theme-mode/ThemeModeSwitcher.vue";

import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

export default defineComponent({
  name: "layout-topbar",
  components: {
    KTThemeModeSwitcher,
  },
  setup() {
    const router = useRouter();
    const store = useAuthStore();
    const initSlider = (): void => {
      const slider: target = document.querySelector(
        "#kt_toolbar_slider"
      ) as target;
      const rangeSliderValueElement: Element | null = document.querySelector(
        "#kt_toolbar_slider_value"
      );

      if (!slider) {
        return;
      }

      slider.innerHTML = "";

      noUiSlider.create(slider, {
        start: [5],
        connect: [true, false],
        step: 1,
        range: {
          min: [1],
          max: [10],
        },
      });

      slider.noUiSlider?.on("update", function (values: any, handle: any) {
        if (!rangeSliderValueElement) {
          return;
        }

        rangeSliderValueElement.innerHTML = parseInt(values[handle]).toFixed(1);
      });
    };

    const signOut = () => {
      store.logout();
      router.push({ name: "sign-in" });
    };

    onMounted(() => {
      initSlider();
    });

    return {
      getAssetPath,
      signOut
    };
  },
});
</script>
