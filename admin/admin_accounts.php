<?php

include '../components/connect.php';  //? Inclure le fichier qui établit la connexion à la base de données

session_start();  //? Démarrer la session pour maintenir l'état de connexion de l'utilisateur

$admin_id = $_SESSION['admin_id'];  //! Récupérer l'identifiant de l'administrateur dans la session

if (!isset($admin_id)) {
   header('location:admin_login.php');  //! Redirection vers la page de connexion de l'admin s'il n'est pas connecté
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');  //? Supprimer le compte administrateur sur la base de l'ID fourni et rediriger vers la page des comptes admins
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Comptes admins</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>  <!-- Inclure le fichier du header de l'admin -->

   <section class="accounts">

      <h1 class="heading">Comptes admins</h1>

      <div class="box-container">

         <div class="box">
            <p>Ajouter un nouvel admin</p>
            <a href="register_admin.php" class="option-btn">Inscrire</a>  <!-- Link to register a new admin -->
         </div>

         <?php
         $select_accounts = $conn->prepare("SELECT * FROM `admins`");
         $select_accounts->execute();
         if ($select_accounts->rowCount() > 0) {
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <p> Admin ID : <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> Nom de l'admin : <span><?= $fetch_accounts['name']; ?></span> </p>
                  <div class="flex-btn">
                     <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Supprimer ce compte ?')" class="delete-btn">Supprimer</a>  <!-- Supprimer le lien du compte admin -->
                     <?php
                     if ($fetch_accounts['id'] == $admin_id) {
                        echo '<a href="update_profile.php" class="option-btn">Modifier</a>';  // Lien pour mettre à jour le profil de l'admin s'il s'agit de l'admin actuel
                     }
                     ?>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">Pas de comptes disponibles !</p>';  // Affichage d'un message si aucun compte d'admin n'est disponible
         }
         ?>

      </div>

   </section>

   <script src="../js/admin_script.js"></script>  <!-- Inclure le fichier script de l'admin -->

</body>

</html>
