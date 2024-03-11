export default [
  {
    path: "marques",
    name: "marquesView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Marques/MarquesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "marques/ajouter",
    name: "ajouterMarque",
    component: () =>
      import("@/views/BackOffice/AdminViews/Marques/CreateMarquesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "marques/modifier/:id",
    name: "modifierMarque",
    component: () =>
      import("@/views/BackOffice/AdminViews/Marques/EditMarquesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];
