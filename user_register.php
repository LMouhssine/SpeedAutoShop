<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $regex = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{8,12}$/";

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $msg[] = 'L\'adresse électronique que vous avez fournie est déjà liée à un compte existant !';
      echo '
      <script>
         window.addEventListener("DOMContentLoaded", function() {
            swal({
               text: "' . $msg[0] . '",
               icon: "warning"
            });
         });
      </script>
      ';
      }else if (!preg_match($regex, $_POST["pass"])) {
         $msg[] = 'Mot de passe au mauvais format !';
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
      }else{
         if($pass != $cpass){
            $msg[] = 'Veuillez confirmer votre mot de passe';
            echo '
            <script>
               window.addEventListener("DOMContentLoaded", function() {
                  swal({
                     text: "' . $msg[0] . '",
                     icon: "warning"
                  });
               });
            </script>
            ';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $msg[] = 'Inscription terminée avec succès, veuillez vous connecter maintenant !';
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

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inscription</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="register-container">

   <form action="" method="post" class="register">
      <h3>Inscription</h3>
      <input type="text" name="name" required placeholder="Nom d'utilisateur" maxlength="20"  class="register-box">
      <input type="email" name="email" required placeholder="Email" maxlength="50"  class="register-box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Mot de passe" maxlength="20"  class="register-box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirmer le mot de passe" maxlength="20"  class="register-box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="S'inscrire" class="register-btn" name="submit">
      <p>Déjà client ? <a href="home.php" class="log-btn">Connectez-vous ici</a></p>
      
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>