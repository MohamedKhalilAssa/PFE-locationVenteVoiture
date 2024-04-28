// set a form made from vmodels
const setForm = (form, data) => {
  for (const [key, value] of Object.entries(form.value)) {
    try {
      form.value[key] = JSON.parse(data[key]);
    } catch (error) {
      form.value[key] = data[key];
    }
  }
};
// set a formData object which will be used for the request
const setFormData = (form, except = []) => {
  let formData = new FormData();
  for (const [key, value] of Object.entries(form.value)) {
    if (!except.includes(key)) formData.append(key, value);
  }
  return formData;
};
export { setForm, setFormData };
