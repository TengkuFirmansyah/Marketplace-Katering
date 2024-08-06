<template>
  <el-form
    @submit.prevent="submit()"
    :model="formData"
    :rules="rules"
    ref="formRef"
  >
    <div class="modal-body py-10 px-lg-17">
      <div
        class="scroll-y me-n7 pe-7"
        id="kt_modal_add_scroll"
        data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}"
        data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_add"
        data-kt-scroll-wrappers="#kt_modal_add_scroll"
        data-kt-scroll-offset="300px"
      >
        <div class="fv-row mb-7">
          <label class="required fs-6 fw-semibold mb-2">Nama</label>
          <el-form-item prop="nama">
            <el-input
              v-model="formData.nama"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <label class="required fs-6 fw-semibold mb-2">Deskripsi</label>
          <el-form-item prop="deskripsi">
            <el-input
              v-model="formData.deskripsi"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <label class="fs-6 fw-semibold mb-2">Harga</label>
          <el-form-item prop="harga">
            <el-input
              v-model="formData.harga"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto</label>

            <div class="col-lg-8">
              <div
                class="image-input image-input-outline"
                data-kt-image-input="true"
                :style="{
                  backgroundImage: `url(${getAssetPath(
                    '/media/avatars/blank.png'
                  )})`,
                }"
              >
                <div class="image-input-wrapper w-125px h-125px"
                    :style="`background-image: url(${showimage})`" v-if="showimage"></div>
                <div class="image-input-wrapper w-125px h-125px" :style="`background-image: url(/media/avatars/blank.png)`" v-else></div>

                <label
                  class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="change"
                  data-bs-toggle="tooltip"
                  title="Change avatar"
                >
                  <i class="bi bi-pencil-fill fs-7"></i>
                  <input type="file" name="avatar" accept=".png, .jpg, .jpeg" @change="handleFileUpload($event)"/>
                  <input type="hidden" name="avatar_remove" />
                </label>

                <span
                  class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="remove"
                  data-bs-toggle="tooltip"
                  @click="removeImage()"
                  title="Remove avatar"
                >
                  <i class="bi bi-x fs-2"></i>
                </span>
              </div>

              <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer flex-center">
      <button
        type="reset"
        data-bs-dismiss="modal"
        id="kt_modal_add_cancel"
        class="btn btn-light me-3"
      >
        Close
      </button>
      <button
        :data-kt-indicator="loading ? 'on' : null"
        class="btn btn-lg btn-primary"
        type="submit"
      >
        <span v-if="!loading" class="indicator-label">
          Simpan
          <KTIcon icon-name="arrow-right" icon-class="fs-2 me-2" />
        </span>
        <span v-if="loading" class="indicator-progress">
          Please wait...
          <span
            class="spinner-border spinner-border-sm align-middle ms-2"
          ></span>
        </span>
      </button>
    </div>
  </el-form>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import { countries } from "@/core/data/countries";
import Swal from "sweetalert2/dist/sweetalert2.js";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";
import axios from "axios";

export default defineComponent({
  name: "add-customer-modal",
  components: {},
  emits: ["on-save"],
  props: ["data"],
  setup(props, {emit}) {
    const showimage = ref();
    const image = ref();
    const dataModal = props.data;
    const formRef = ref<null | HTMLFormElement>(null);
    const loading = ref<boolean>(false);
    const formData = ref({
      id: null,
      merchant_id: null,
      nama : '',
      deskripsi : '',
      foto : "/media/avatars/blank.png",
      harga : '',
    });
    const listParent = ref([]);

    const rules = ref({
      name: [
        {
          required: true,
          message: "Name is required",
          trigger: "change",
        },
      ],
      slug: [
        {
          required: true,
          message: "Slug is required",
          trigger: "change",
        },
      ],
    });
    
    onMounted(() => {
      formData.value = props.data;
      formData.value.merchant_id = JwtService.getUser().merchant.id;
      if(props.data.foto == '') {
        formData.value.foto = "/media/avatars/blank.png"
      } else {
        showimage.value = props.data.foto
      }
    });

    const submit = () => {
      if (!formRef.value) {
        return;
      }
      formRef.value.validate((valid: boolean) => {
        if (valid && loading.value == false) {
          loading.value = true;
          if(props.data.id){
            ApiService.put("menu/"+props.data.id, formData.value)
              .then(({ data }) => {
                updateImage(data.data.id);
              })
              .catch(({ response }) => {
                loading.value = false;
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
          } else {
            ApiService.post("menu", formData.value)
              .then(({ data }) => {
                updateImage(data.data.id);
              })
              .catch(({ response }) => {
                loading.value = false;
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
        } else {
          return false;
        }
      });
    };

    const updateImage = (id) => {
      if (image.value) {
          const url =
            process.env.NODE_ENV === "production"
              ? import.meta.env.VITE_APP_API_URL_PROD
              : import.meta.env.VITE_APP_API_URL;
          const formData = new FormData();
          formData.append("file", image.value);
          axios
              .post(
                  url + "menu/" + id + "?_method=PUT",
                  formData,
                  {
                      headers: {
                          "Content-Type":
                              "application/x-www-form-urlencoded; charset=UTF-8",
                          Authorization:
                              "Bearer " + JwtService.getToken(),
                          Accept: "application/json",
                      },
                  }
              )
              .then((response) => {
                  Swal.fire({
                      text: "You have successfully saved data!",
                      icon: "success",
                      buttonsStyling: false,
                      confirmButtonText: "Ok, got it!",
                      customClass: {
                          confirmButton: "btn fw-semobold btn-light-primary",
                      },
                  }).then(function () {
                    emit("on-save");
                    loading.value = false
                  });
              })
              .catch(({ response }) => {
                  Swal.fire({
                      text: response.data.message,
                      icon: "error",
                      buttonsStyling: false,
                      confirmButtonText: "Try again!",
                      customClass: {
                          confirmButton: "btn fw-semobold btn-light-danger",
                      },
                  });
                  emit("on-save");
                  loading.value = false
              });;
      } else {
          Swal.fire({
              text: "You have successfully saved data!",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                  confirmButton: "btn fw-semobold btn-light-primary",
              },
          }).then(function () {
              emit("on-save");
              loading.value = false
          });
      }
  };
    const handleFileUpload = (event) => {
        let file = event.target.files[0];
        formData.value.foto = file.name;
        showimage.value = URL.createObjectURL(file);
        image.value = file;
    };
    const removeImage = () => {
      formData.value.foto = "/media/avatars/blank.png";
      if (formData.value.foto != null) {
          showimage.value = formData.value.foto;
      } else {
          showimage.value = "media/avatars/blank.png";
      }
    };
    return {
      dataModal,
      formData,
      rules,
      submit,
      formRef,
      loading,
      getAssetPath,
      listParent,
      removeImage,
      handleFileUpload,
      showimage,
      image,
    };
  },
});
</script>
