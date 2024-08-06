<template>
  <div class="w-lg-500px p-10">
    <VForm
      class="form w-100"
      id="kt_login_signin_form"
      @submit="onSubmitLogin"
      :validation-schema="login"
      :initial-values="{ email: '', password: '' }"
    >
      <div class="text-center mb-10">
        <h1 class="text-gray-900 mb-3">Login</h1>
      </div>
<!-- 
      <div class="mb-10 bg-light-info p-8 rounded">
        <div class="text-info">
          Use account <strong>admin@demo.com</strong> and password
          <strong>demo</strong> to continue.
        </div>
      </div> -->

      <div class="fv-row mb-10">
        <label class="form-label fs-6 fw-bold text-gray-900">Email</label>

        <Field
          tabindex="1"
          class="form-control form-control-lg form-control-solid"
          type="text"
          name="email"
          autocomplete="off"
        />
        <div class="fv-plugins-message-container">
          <div class="fv-help-block">
            <ErrorMessage name="email" />
          </div>
        </div>
      </div>

      <div class="fv-row mb-10">
        <div class="d-flex flex-stack mb-2">
          <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>

          <router-link to="/password-reset" class="link-primary fs-6 fw-bold">
            Lupa Password ?
          </router-link>
        </div>

        <Field
          tabindex="2"
          class="form-control form-control-lg form-control-solid"
          type="password"
          name="password"
          autocomplete="off"
        />
        <div class="fv-plugins-message-container">
          <div class="fv-help-block">
            <ErrorMessage name="password" />
          </div>
        </div>
      </div>

      <div class="text-center">
        <button
          tabindex="3"
          type="submit"
          ref="submitButton"
          id="kt_sign_in_submit"
          class="btn btn-lg btn-primary w-100 mb-5"
          v-if="loading == false"
        >
          <span class="indicator-label"> Login </span>

          <span class="indicator-progress">
            Please wait...
            <span
              class="spinner-border spinner-border-sm align-middle ms-2"
            ></span>
          </span>
        </button>
        <div class="text-center text-muted text-uppercase fw-bold mb-5">or</div>
        
        <router-link to="/sign-up" class="btn btn-flex flex-center btn-dark btn-lg w-100 mb-5">
          Daftar
        </router-link>
      </div>
    </VForm>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import { ErrorMessage, Field, Form as VForm } from "vee-validate";
import { useAuthStore, type User } from "@/stores/auth";
import { useRoute, useRouter } from "vue-router";
import Swal from "sweetalert2/dist/sweetalert2.js";
import * as Yup from "yup";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";

export default defineComponent({
  name: "sign-in",
  components: {
    Field,
    VForm,
    ErrorMessage,
  },
  setup() {
    const store = useAuthStore();
    const route = useRoute();
    const router = useRouter();
    const loading = ref<boolean>(false);
    const submitButton = ref<HTMLButtonElement | null>(null);

    const login = Yup.object().shape({
      email: Yup.string().email().required().label("Email"),
      password: Yup.string().min(4).required().label("Password"),
    });

    onMounted(() => {
      if(route.query.code){
        loginNeo()
      }
    });
    const loginNeo = async () => {
      loading.value = true;
      try {
        const { data } = await ApiService.post("login_neo/callback", route.query);
        JwtService.saveUser(data.user);
        await store.setAuth(data.data);
        console.log(JwtService.getToken())
        await store.menus();
        Swal.fire({
          text: "You have successfully logged in!",
          icon: "success",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          heightAuto: false,
          customClass: {
            confirmButton: "btn fw-semibold btn-light-primary",
          },
        }).then(() => {
          loading.value = false;
          router.push({ name: "dashboard" });
        });
      } catch (error) {
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
      }
    }
    const onSubmitLogin = async (values: any) => {
      values = values as User;
      store.logout();

      if (submitButton.value) {
        submitButton.value!.disabled = true;
        submitButton.value.setAttribute("data-kt-indicator", "on");
      }

      await store.login(values);
      const error = Object.values(store.errors);
      
      if (error.length === 0) {
        store.menus() 
        Swal.fire({
          text: "You have successfully logged in!",
          icon: "success",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          heightAuto: false,
          customClass: {
            confirmButton: "btn fw-semibold btn-light-primary",
          },
        }).then(() => {
          router.push({ name: "dashboard" });
        });
      } else {
        Swal.fire({
          text: "Email atau Password Salah",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Try again!",
          heightAuto: false,
          customClass: {
            confirmButton: "btn fw-semibold btn-light-danger",
          },
        }).then(() => {
          store.errors = {};
        });
      }

      submitButton.value?.removeAttribute("data-kt-indicator");
        submitButton.value!.disabled = false;
    };

    return {
      onSubmitLogin,
      login,
      submitButton,
      getAssetPath,
      loading
    };
  },
});
</script>
