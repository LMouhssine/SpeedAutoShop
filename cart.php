<?php
//? Inclure le fichier "connect.php", qui contient le code de connexion à la base de données
include 'components/connect.php';

// Démarrer la session
session_start();

//! Vérifier si la variable de session 'user_id' est définie
if(isset($_SESSION['user_id'])){
   //! Si elle est définie, sa valeur est affectée à la variable "$user_id"
   $user_id = $_SESSION['user_id'];
}else{
   //! Si ce n'est pas le cas, une chaîne vide est attribuée à la variable "$user_id"
   $user_id = '';
   //? Rediriger l'utilisateur vers 'home.php' pour la connexion
   header('location:home.php');
}

//! Vérifier si le formulaire de suppression a été soumis
if(isset($_POST['delete'])){
   //! Récupère le 'cart_id' de la soumission du formulaire
   $cart_id = $_POST['cart_id'];
   //! Préparer et exécuter une requête DELETE pour supprimer l'article spécifique du panier
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

//! Vérifier si le paramètre "delete_all" est présent dans l'URL
if(isset($_GET['delete_all'])){
   //! Préparer et exécuter une requête DELETE pour supprimer tous les articles du panier de l'utilisateur
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   //? Rediriger l'utilisateur vers 'cart.php' après avoir supprimé tous les articles
   header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mon panier</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/details.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<br><br><br><br>
<section class="products shopping-cart">
   <br><br><h3 class="heading">Mon panier</h3>
   <div class="cart-box">
   <?php
      $grand_total = 0;
      //! Préparer et exécuter une requête SELECT pour récupérer les articles du panier de l'utilisateur
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <a href="product_details.php?pid=<?= $fetch_cart['pid']; ?>"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt=""><br>
      <div class="name"><?= $fetch_cart['name']; ?></div><br>
      <div class="flex">
         <div class="price"><?= $fetch_cart['price']; ?> €</div>
      </div>
      <div class="sub-total"> Sous total : <span><?= $sub_total = ($fetch_cart['price']); ?> €</span> </div>
      <input type="submit" value="Supprimer le produit" onclick="return confirm('Supprimer ce produit du panier ?');" class="cart-delete-btn" name="delete">
   </form>
   <?php
   $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">Votre panier est vide !</p>';
   }
   ?>
   </div>
   <div class="cart-total">
      <p> Grand total : <span><?= $grand_total; ?> €</span></p>
      <a href="shop.php" class="option-btn">Revenir à l'accueil</a>
      <a href="cart.php?delete_all" class="cart-delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Supprimer tous les articles du panier ?');">Tout supprimer</a>
      <a href="checkout.php" class="check-out-btn <?= ($grand_total > 1)?'':'disabled'; ?>">Procéder au paiement</a>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
