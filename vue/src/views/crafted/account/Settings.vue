<template>
  <div class="card mb-5 mb-xl-10">
    <div
      class="card-header border-0 cursor-pointer"
      role="button"
      data-bs-toggle="collapse"
      data-bs-target="#kt_account_profile_details"
      aria-expanded="true"
      aria-controls="kt_account_profile_details"
    >
      <div class="card-title m-0">
        <h3 class="fw-bold m-0">Merchant Details</h3>
      </div>
    </div>

    <div id="kt_account_profile_details" class="collapse show">
      <VForm
        id="kt_account_profile_details_form"
        class="form"
        novalidate
        @submit="saveChanges1()"
      >
        <div class="card-body border-top p-9">
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Perusahaan</label>
            <div class="col-lg-8 fv-row">
              <Field
                type="text"
                name="nama"
                class="form-control form-control-lg form-control-solid"
                placeholder="Nama Perusahaan"
                v-model="profileDetails.nama"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="nama" />
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat</label>
            <div class="col-lg-8 fv-row">
              <Field
                type="text"
                name="alamat"
                class="form-control form-control-lg form-control-solid"
                placeholder="Alamat Perusahaan"
                v-model="profileDetails.alamat"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="alamat" />
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Kontak</label>
            <div class="col-lg-8 fv-row">
              <Field
                type="text"
                name="kontak"
                class="form-control form-control-lg form-control-solid"
                placeholder="Kontak Perusahaan"
                v-model="profileDetails.kontak"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="kontak" />
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Deskripsi</label>
            <div class="col-lg-8 fv-row">
              <Field
                type="text"
                name="deskripsi"
                class="form-control form-control-lg form-control-solid"
                placeholder="Deskripsi Perusahaan"
                v-model="profileDetails.deskripsi"
              />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="deskripsi" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <button
            type="submit"
            id="kt_account_profile_details_submit"
            ref="submitButton1"
            class="btn btn-primary"
          >
            <span class="indicator-label"> Save </span>
            <span class="indicator-progress">
              Please wait...
              <span
                class="spinner-border spinner-border-sm align-middle ms-2"
              ></span>
            </span>
          </button>
        </div>
      </VForm>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import { ErrorMessage, Field, Form as VForm } from "vee-validate";
import Swal from "sweetalert2/dist/sweetalert2.js";
import ApiService from "@/core/services/ApiService";
import * as Yup from "yup";
import router from "@/router";

interface ProfileDetails {
  id: null;
  user_id: string;
  nama: string;
  alamat: string;
  kontak: string;
  deskripsi: string;
}

export default defineComponent({
  name: "account-settings",
  components: {
    ErrorMessage,
    Field,
    VForm,
  },
  setup() {
    const submitButton1 = ref<HTMLElement | null>(null);

    const profileDetails = ref<ProfileDetails>({
      id: null,
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

    const saveChanges1 = () => {
      console.log(profileDetails.value);
      if (submitButton1.value) {
        submitButton1.value.setAttribute("data-kt-indicator", "on");
        ApiService.post("auth/profile", profileDetails.value)
          .then(({ data }) => {
            Swal.fire({
              text: "Data telah tersimpan!",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              heightAuto: false,
              customClass: {
                confirmButton: "btn btn-primary",
              },
            }).then(() => {
              submitButton1.value?.removeAttribute("data-kt-indicator");
              router.push({ name: "profile-overview" });
            });
          })
          .catch(({ response }) => {
            submitButton1.value?.removeAttribute("data-kt-indicator");
            Swal.fire({
              text: "Sorry, looks like there are some errors detected, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              heightAuto: false,
              customClass: {
                confirmButton: "btn btn-primary",
              },
            });
          });
      }
    };

    return {
      submitButton1,
      saveChanges1,
      profileDetails,
      getAssetPath,
    };
  },
});
</script>
