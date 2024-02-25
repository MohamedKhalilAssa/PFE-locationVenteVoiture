<template >
    <nav
        class="bg-white border border-gray-200 px-2 py-2 rounded shadow-lg flex justify-between items-center w-full h-20 sticky top-0 z-40 lg:px-8">
        <router-link to="/" class="inline-block w-min">
            <div class="brand h-full w-48 flex max-h-20 items-baseline mb-2 overflow-hidden">
                <img src="../assets/images/LogoPNGCroppedR.png" alt="logo" class="h-full w-full object-cover" />
            </div>
        </router-link>
        <div class="links hidden space-x-4 md:flex">
            <router-link class="link hover:font-bold duration-100" to="/">Home</router-link>
            <router-link class="link hover:font-bold duration-100" to="/neuf">Neuf</router-link>
            <router-link class="link hover:font-bold duration-100" to="/neuf">Occasion</router-link>
            <router-link class="link hover:font-bold duration-100" to="/neuf">Location</router-link>
        </div>
        <div class="btns hidden md:block">
            <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-600">Ajouter une annonce</button>
        </div>
        <div id="menuToggle" class="block md:hidden" @click="toggleMenu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div
            class="linksMenu flex flex-col items-center space-y-5 py-6 absolute left-0 top-20 w-full h-screen z-30 bg-white md:hidden ">
            <router-link class="link max-w-min hover:font-bold duration-100" to="/">Home</router-link>
            <router-link class="link max-w-min hover:font-bold duration-100" to="/neuf">Neuf</router-link>
            <router-link class="link max-w-min hover:font-bold duration-100" to="/neuf">Occasion</router-link>
            <router-link class="link max-w-min hover:font-bold duration-100" to="/neuf">Location</router-link>
            <div class="btns ">
                <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-600">Ajouter une annonce</button>
            </div>
        </div>
    </nav>
</template>
<script setup>
// handle hamburger menu 
const toggleMenu = (e) => {
    document.getElementById("menuToggle").classList.toggle("active");
    document.querySelector(".linksMenu").classList.toggle("show");
}
</script>
<style scoped>
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    right: 0;
    position: absolute;
    min-width: 300px;
    background-color: #f9f9f9;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    padding: 12px 16px;
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* link */
.link {
    font-size: 1.2rem;
}

/* when a link is active */
.router-link-exact-active {
    font-weight: bold;
}

#menuToggle {
    position: relative;
    cursor: pointer;
    z-index: 1;
    -webkit-user-select: none;
    user-select: none;
}

#menuToggle span {
    display: block;
    width: 33px;
    height: 4px;
    margin-bottom: 5px;
    position: relative;

    background: #232323;
    border-radius: 3px;

    z-index: 1;

    transform-origin: 4px 0px;

    transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0),
        background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0),
        opacity 0.55s ease;
}

#menuToggle span:first-child {
    transform-origin: 0% 0%;
}

#menuToggle span:nth-last-child(2) {
    transform-origin: 0% 100%;
}

#menuToggle.active span {
    opacity: 1;
    transform: rotate(-45deg) translate(-2px, -1px);
    background: #232323;
}

#menuToggle.active span:nth-last-child(3) {
    opacity: 0;
    transform: rotate(0deg) scale(0.2, 0.2);
}


#menuToggle.active span:nth-child(2) {
    transform: rotate(45deg) translate(-8px, -7px);
}

/* show the menu */
.linksMenu {
    left: 100%;
    transition: all 0.5s ease-in-out;
}

.linksMenu.show {
    left: 0%;
}
</style>