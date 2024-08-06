<template>
  <div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
      <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
        <div class="me-7 mb-4">
          <div
            class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
          >
            <img :src="getAssetPath('media/avatars/blank.png')" alt="image" />
            <div
              class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"
            ></div>
          </div>
        </div>

        <div class="flex-grow-1">
          <div
            class="d-flex justify-content-between align-items-start flex-wrap mb-2"
          >
            <div class="d-flex flex-column">
              <div class="d-flex align-items-center mb-2">
                <a href="#"
                  class="text-gray-800 text-hover-primary fs-2 fw-bold me-1"
                  >{{user.name}}</a
                >
                <a href="#">
                  <KTIcon icon-name="verify" icon-class="fs-1 text-primary" />
                </a>
              </div>

              <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                <a
                  href="#"
                  class="d-flex align-items-center text-gray-500 text-hover-primary mb-2"
                >
                  <KTIcon icon-name="sms" icon-class="fs-4 me-1" />
                  {{user.email}}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex overflow-auto h-55px">
        <ul
          class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap"
        >
          <li class="nav-item">
            <router-link
              to="/merchant/profile/overview"
              class="nav-link text-active-primary me-6"
              active-class="active"
            >
              Overview
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              to="/merchant/profile/settings"
              class="nav-link text-active-primary me-6"
              active-class="active"
            >
              Setting Merchant
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <router-view></router-view>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import Dropdown3 from "@/components/dropdown/Dropdown3.vue";
import { defineComponent, onMounted, ref } from "vue";
import JwtService from "@/core/services/JwtService";

export default defineComponent({
  name: "kt-account",
  components: {
    Dropdown3,
  },
  
  setup() {
    const user = ref({
     name: '' ,
     email: '' ,
    })
    onMounted(() => {
      refreshList();
    });

    const refreshList = () => {
      user.value = JwtService.getUser();
      // if(JwtService.getProfileUser().mahasiswa != null) {
      //     this.$Helpers.getImage(JwtService.getProfileUser().mahasiswa.picture_path,JwtService.getProfileUser().mahasiswa.picture_name, true)
      //     .then((data) => {
      //         this.imageProfile = data
      //     });
      // }
    }
    return {
      getAssetPath,
      user,
    };
  },
});
</script>
