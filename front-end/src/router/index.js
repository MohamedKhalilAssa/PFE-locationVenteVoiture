import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import PageNotFound from "../views/PageNotFound.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
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
      path: "/:catchAll(.*)",
      name: "NotFound",
      component: PageNotFound,
    },
  ],
});

export default router;
