<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mes favoris</title>
   
   <!-- font awesome cdn link  -->

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->

   <link rel="stylesheet" href="css/details.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <br><br><br><br><br><h3 class="heading">Mes favoris</h3>

   <div class="cart-box">

   <?php
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $grand_total += $fetch_wishlist['price'];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
      <a href="product_details.php?pid=<?= $fetch_wishlist['pid']; ?>" ></a>
      <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt=""><br>
      <div class="name"><?= $fetch_wishlist['name']; ?></div><br>
      <div class="flex">
         <div class="price"><?= $fetch_wishlist['price']; ?> €</div><br>
      </div>
      <input type="submit" value="Ajouter au panier" class="option-btn" name="add_to_cart">
      <input type="submit" value="Supprimer le produit" onclick="return confirm('Supprimer ce produit des favoris ?');" class="cart-delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Votre liste des favoris est vide !</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p> Grand total : <span><?= $grand_total; ?> €</span></p>
      <a href="shop.php" class="option-btn">Revenir à l'accueil</a>
      <a href="wishlist.php?delete_all" class="cart-delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Supprimer tous les articles du favoris ?');">Tout supprimer</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>