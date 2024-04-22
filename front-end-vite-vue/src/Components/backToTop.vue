<template>
  <button @click="scrollToTop" class="back-to-top">
    <i class="fas fa-angle-up"></i>
  </button>
</template>
<!-- <style scoped src="@/assets/css/backToTop.css"></style>
 -->
<style scoped>
.back-to-top {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(239, 68, 68, 0.6);
  color: #fff;
  border: none;
  outline: none;
  cursor: pointer;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  z-index: 9999;
  overflow: hidden;
}
.back-to-top:hover {
  background-color: rgb(220 38 38);
}
.back-to-top:hover i {
  animation: hoveringUp 0.9s ease-in-out infinite;
}
.back-to-top.show {
  display: flex;
}
@media screen and (max-width: 768px) {
  .back-to-top:hover i {
    animation: none;
  }
}

@keyframes hoveringUp {
  from {
    transform: translateY(29px);
  }
  to {
    transform: translateY(-25px);
  }
}
</style>
<script setup>
window.addEventListener("scroll", function () {
  if (window.scrollY > 100) {
    document.querySelector(".back-to-top").classList.add("show");
  } else {
    document.querySelector(".back-to-top").classList.remove("show");
  }
});
const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};
</script>
