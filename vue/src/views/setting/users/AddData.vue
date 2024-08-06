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
          <label class="required fs-6 fw-semibold mb-2">Email</label>
          <el-form-item prop="email">
            <el-input
              v-model="formData.email"
              type="text"
              placeholder=""
            />
          </el-form-item>
        </div>

        <div class="fv-row mb-7">
          <label class="required fs-6 fw-semibold mb-2">Role</label>
            <select
              class="form-select"
              v-model="formData.role_id"
            >
              <option 
              v-for="(item, i) in listRole"
              :key="i"
              :value="item.id"
              :label="item.name"></option>
            </select>
        </div>

        <div class="fv-row mb-7">
          <label class="fs-6 fw-semibold mb-2">Password</label>
          <el-form-item prop="password">
            <el-input
              v-model="formData.password"
              type="password"
              placeholder=""
            />
          </el-form-item>
        </div>
        <div class="fv-row mb-7">
          <label class="fs-6 fw-semibold mb-2">Confirm Password</label>
          <el-form-item prop="confirmPassword">
            <el-input
              v-model="formData.confirmPassword"
              type="password"
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
      email : '',
      role_id : '',
      password : '',
      confirmPassword: '',
    });
    const listRole = ref([{
      id: null,
      name: ""
    }]);

    const rules = ref({
      name: [
        {
          required: true,
          message: "Name is required",
          trigger: "change",
        },
      ],
      email: [
        {
          required: true,
          message: "Email is required",
          trigger: "change",
        },
      ],
      password: [
          { min: 8, message: 'Password must be at least 8 characters', trigger: 'blur' }
        ],
        confirmPassword: [
          { message: 'Please confirm your password', trigger: 'blur' },
          {
            validator: (rule, value, callback) => {
              console.log(value)
              if (value !== formData.value.password) {
                callback(new Error('The two passwords do not match'));
              } else {
                callback();
              }
            },
            trigger: 'blur'
          }
        ]
    });
    
    onMounted(() => {
      formData.value = props.data;
      getRole()
    });

    const getRole = () => {
      let url = "roles?order=parent_id:ASC&limit=0";
        ApiService.get("",url)
        .then(({ data }) => {
            listRole.value = data.data;
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
        });
    };
    const submit = () => {
      if (!formRef.value) {
        return;
      }
      formRef.value.validate((valid: boolean) => {
        if (valid && loading.value == false) {
          loading.value = true;

          if(props.data.id){
            ApiService.put("accounts/"+props.data.id, formData.value)
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
            ApiService.post("accounts", formData.value)
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
      listRole,
    };
  },
});
</script>
