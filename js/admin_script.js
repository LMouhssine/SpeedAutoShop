let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

//! Basculer la classe "active" pour la barre de navigation et la retirer du profil lorsque le bouton du menu est cliqué
document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

//! Désactiver la classe "active" pour le profil et le retirer de la barre de navigation lorsque l'utilisateur clique sur le bouton
document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

//! Supprimer la classe "active" de la barre de navigation et du profil lorsque la fenêtre est scrollée
window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

subImages.forEach(images =>{
   //! Modifier la source (src) de l'image principale lorsqu'une sous-image est cliquée
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});
