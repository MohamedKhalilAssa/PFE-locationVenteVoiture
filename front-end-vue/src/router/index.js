import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import PageNotFound from "../views/PageNotFound.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/neuf",
    name: "neuf",
    component: () => import("../views/Neuf/NeufListingsView.vue"),
  },
  {
    path: "/occasion",
    name: "occasion",
    component: () => import("../views/Occasion/OccasionListingsView.vue"),
  },
  {
    path: "/location",
    name: "location",
    component: () => import("../views/Location/LocationListingsView.vue"),
  },
  {
    path: "/annonce",
    name: "annonce",
    component: () => import("../views/AnnonceView.vue"),
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("../views/Users/RegisterView.vue"),
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("../views/Users/LoginView.vue"),
  },
  {
    path: "/:catchAll(.*)",
    name: "NotFound",
    component: PageNotFound,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
