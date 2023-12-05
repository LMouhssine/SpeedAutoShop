<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){
   //! Récupérer les données des formulaires et assainir les inputs
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   //! Vérifier si le même message a déjà été envoyé
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'Message déjà envoyé';
      echo '
      <script>
         window.addEventListener("DOMContentLoaded", function() {
            swal({
               text: "' . $message[0] . '",
               icon: "info"
            });
         });
      </script>
      ';
   }else{
      //! Si le message est unique, il est inséré dans la base de données
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Message envoyé avec succès !';
      echo '
      <script>
         window.addEventListener("DOMContentLoaded", function() {
            swal({
               text: "' . $message[0] . '",
               icon: "success"
            });
         });
      </script>
      ';
   }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

   <!-- SweetAlert CDN -->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

    <!-- Contact section starts -->
    <br><br><br><br><br>

    <section class="contact" id="contact">

        <h1 class="heading"><span>Contactez</span> nous </h1>

        <div class="row">

            <!-- Google Maps iframe -->
            <iframe class="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10492.94827899698!2d2.276672539233441!3d48.891818968650654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66f65519599ab%3A0x648913b6b58c1316!2sIMIE%20Paris!5e0!3m2!1sfr!2sfr!4v1678918501953!5m2!1sfr!2sfr"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <!-- Contact form -->
            <form action="" method="post">
                <h3>Prendre contact</h3>
                <input type="text" name="name" placeholder="Nom" required maxlength="20" class="box">
                <input type="email" name="email" placeholder="Email" required maxlength="50" class="box">
                <input type="number" name="number" min="0" max="9999999999" placeholder="Numéro de téléphone" required onkeypress="if(this.value.length == 10) return false;" class="box">
                <textarea name="msg" placeholder="Message" class="box" cols="30" rows="10"></textarea>
                <input type="submit" value="Envoyer" name="send" class="btn">
            </form>

        </div>

    </section>

    <!-- Contact section ends -->

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
