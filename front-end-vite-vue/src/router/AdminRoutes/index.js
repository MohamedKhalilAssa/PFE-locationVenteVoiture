import usersRoutes from "@/router/AdminRoutes/usersRoutes";
import marquesRoutes from "@/router/AdminRoutes/marquesRoutes";
import modelesRoutes from "@/router/AdminRoutes/modelesRoutes";
import villesRoutes from "@/router/AdminRoutes/villesRoutes";
import couleursRoutes from "@/router/AdminRoutes/couleursRoutes";
import analyticsRoutes from "@/router/AdminRoutes/analyticsRoutes";
import venteRoutes from "@/router/AdminRoutes/venteRoutes";
import locationRoutes from "@/router/AdminRoutes/locationRoutes";
import occasionRoutes from "@/router/AdminRoutes/occasionRoutes";
import neufRoutes from "@/router/AdminRoutes/neufRoutes";

export default [
  ...usersRoutes,
  ...marquesRoutes,
  ...modelesRoutes,
  ...couleursRoutes,
  ...villesRoutes,
  ...analyticsRoutes,
  ...venteRoutes,
  ...locationRoutes,
  ...occasionRoutes,
  ...neufRoutes,
  {
    path: "contact-us",
    name: "ContactUsBackView",
    component: () => import("@/views/BackOffice/Contact/ContactUsView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "contact-us/:id",
    name: "detailsContactUs",
    component: () =>
      import("@/views/BackOffice/Contact/DetailContactUsView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];
