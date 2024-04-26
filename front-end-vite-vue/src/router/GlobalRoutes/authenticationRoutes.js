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
  {
    path: "/forgot-password",
    name: "ForgotPassword",
    component: () => import("@/views/FrontOffice/Users/forgotPasswordView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/password-reset/:token",
    name: "ResetPassword",
    component: () => import("@/views/FrontOffice/Users/resetPasswordView.vue"),
    meta: { requiresGuest: true },
    props: true,
  },
  {
    path: "/profile",
    name: "Profile",
    component: () => import("@/views/FrontOffice/Users/ProfileView.vue"),
    meta: { requiresAuth: true },
  },
];
