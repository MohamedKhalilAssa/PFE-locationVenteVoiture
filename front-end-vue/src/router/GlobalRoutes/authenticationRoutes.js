export default [
  {
    path: "/register",
    name: "Register",
    component: () => import("@/views/FrontOffice/Users/RegisterView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("@/views/FrontOffice/Users/LoginView.vue"),
    meta: { requiresGuest: true },
  },
];
