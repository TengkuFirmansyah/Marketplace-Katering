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
          <label class="required fs-6 fw-semibold mb-2">Name</label>
          <el-form-item prop="name">
            <el-input
              v-model="formData.name"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <label class="required fs-6 fw-semibold mb-2">Slug</label>
          <el-form-item prop="slug">
            <el-input
              v-model="formData.slug"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <label class="fs-6 fw-semibold mb-2">Description</label>
          <el-form-item prop="description">
            <el-input
              v-model="formData.description"
              type="text"
              placeholder=""
            />
          </el-form-item>
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

export default defineComponent({
  name: "add-customer-modal",
  components: {},
  emits: ["on-save"],
  props: ["data"],
  setup(props, {emit}) {
    const dataModal = props.data;
    const formRef = ref<null | HTMLFormElement>(null);
    const loading = ref<boolean>(false);
    const formData = ref({
      id: null,
      name : '',
      slug : '',
      description : '',
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
    });

    const submit = () => {
      if (!formRef.value) {
        return;
      }
      formRef.value.validate((valid: boolean) => {
        if (valid && loading.value == false) {
          loading.value = true;
          if(props.data.id){
            ApiService.put("permissions/"+props.data.id, formData.value)
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
                  emit("on-save");
                });
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
            ApiService.post("permissions", formData.value)
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
                  emit("on-save");
                  loading.value = false
                });
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

    return {
      dataModal,
      formData,
      rules,
      submit,
      formRef,
      loading,
      getAssetPath,
      listParent,
    };
  },
});
</script>
