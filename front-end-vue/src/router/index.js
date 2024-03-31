import { createRouter, createWebHistory } from "vue-router";
import { useStore } from "vuex";
import axios from "axios";
// subfiles
import usersRoutes from "./AdminRoutes/usersRoutes";
import marquesRoutes from "./AdminRoutes/marquesRoutes";
import modelesRoutes from "./AdminRoutes/modelesRoutes";
import villesRoutes from "./AdminRoutes/villesRoutes";
import couleursRoutes from "./AdminRoutes/couleursRoutes";
import authenticationRoutes from "./GlobalRoutes/authenticationRoutes";
import Endpoints from "@/assets/JS/Endpoints";

const routes = [
  {
    path: "/",
    name: "home",
    component: () => import("../views/FrontOffice/HomeView.vue"),
  },
  {
    path: "/neuf",
    name: "neuf",
    component: () => import("../views/FrontOffice/Neuf/NeufListingsView.vue"),
  },
  {
    path: "/occasion",
    name: "occasion",
    component: () =>
      import("../views/FrontOffice/Occasion/OccasionListingsView.vue"),
  },
  {
    path: "/location",
    name: "location",
    component: () =>
      import("../views/FrontOffice/Location/LocationListingsView.vue"),
  },
  {
    path: "/annonce",
    name: "annonce",
    component: () =>
      import("../views/FrontOffice/Annonces/CreateAnnonceView.vue"),
    meta: { requiresAuth: true },
  },
  // Authentication routes
  ...authenticationRoutes,
  {
    path: "/admin",
    children: [
      {
        path: "",
        name: "DashboardView",
        component: () =>
          import("../views/BackOffice/AdminViews/DashboardView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },

      ...usersRoutes,
      ...marquesRoutes,
      ...modelesRoutes,
      ...couleursRoutes,
      ...villesRoutes,

      {
        path: "location",
        component: () =>
          import("../views/BackOffice/AdminViews/Actions/LocationView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      {
        path: "occasion",
        component: () =>
          import("../views/BackOffice/AdminViews/Occasion/OccasionView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      {
        path: "neuf",
        component: () =>
          import("../views/BackOffice/AdminViews/Neuf/NeufView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      {
        path: "vente",
        component: () =>
          import("../views/BackOffice/AdminViews/Actions/VenteView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      // { path: "users/:id", component: AdminUserDetails },
    ],
  },
  {
    path: "/:catchAll(.*)",
    name: "NotFound",
    component: () => import("@/views/PageNotFound.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresGuest && localStorage.getItem("Authentication")) {
    next(from);
  } else if (to.meta.requiresAuth && !localStorage.getItem("Authentication")) {
    //initial check for token
    let previous = to.name;
    next({ name: "Login", query: { previous: previous } });
  } else if (to.meta.requiresAuth && localStorage.getItem("Authentication")) {
    // to check the token authenticity
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    const store = useStore();
    try {
      const { data } = await axios.get(Endpoints.getAuthenticatedUser);

      if (data) {
        if (!to.meta.requiresAdmin) {
          next();
        } else if (
          (data.role == "admin" ||
          data.role == "root") && to.meta.requiresAdmin)
         {
          next();
        } else {
          store.commit(
            "setError",
            "Vous n'avez pas les droits pour accéder à cette page"
          );
          store.commit("setErrorCode", 403);
          next({ name: "home" });
        }
      }
    } catch (error) {
      localStorage.removeItem("Authentication");
      localStorage.removeItem("User");
      localStorage.removeItem("authMessage");
      store.commit("setAuthentication");
      store.commit("setUser");
      let previous = to.name;
      next({ name: "Login", query: { previous: previous } });
    }
  } else {
    next();
  }
});

export default router;
