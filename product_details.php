<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAS - Produits</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/details.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div id="video-container">

        <?php
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
            $select_products->execute([$pid]);
            if($select_products->rowCount() > 0){
            while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <form action="" method="post">
            <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
        </form>
        <video autoplay loop muted>
            <source src="uploaded_videos/<?= $fetch_product['video_01']; ?>" type="video/mp4">
        </video>

        <a id="scroll-btn" href="#pro"></a>

        <?php
            }
        }else{
            echo '<p class="empty"></p>';
        }
        ?>

    </div>

    <section class="vehicles" id="vehicles">
        <br><h1 class="heading"> Chiffres clés </h1>
        <br><br>
        <section class="icons-container">

            <div class="icons">
                <i class="fas fa-rocket"></i>
                <div class="content">
                    <h3>Accélération</h3>
                    <p>3,8 s (0 - 100 km/h)</p>
                </div>
            </div>

            <div class="icons">
                <i class="fas fa-road"></i>
                <div class="content">
                    <h3>Vitesse de pointe</h3>
                    <p>250 km/h</p>
                </div>
            </div>

            <div class="icons">
                <i class="fas fa-bolt"></i>
                <div class="content">
                    <h3>Puissance</h3>
                    <p>400 ch (294 kW)</p>
                </div>
            </div>

        </section>
    </section>

    <div class="icons">
        <br>
        <h1></h1><br><br>
    </div>



    <section class="main-wrapper" id="pro">
        <div class="container">


            <?php
                $pid = $_GET['pid'];
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
                $select_products->execute([$pid]);
                if($select_products->rowCount() > 0){
                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                <div class="product-div">
                    <!-- ========== Left ========== -->
                    <div class="product-div-left">
                        <div class="img-container">
                            <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                        </div>
                        <div class="hover-container">
                            <div><img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt=""></div>
                            <div><img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt=""></div>
                            <div><img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt=""></div>
                        </div>
                    </div>
                    <!-- ========== Right ========== -->
                    <div class="product-div-right">
                        <span class="product-name"><?= $fetch_product['name']; ?></span>
                        <span class="product-price"><?= $fetch_product['price']; ?> €</span>
                        <div class="product-rating">
                            <span><i class="fas fa-star"></i></span>
                            <span><i class="fas fa-star"></i></span>
                            <span><i class="fas fa-star"></i></span>
                            <span><i class="fas fa-star"></i></span>
                            <span><i class="fas fa-star-half-alt"></i></span>
                            <span>4.8</span>
                        </div>
                        <p class="product-description"><?= $fetch_product['details']; ?></p>
                        <div class="btn-groups">
                            <input type="submit" value="Ajouter au panier" class="add-cart-btn" name="add_to_cart">
                            <input type="submit" value="Ajouter aux favoris" class="add-wish-btn"
                                name="add_to_wishlist">
                        </div>
                    </div>
                </div>
            </form>
            <?php
            }
            }else{
            echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>
    </section>



    <section class="vehicles" id="vehicles">

        <h1 class="heading"> Voitures <span>Similaires</span></h1>

        <div class="swiper vehicles-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="images/bmw-2021-ix.png" alt="">
                    <div class="content">
                        <h3>BMW iX</h3>
                        <div class="price"><span>Prix: </span>84 200 €</div>
                        <p>
                            <span class="fas fa-circle"></span>1199 - 1598 cm3
                            <span class="fas fa-circle"></span>6.5 - 1.2 l/100 Km
                            <span class="fas fa-circle"></span>A - B
                        </p>
                        <a href="quick_view.php" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/bmw-serie-4-coupe.png" alt="">
                    <div class="content">
                        <h3>BMW Série 4 Coupé</h3>
                        <div class="price"><span>Prix: </span>53 750 €</div>
                        <p>
                            <span class="fas fa-circle"></span>7.5 - 4.6 l/100 Km
                            <span class="fas fa-circle"></span>E - B
                            <span class="fas fa-circle"></span>88 - 94 Km
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/ford-puma.png" alt="">
                    <div class="content">
                        <h3>Ford Puma</h3>
                        <div class="price"><span>Prix: </span>29 790 €</div>
                        <p>
                            <span class="fas fa-circle"></span>7.2 - 1 l/100 Km
                            <span class="fas fa-circle"></span>60 - 67 Km
                            <span class="fas fa-circle"></span>E - A
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/peugeot-508.png" alt="">
                    <div class="content">
                        <h3>Peugeot 508</h3>
                        <div class="price"><span>Prix: </span>43 420 €</div>
                        <p>
                            <span class="fas fa-circle"></span>6.2 - 1.1 l/100 Km
                            <span class="fas fa-circle"></span>58 - 62 Km
                            <span class="fas fa-circle"></span>C - A
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/hyundai-tucson.png" alt="">
                    <div class="content">
                        <h3>Hyundai TUCSON</h3>
                        <div class="price"><span>Prix: </span>30 700 €</div>
                        <p>
                            <span class="fas fa-circle"></span>6.5 - 4.9 l/100 Km
                            <span class="fas fa-circle"></span>48 - 58 Km
                            <span class="fas fa-circle"></span>D - C
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/kia-ceed.png" alt="">
                    <div class="content">
                        <h3>KIA Ceed</h3>
                        <div class="price"><span>Prix: </span>24 440 €</div>
                        <p>
                            <span class="fas fa-circle"></span>5.9 - 4.5 l/100 Km
                            <span class="fas fa-circle"></span>C - B
                            <span class="fas fa-circle"></span>GT-Line
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/nissan-qashqai.png" alt="">
                    <div class="content">
                        <h3>Nissan Qashqai</h3>
                        <div class="price"><span>Prix: </span>31 650 €</div>
                        <p>
                            <span class="fas fa-circle"></span>7 - 5.3 l/100 Km
                            <span class="fas fa-circle"></span>60 - 69 Km
                            <span class="fas fa-circle"></span>D - B
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img src="images/vw-arteon.png" alt="">
                    <div class="content">
                        <h3>Volkswagen Arteon</h3>
                        <div class="price"><span>Prix: </span>58 590 €</div>
                        <p>
                            <span class="fas fa-circle"></span>9.1 - 1.1 l/100 Km
                            <span class="fas fa-circle"></span>15.1 - 15 KWh/100 Km
                            <span class="fas fa-circle"></span>F - A
                        </p>
                        <a href="#" class="btn">En savoir plus</a>
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!--? Contact section starts -->

    <section class="contact" id="contact">

        <h1 class="heading"><span>Contactez</span> nous </h1>

        <div class="row">

            <iframe class="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10492.94827899698!2d2.276672539233441!3d48.891818968650654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66f65519599ab%3A0x648913b6b58c1316!2sIMIE%20Paris!5e0!3m2!1sfr!2sfr!4v1678918501953!5m2!1sfr!2sfr"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <form action="">
                <h3>Prendre contact</h3>
                <input type="text" placeholder="Nom" class="box">
                <input type="email" placeholder="Email" class="box">
                <input type="phone" placeholder="Numéro de téléphone" class="box">
                <textarea placeholder="Message" class="box" cols="30" rows="10"></textarea>
                <input type="submit" value="Envoyer" class="btn">
            </form>

        </div>

    </section>

    <!--? Contact section ends -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <?php include 'components/footer.php'; ?>
    <script src="./js/script.js"></script>
</body>

</html>