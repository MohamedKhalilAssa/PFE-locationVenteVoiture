const base_url = "URL"; // to be changed if the backend is hosted somewhere else
export default {
  // Users
  user__get_all_or_add: base_url + "/api/users",
  user__paginate: base_url + "/api/users/pagination?page=",
  user__get_or_update_or_delete: base_url + "/api/users/",
  user__get_total: base_url + "/api/users/total",
  user__get_online_admin: base_url + "/api/users/admin/online",
  user__change_password: base_url + "/api/users/change-password",
  users__chatted_with: base_url + "/api/users/get-chat",
  // Marques
  marque__get_all_or_add: base_url + "/api/marque",
  marque__get_or_update_or_delete: base_url + "/api/marque/",
  marque__paginate: base_url + "/api/marque/pagination?page=",
  // Modeles
  modele__get_all_or_add: base_url + "/api/modele",
  modele__get_by_marque: base_url + "/api/modele/marque/",
  modele__get_or_update_or_delete: base_url + "/api/modele/",
  modele__paginate: base_url + "/api/modele/pagination?page=",
  // Couleurs
  couleur__get_all_or_add: base_url + "/api/couleur",
  couleur__get_or_update_or_delete: base_url + "/api/couleur/",
  couleur__paginate: base_url + "/api/couleur/pagination?page=",
  // Villes
  ville__get_all_or_add: base_url + "/api/ville",
  ville__get_or_update_or_delete: base_url + "/api/ville/",
  ville__paginate: base_url + "/api/ville/pagination?page=",
  // annonce
  annonce__get_user_annonces: base_url + "/api/annonce/user-annonces?page=",
  annonce__get_annee_fabrication: base_url + "/api/annonce/annees",
  annonce__get_or_update_or_delete: base_url + "/api/annonce/",
  annonce__show_backOffice: base_url + "/api/annonce/",
  annonce__update_status: base_url + "/api/annonce/status/",
  annonce__update_disponibilite: base_url + "/api/annonce/disponibilite/",
  annonce__get_top_villes: base_url + "/api/annonce/topVilles",
  annonce__get_top_marques: base_url + "/api/annonce/topMarques",
  // occasion
  occasion__add: base_url + "/api/annonce/occasion",
  occasion__get_max_price: base_url + "/api/annonce/occasion/maxPrice",
  occasion__paginate: base_url + "/api/annonce/occasion/pagination?page=",
  occasion__paginate_backOffice:
    base_url + "/api/annonce/occasion/pagination?source=true&page=",
  // location
  location__get_max_price: base_url + "/api/annonce/location/maxPrice",
  location__paginate: base_url + "/api/annonce/location/pagination?page=",
  // traitement
  traitement_location__paginate: base_url + "/api/location/pagination?page=",
  traitement_location__delete: base_url + "/api/location/",
  traitement_location__getByMonth: base_url + "/api/location/byMonth",
  traitement_vente__paginate: base_url + "/api/vente/pagination?page=",
  traitement_vente__delete: base_url + "/api/vente/",
  traitement_vente__getByMonth: base_url + "/api/vente/byMonth",
  // neuf
  neuf__get_max_price: base_url + "/api/annonce/neuf/maxPrice",
  neuf__paginate: base_url + "/api/annonce/neuf/pagination?page=",
  neuf__paginate_backOffice:
    base_url + "/api/annonce/neuf/pagination?source=true&page=",
  // analytics
  analytics__get_visitors: base_url + "/api/analytics/visitors",
  analytics__get_or_update_or_delete: base_url + "/api/analytics/",
  analytics__get_paginate: base_url + "/api/analytics/pagination?page=",
  // chat
  chat__message: base_url + "/api/chat/send",
  chat__get_messages: base_url + "/api/chat/get-messages/",
  chat__get_notif: base_url + "/api/users/get-notif",
  // contact
  contact__store: base_url + "/api/contact-us",
  contact__paginate: base_url + "/api/contact-us/pagination?page=",
  contact__get_or_update_or_delete: base_url + "/api/contact-us/",
  contact__answer: base_url + "/api/contact-us/answer/",
  // general getters
  getStoragePath: base_url + "/storage/",
  // Config Endpoints
  config__get_csrf_token: base_url + "/sanctum/csrf-cookie",
  config__login: base_url + "/login",
  config__logout: base_url + "/logout",
  config__register: base_url + "/register",
  config__send_password_reset_link: base_url + "/forgot-password",
  config__reset_password: base_url + "/reset-password",
  config__get_authenticated_user: base_url + "/api/user",
  config__get_bearer_token: base_url + "/api/user/token",
};

