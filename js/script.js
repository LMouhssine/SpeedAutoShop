//! ================ Nav-bar & Menu-btn ================

let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.navbar');

//? Alterner la classe "fa-times" pour le bouton de menu et la classe "active" pour la barre de navigation lorsque le bouton de menu est cliqué
menu.onclick = () => {
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
}

//? Basculer la classe "active" pour le profil lorsque l'on clique sur le bouton de connexion
document.querySelector('#login-btn').onclick = () => {
    document.querySelector('.profile').classList.toggle('active');
}

//? Basculer la classe "active" du profil lorsque l'on clique sur le bouton de fermeture du formulaire de connexion
document.querySelector('#close-login-form').onclick = () => {
    document.querySelector('.profile').classList.toggle('active');
}

//? Ajouter ou supprimer la classe "active" pour le header en fonction de la position de défilement
window.onscroll = () => {
    if (window.scrollY > 0) {
        document.querySelector('.header').classList.add('active');
    } else {
        document.querySelector('.header').classList.remove('active');
    }

    //? Supprimer la classe "fa-times" du bouton de menu et la classe "active" de la barre de navigation lors du défilement
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
}

//? Ajouter ou supprimer la classe "active" pour le header lorsque la fenêtre a fini de se charger
window.onload = () => {
    if (window.scrollY > 0) {
        document.querySelector('.header').classList.add('active');
    } else {
        document.querySelector('.header').classList.remove('active');
    }
}

//! ================ Swiper ================

//? Initialiser le Swiper pour "vehicles-slider"
var swiper = new Swiper(".vehicles-slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    centeredSlides: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        991: {
            slidesPerView: 3,
        },
    },
});

//? Initialiser le Swiper pour "super-cars-slider"
var swiper = new Swiper(".super-cars-slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    centeredSlides: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        991: {
            slidesPerView: 3,
        },
    },
});

//! ================ Product details ================

const allHoverImages = document.querySelectorAll('.hover-container div img');
const imgContainer = document.querySelector('.img-container');

//? Ajouter la classe 'active' au parent de la première image survolée lorsque le DOM est chargé
window.addEventListener('DOMContentLoaded', () => {
  allHoverImages[0].parentElement.classList.add('active');
});

//? Ajouter des récepteurs d'événements à chaque image survolée
allHoverImages.forEach((image) => {
  image.addEventListener('mouseover', () => {
    //? Mise à jour de la source (src) de l'image dans le conteneur d'images
    imgContainer.querySelector('img').src = image.src;
    resetActiveImg(); //? Réinitialiser la classe "active" pour tous les parents d'images survolées
    image.parentElement.classList.add('active'); //? Ajouter la classe "active" au parent de l'image survolée
  });
});

//? Fonction permettant de réinitialiser la classe "active" pour tous les parents des images survolées
function resetActiveImg() {
  allHoverImages.forEach((img) => {
    img.parentElement.classList.remove('active');
  });
}
