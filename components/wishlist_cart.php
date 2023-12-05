<?php

if(isset($_POST['add_to_wishlist'])){

   //! Vérifier si l'utilisateur est connecté
   if($user_id == ''){
      header('location:home.php'); //? Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
   }else{

      //! Obtenir les détails du produit à partir des données du formulaire et assainir (sécuriser) les valeurs 'pid', 'name', 'price', et 'image' en supprimant les balises HTML et les caractères spéciaux
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      //? Le but de l'assainissement des données est d'empêcher toute vulnérabilité de sécurité potentielle, telle que les attaques de script intersite (XSS)

      // Vérifier si le produit existe déjà dans la liste de favoris de l'utilisateur
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      // Vérifier si le produit existe déjà dans le panier de l'utilisateur
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // Si le produit existe déjà dans la liste de favoris, un message s'affiche
      if($check_wishlist_numbers->rowCount() > 0){
         $msg[] = 'Ce produit existe déjà dans les favoris !';
         echo '
         <script>
            window.addEventListener("DOMContentLoaded", function() {
               swal({
                  text: "' . $msg[0] . '",
                  icon: "info"
               });
            });
         </script>
         ';
      }
      // Si le produit existe déjà dans le panier, un message s'affiche
      elseif($check_cart_numbers->rowCount() > 0){
         $msg[] = 'Ce produit existe déjà dans le panier !';
         echo '
         <script>
            window.addEventListener("DOMContentLoaded", function() {
               swal({
                  text: "' . $msg[0] . '",
                  icon: "info"
               });
            });
         </script>
         ';
      }
      // Sinon, ajouter le produit à la liste des favoris
      else{
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $msg[] = 'Le produit a bien été ajouté aux favoris !';
         echo '
         <script>
            window.addEventListener("DOMContentLoaded", function() {
               swal({
                  text: "' . $msg[0] . '",
                  icon: "success"
               });
            });
         </script>
         ';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   // Vérifier si l'utilisateur est connecté
   if($user_id == ''){
      header('location:home.php'); // Redirection vers la page d'accueil si l'utilisateur n'est pas connecté
   }else{

      //? Obtenir les détails du produit à partir des données du formulaire et les assainir
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      // Vérifier si le produit existe déjà dans le panier de l'utilisateur
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // Si le produit existe déjà dans le panier, afficher un message
      if($check_cart_numbers->rowCount() > 0){
         $msg[] = "Ce produit existe déjà dans le panier !";
         echo '
         <script>
            window.addEventListener("DOMContentLoaded", function() {
               swal({
                  text: "' . $msg[0] . '",
                  icon: "info"
               });
            });
         </script>
         ';
      }
      else{

         // Vérifier si le produit existe déjà dans la liste des favoris de l'utilisateur
         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $user_id]);

         // Si le produit existe dans la liste des favoris, supprimez-le avant de l'ajouter au panier
         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $user_id]);
         }

         // Ajouter le produit au panier
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $image]);
         $msg[] = 'Le produit a bien été ajouté au panier !';
         echo '
         <script>
            window.addEventListener("DOMContentLoaded", function() {
               swal({
                  text: "' . $msg[0] . '",
                  icon: "success"
               });
            });
         </script>
         ';
      }

   }

}

?>
