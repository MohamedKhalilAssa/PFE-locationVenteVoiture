export default [
  {
    path: "logs",
    name: "logsView",
    component: () => import("@/views/BackOffice/AdminViews/Logs/logsView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "logs/details/:id",
    name: "detailsLogs",
    component: () =>
      import("@/views/BackOffice/AdminViews/Logs/DetailLogsView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
  //   {
  //     path: "couleurs/ajouter",
  //     name: "ajouterCouleur",
  //     component: () =>
  //       import(
  //         "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/CreateCouleursView.vue"
  //       ),
  //     meta: { requiresAuth: true, requiresAdmin: true },
  //   },
  //   {
  //     path: "couleurs/details/:id",
  //     name: "detailsCouleur",
  //     component: () =>
  //       import(
  //         "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/DetailCouleursView.vue"
  //       ),
  //     meta: { requiresAuth: true, requiresAdmin: true },
  //     props: true,
  //   },
  //   {
  //     path: "couleurs/modifier/:id",
  //     name: "modifierCouleur",
  //     component: () =>
  //       import(
  //         "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/EditCouleursView.vue"
  //       ),
  //     meta: { requiresAuth: true, requiresAdmin: true },
  //     props: true,
  //   },
];
