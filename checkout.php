<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
};

if(isset($_POST['order'])){
    //! Récupérer les valeurs d'entrée de l'utilisateur et les assainir
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    //! Vérifier si l'utilisateur a des articles dans son panier
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){
        //! Insérer les détails de la commande dans la table `orders`
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

        //! Vider le panier de l'utilisateur après avoir passé la commande
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        $msg[] = 'Commande passée avec succès !'; //? Message de succès
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
    } else {
        $message[] = 'Votre panier est vide !'; //? Message de panier vide
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

   <!-- SweetAlert CDN -->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<br><br><br><br><br><br>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Vos commandes</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         //! Sélectionner les articles du panier pour l'utilisateur
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               //! Accumuler les articles du panier et calculer le total général
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].'  '.'€) - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span><?= ':'.' '.$fetch_cart['price'].' €'; ?></span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">Votre panier est vide !</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div><p> Grand total : <span><?= $grand_total; ?> €</span></p></div><br>
      </div>

      <h3>Passer vos commandes</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Nom :</span>
            <input type="text" name="name" placeholder="Ex. Mouhssine Lakhili" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Numéro de tél :</span>
            <input type="number" name="number" placeholder="Ex. 06 36 40 90 62" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" placeholder="Ex. mouhssine.lakhili@yahoo.com" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Mode de paiement :</span>
            <select name="method" class="box" required>
               <option value="Paiement à réception">Paiement à réception</option>
               <option value="Carte de crédit">Carte de crédit</option>
               <option value="GoCardless">GoCardless</option>
               <option value="Paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Adresse Postale :</span>
            <input type="text" name="flat" placeholder="Ex. 3 All. du Théâtre" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Complément d'adresse :</span>
            <input type="text" name="street" placeholder="Ex. Résidence Jean-Baptiste Lamarck" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Ville :</span>
            <input type="text" name="city" placeholder="Ex. Élancourt" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Région :</span>
            <input type="text" name="state" placeholder="Ex. Île-de-France" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Pays :</span>
            <input type="text" name="country" placeholder="Ex. France" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Code Postal :</span>
            <input type="number" min="0" name="pin_code" placeholder="Ex. 78990" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="option-btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Finaliser la commande">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
