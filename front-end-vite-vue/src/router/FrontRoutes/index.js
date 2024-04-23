import annonceRoutes from "@/router/FrontRoutes/annonce.js";

export default [
  {
    path: "/",
    name: "homeView",
    component: () => import("@/views/FrontOffice/HomeView.vue"),
  },
  {
    path: "/profile",
    name: "profileView",
    component: () => import("@/views/FrontOffice/Profile/ProfileView.vue"),
    meta: { requiresAuth: true },
  },
  ...annonceRoutes,
];
