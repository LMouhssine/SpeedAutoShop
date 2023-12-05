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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>À Propos - SAS</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<br><br><br><br>

<section class="about">
   <div class="row">
      <div class="image">
         <img src="images/about-sas.png" alt="">
      </div>
      <div class="content">
         <h3>Pourquoi nous choisir ?</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam veritatis minus et similique doloribus? Harum molestias tenetur eaque illum quas? Obcaecati nulla in itaque modi magnam ipsa molestiae ullam consequuntur.</p>
         <a href="contact.php" class="btn">Nous contacter</a>
      </div>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
