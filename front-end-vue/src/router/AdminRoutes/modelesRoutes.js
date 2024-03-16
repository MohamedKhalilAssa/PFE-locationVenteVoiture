export default [
  {
    path: "modeles",
    name: "modelesView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Modeles/ModelesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "modeles/ajouter",
    name: "ajouterModele",
    component: () =>
      import("@/views/BackOffice/AdminViews/Modeles/CreateModelesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "modeles/modifier/:id",
    name: "modifierModele",
    component: () =>
      import("@/views/BackOffice/AdminViews/Modeles/EditModelesView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];
