import { ref } from "vue";
import { defineStore } from "pinia";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";
import router from "@/router";
import Swal from "sweetalert2";

export interface User {
  id: string;
  name: string;
  email: string;
  password: string;
  access_token: string;
}

export const useAuthStore = defineStore("auth", () => {
  const errors = ref({});
  const user = ref<User>({} as User);
  const isAuthenticated = ref(!!JwtService.getToken());

  function setAuth(authUser: User) {
    isAuthenticated.value = true;
    user.value = authUser;
    errors.value = {};
    JwtService.saveToken("bearer " +user.value.access_token);
  }

  function setMenus(data: any) {
    JwtService.saveMenus(data.data);
  }

  function setError(error: any) {
    errors.value = { ...error };
  }

  function purgeAuth() {
    isAuthenticated.value = false;
    user.value = {} as User;
    errors.value = [];
    JwtService.destroyToken();
  }

  function login(credentials: User) {
    return ApiService.post("login", credentials)
      .then(({ data }) => {
        JwtService.saveUser(data.user);
        setAuth(data.data);
      })
      .catch(({ response }) => {
        setError(response.data);
      });
  }

  function menus() {
    if (JwtService.getToken()) {
      ApiService.setHeader();
      ApiService.get("auth","menus")
        .then(({ data }) => {
          setMenus(data)
        })
        .catch(({ response }) => {
          // console.log(response.data)
        });
    }
  }

  function logout() {
    purgeAuth();
  }

  function register(credentials: User) {
    return ApiService.post("register", credentials)
      .then(({ data }) => {
        Swal.fire({
          text: "You have successfully Register!",
          icon: "success",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          heightAuto: false,
          customClass: {
            confirmButton: "btn fw-semibold btn-light-primary",
          },
        }).then(function () {
          router.push({ name: "sign-in" });
        });
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function forgotPassword(email: string) {
    return ApiService.post("forgot_password", email)
      .then(() => {
        setError({});
      })
      .catch(({ response }) => {
        setError(response.data.errors);
      });
  }

  function verifyAuth() {
    if (JwtService.getToken()) {
      ApiService.setHeader();
      ApiService.post("verify_token", { token: JwtService.getToken() })
        .then(({ data }) => {
          setAuth(data.data);
        })
        .catch(({ response }) => {
          setError(response.data.errors);
          purgeAuth();
        });
    } else {
      purgeAuth();
    }
  }

  return {
    errors,
    user,
    isAuthenticated,
    login,
    menus,
    logout,
    register,
    forgotPassword,
    verifyAuth,
    setError,
    purgeAuth,
    setAuth
  };
});
