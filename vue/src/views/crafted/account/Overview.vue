<template>
  <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
      <div class="card-title m-0">
        <h3 class="fw-bold m-0">Merchant Details</h3>
      </div>

      <router-link
        to="/merchant/profile/settings"
        class="btn btn-primary align-self-center"
        >Edit Merchant</router-link
      >
    </div>

    <div class="card-body p-9">
      <div class="row mb-7">
        <label class="col-lg-4 fw-semibold text-muted">Nama</label>
        <div class="col-lg-8">
          <span class="fw-bold fs-6 text-gray-900">{{profileDetails.nama}}</span>
        </div>
      </div>

      <div class="row mb-7">
        <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
        <div class="col-lg-8 fv-row">
          <span class="fw-semibold fs-6">{{profileDetails.alamat}}</span>
        </div>
      </div>

      <div class="row mb-7">
        <label class="col-lg-4 fw-semibold text-muted">
          Kontak
          <i
            class="fas fa-exclamation-circle ms-1 fs-7"
            v-tooltip
            title="Phone number must be active"
          ></i>
        </label>

        <div class="col-lg-8 d-flex align-items-center">
          <span class="fw-bold fs-6 me-2">{{profileDetails.kontak}}</span>

          <span class="badge badge-success">Verified</span>
        </div>
      </div>

      <div class="row mb-7">
        <label class="col-lg-4 fw-semibold text-muted">Deskripsi</label>

        <div class="col-lg-8 fw-bold">
          {{ profileDetails.deskripsi }}
        </div>
      </div>
    </div>
  </div>

</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import ApiService from "@/core/services/ApiService";

interface ProfileDetails {
  user_id: string;
  nama: string;
  alamat: string;
  kontak: string;
  deskripsi: string;
}

export default defineComponent({
  name: "account-overview",
  components: {},
  setup() {
    const profileDetails = ref<ProfileDetails>({
      user_id: "",
      nama: "Contoh Merchant",
      alamat: "Jl. Raya Kota Bogor",
      kontak: "0812345678",
      deskripsi: "Menjual Segala jenis masakan daging ayam",
    });
    onMounted(() => {
      dataMerchant();
    });

    const dataMerchant = () => {
      ApiService.get("auth", "profile")
        .then(({ data }) => {
          if(data.data != null) {
            profileDetails.value = data.data
          }
        });
    };
    return {
      getAssetPath,
      profileDetails,
    };
  },
});
</script>
