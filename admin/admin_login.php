<?php

include '../components/connect.php';  //? Inclure le fichier qui établit la connexion à la base de données

session_start();  //? Démarrer la session pour maintenir l'état de connexion de l'utilisateur

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   //! Préparer et exécuter une requête pour sélectionner un admin avec le nom et le mot de passe fournis
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);

   //! Récupérer le résultat de la requête
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');  //! Redirection vers le tableau de bord en cas de connexion réussie
   } else {
      $message[] = "Nom d'utilisateur ou mot de passe incorrect !";  //! Affichage d'un message d'erreur en cas d'échec de la connexion
   }

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Connexion</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';  //? Affichage d'un message d'erreur et d'un bouton de fermeture
      }
   }
   ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>Admins</h3>
         <input type="text" name="name" required placeholder="Nom d'utilisateur" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="Mot de passe" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Se connecter" class="btn" name="submit">
      </form>

   </section>

</body>
</html>
