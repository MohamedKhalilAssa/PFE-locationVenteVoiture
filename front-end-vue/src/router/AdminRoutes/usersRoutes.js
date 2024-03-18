export default [
  {
    path: "users",
    name: "usersView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Users/UsersView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "users/ajouter",
    name: "ajouterUser",
    component: () =>
      import("@/views/BackOffice/AdminViews/Users/CreateUsersView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "users/modifier/:id",
    name: "modifierUser",
    component: () =>
      import("@/views/BackOffice/AdminViews/Users/EditUsersView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];
