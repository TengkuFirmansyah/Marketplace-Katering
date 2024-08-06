import {
  createRouter,
  createWebHistory,
  type RouteRecordRaw,
} from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useConfigStore } from "@/stores/config";
import ApiService from "@/core/services/ApiService";
import JwtService from "@/core/services/JwtService";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    redirect: "/dashboard",
    component: () => import("@/layouts/default-layout/DefaultLayout.vue"),
    meta: {
      middleware: "auth",
    },
    children: [
      {
        path: "/dashboard",
        name: "dashboard",
        component: () => import("@/views/Dashboard.vue"),
        meta: {
          pageTitle: "Dashboard",
          breadcrumbs: ["Dashboards"],
        },
      },
      {
        path: "/apps/customers/customers-listing",
        name: "apps-customers-listing",
        component: () => import("@/views/apps/customers/CustomersListing.vue"),
        meta: {
          pageTitle: "Customers Listing",
          breadcrumbs: ["Apps", "Customers"],
        },
      },
      // Settings
      {
        path: "/setting/roles",
        name: "setting-roles",
        component: () => import("@/views/setting/roles/index.vue"),
        meta: {
          pageTitle: "List Roles",
          breadcrumbs: ["Setting", "Roles"],
        },
      },
      {
          path: "/setting/roles/menus/:id",
          name: "setting-roles-menus",
          component: () => import("@/views/setting/roles/menus.vue"),
          meta: {
              pageTitle: "Setting Roles Menus",
              breadcrumbs: ["Setting", "Roles", "Menus"],
              permission: "setting-roles-menus",
          },
      },
      {
          path: "/setting/roles/permissions/:id",
          name: "setting-roles-permissions",
          component: () => import("@/views/setting/roles/permissions.vue"),
          meta: {
              pageTitle: "Setting Roles Permissions",
              breadcrumbs: ["Setting", "Roles", "Permissions"],
              permission: "setting-roles-permissions",
          },
      },
      {
        path: "/setting/url",
        name: "setting-url",
        component: () => import("@/views/setting/url/index.vue"),
        meta: {
          pageTitle: "List Url",
          breadcrumbs: ["Setting", "Url"],
        },
      },
      {
        path: "/setting/permissions",
        name: "setting-permissions",
        component: () => import("@/views/setting/permissions/index.vue"),
        meta: {
          pageTitle: "List Permissions",
          breadcrumbs: ["Setting", "Permissions"],
        },
      },
      {
        path: "/setting/users",
        name: "setting-users",
        component: () => import("@/views/setting/users/index.vue"),
        meta: {
          pageTitle: "List Users",
          breadcrumbs: ["Setting", "Users"],
        },
      },
      //End Setting

      {
        path: "/merchant/profile",
        name: "profile",
        component: () => import("@/views/crafted/account/Account.vue"),
        meta: {
          breadcrumbs: ["Pages", "Profile"],
        },
        children: [
          {
            path: "overview",
            name: "profile-overview",
            component: () =>
              import("@/views/crafted/account/Overview.vue"),
            meta: {
              pageTitle: "Overview",
            },
          },
          {
            path: "settings",
            name: "profile-settings",
            component: () =>
              import("@/views/crafted/account/Settings.vue"),
            meta: {
              pageTitle: "Merchant Settings",
            },
          },
        ],
      },

      {
        path: "/merchant/menu",
        name: "merchant-menu",
        component: () => import("@/views/merchant/menus/index.vue"),
        meta: {
          pageTitle: "List Menu",
          breadcrumbs: ["Merchant", "Menu"],
        },
      },
      {
        path: "/merchant/orders",
        name: "merchant-orders",
        component: () => import("@/views/merchant/orders/index.vue"),
        meta: {
          pageTitle: "List Orders",
          breadcrumbs: ["Merchant", "Orders"],
        },
      },
      {
        path: "/customer/pembelian",
        name: "customer-pembelian",
        component: () => import("@/views/customer/pembelian/index.vue"),
        meta: {
          pageTitle: "List Pembelian",
          breadcrumbs: ["customer", "Pembelian"],
        },
      },
      {
        path: "/customer/pencarian",
        name: "customer-pencarian",
        component: () => import("@/views/customer/pencarian/index.vue"),
        meta: {
          pageTitle: "List pencarian",
          breadcrumbs: ["customer", "pencarian"],
        },
      },
      {
          path: "/customer/pencarian/menus/:id",
          name: "customer-pencarian-menu",
          component: () => import("@/views/customer/pencarian/menus.vue"),
          meta: {
              pageTitle: "Pencarian Menus",
              breadcrumbs: ["Pencarian", "Menus"],
              permission: "customer-pencarian",
          },
      },
    ],
  },
  {
    path: "/",
    component: () => import("@/layouts/AuthLayout.vue"),
    children: [
      {
        path: "/sign-in",
        name: "sign-in",
        component: () =>
          import("@/views/crafted/authentication/basic-flow/SignIn.vue"),
        meta: {
          pageTitle: "Sign In",
        },
      },
      {
        path: "/sign-in/sisdam",
        name: "callback",
        component: () =>
          import("@/views/crafted/authentication/basic-flow/SignIn.vue"),
        meta: {
          pageTitle: "Sign In",
        },
      },
      {
        path: "/sign-up",
        name: "sign-up",
        component: () =>
          import("@/views/crafted/authentication/basic-flow/SignUp.vue"),
        meta: {
          pageTitle: "Sign Up",
        },
      },
      {
        path: "/password-reset",
        name: "password-reset",
        component: () =>
          import("@/views/crafted/authentication/basic-flow/PasswordReset.vue"),
        meta: {
          pageTitle: "Password reset",
        },
      },
    ],
  },
  {
    path: "/",
    component: () => import("@/layouts/SystemLayout.vue"),
    children: [
      {
        // the 404 route, when none of the above matches
        path: "/404",
        name: "404",
        component: () => import("@/views/crafted/authentication/Error404.vue"),
        meta: {
          pageTitle: "Error 404",
        },
      },
      {
        path: "/500",
        name: "500",
        component: () => import("@/views/crafted/authentication/Error500.vue"),
        meta: {
          pageTitle: "Error 500",
        },
      },
    ],
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/404",
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to) {
    // If the route has a hash, scroll to the section with the specified ID; otherwise, scroll to the top of the page.
    if (to.hash) {
      return {
        el: to.hash,
        top: 80,
        behavior: "smooth",
      };
    } else {
      return {
        top: 0,
        left: 0,
        behavior: "smooth",
      };
    }
  },
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const configStore = useConfigStore();

  // current page view title
  document.title = `${to.meta.pageTitle} - ${import.meta.env.VITE_APP_NAME}`;

  // reset config to initial state
  configStore.resetLayoutConfig();

  // verify auth token before each page change
  authStore.verifyAuth();
  authStore.menus();
  // before page access check if page requires authentication
  if (to.meta.middleware == "auth") {
    ApiService.post("verify_token", { token: JwtService.getToken() })
    .then(({ data }) => {
      authStore.setAuth(data.data);
      JwtService.saveUser(data.user);
      if (data.user.role.name != 'Customer' && to.name != "profile-settings" && data.user.merchant == null) {
        router.push({ name: "profile-settings" });
      }
    })
    .catch(({ response }) => {
      authStore.setError(response.data.errors);
      authStore.purgeAuth();
    });
    if (authStore.isAuthenticated) {
      next();
    } else {
      next({ name: "sign-in" });
    }
  } else {
    next();
  }
});

export default router;
