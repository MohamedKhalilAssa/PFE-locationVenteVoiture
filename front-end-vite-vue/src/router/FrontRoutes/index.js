import annonceRoutes from "@/router/FrontRoutes/annonce.js";

export default [
  {
    path: "/",
    name: "homeView",
    component: () => import("@/views/FrontOffice/HomeView.vue"),
  },
  ...annonceRoutes,
];
