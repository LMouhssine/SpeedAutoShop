<?php
if (isset($_POST['submit'])) {
   //! Récupérer l'Email et l'assainir
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   //! Récupérer le mot de passe et l'assainir
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   //! Vérifier si l'utilisateur existe avec l'email et le mot de passe donnés
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      //! Si l'utilisateur existe, définir la variable de session user_id et rediriger vers home.php
      $_SESSION['user_id'] = $row['id'];
      header('location: home.php');
   } else {
      //? Si l'utilisateur n'existe pas, afficher un message d'erreur en utilisant la bibliothèque SweetAlert
      $msg[] = "Nom d'utilisateur ou mot de passe incorrect !";

      echo '
      <script>
         window.addEventListener("DOMContentLoaded", function() {
            swal({
               text: "' . $msg[0] . '",
               icon: "error"
            });
         });
      </script>
      ';
   }
}
?>

<!-- Header starts -->
<header class="header">
   <div id="menu-btn" class="fas fa-bars"></div>
   <div id="speed-logo">
      <a href="home.php" class="logo"> <span>Speed</span>AutoShop</a>
      <a href="home.php" class="abr"><span>S</span>AS</a>
   </div>
   <nav class="navbar">
      <a href="home.php">Accueil</a>
      <a href="orders.php">Mes Commandes</a>
      <a href="about.php">À Propos</a>
      <a href="contact.php">Contact</a>
   </nav>
   <div class="icons">
      <?php
      //? Compter le nombre d'articles dans la liste des favoris de l'utilisateur actuel
      $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $count_wishlist_items->execute([$user_id]);
      $total_wishlist_counts = $count_wishlist_items->rowCount();

      //? Compte le nombre d'articles dans le panier de l'utilisateur actuel
      $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $count_cart_items->execute([$user_id]);
      $total_cart_counts = $count_cart_items->rowCount();
      ?>
      <a href="search_page.php"><i class="fas fa-search"></i></a>
      <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
      <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
   </div>
   <div id="login-btn">
      <button class="btn">Connexion</button>
      <i class="far fa-user"></i>
   </div>
</header>
<!-- Header ends -->

<!-- Login form -->
<div class="profile">
   <span class="fas fa-times" id="close-login-form"></span>
   <form action="" method="post">
      <?php          
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_profile->execute([$user_id]);
      if($select_profile->rowCount() > 0){
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3 class="mssg-bnv">Bonjour <span><?= $fetch_profile["name"]; ?></span> !</h3>
      <p class="mssg-bnv">Bienvenue chez <span>Speed</span>AutoShop ! Nous sommes prêts à vous aider à trouver la
         voiture de vos rêves ! Si vous avez besoin d'aide, cliquez simplement sur le bouton <span>"Contact"</span> et
         un professionnel vous répondra dans les meilleurs délais.</p>
      <div class="buttons">
         <a href="contact.php" class="btn">Contact</a>
         <a href="components/user_logout.php" class="btn">Déconnexion</a>
      </div>
      <p>Voulez-vous modifier vos informations ? <a href="update_user.php">Cliquez ici</a></p>
   </form>
   <?php
   }else{
   ?>
   <form action="" method="post">
      <h3>Connexion</h3>
      <input type="email" name="email" required placeholder="Email" maxlength="50" class="box"
         oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Mot de passe" maxlength="20" class="box"
         oninput="this.value = this.value.replace(/\s/g, '')">
      <p>Mot de passe oublié <a href="#">Cliquez ici</a></p>
      <input type="submit" value="Se connecter maintenant" class="btn" name="submit">
      <!-- <p>Ou connectez-vous avec</p>
      <div class="buttons">
         <a href="https://www.google.com/intl/fr/gmail/about/" class="btn">Google</a>
         <a href="https://fr-fr.facebook.com/" class="btn">Facebook</a>
      </div> -->
      <p>Vous n'avez pas de compte <a href="user_register.php">Créer un ici</a></p>
   </form>
   <?php
   }
   ?>
</div>
<!-- Login form ends-->
