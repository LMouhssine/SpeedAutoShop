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
    <title>Accueil - Speed Auto Shop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- Font awesome cdn link -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- CSS FIle link -->

    <link rel="stylesheet" href="css/style.css">

    <!-- SweetAlert cdn link -->

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <!--! Home section starts -->

    <section class="home" id="home">
        <br>
        <h1>Accélérez l’avenir avec Speed Auto Shop</h1>
        <img src="images/gt3-klein.png" alt="">
        <a href="#vehicles" class="btn">TROUVEZ VOTRE VOITURE</a>
    </section>

    <!--! Home section ends -->

    <!--? Icons section starts -->

    <section class="icons-container">

        <div class="icons">
            <i class="fas fa-home"></i>
            <div class="content">
                <h3>150+</h3>
                <p>Branches</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-car"></i>
            <div class="content">
                <h3>350+</h3>
                <p>Voitures vendues</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-users"></i>
            <div class="content">
                <h3>260+</h3>
                <p>Des clients satisfaits</p>
            </div>
        </div>

        <div class="icons">
            <i class="fas fa-car"></i>
            <div class="content">
                <h3>650+</h3>
                <p>Nouvelles voitures</p>
            </div>
        </div>

    </section>

    <!--? Icons section ends -->

    <!--! Vehicles section starts -->

    <section class="vehicles" id="vehicles">

        <h1 class="heading"> Voitures <span>Populaires</span></h1>

        <div class="swiper vehicles-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">

                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
                        $select_products->execute();
                        if($select_products->rowCount() > 0){
                        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                    </form>
                    <img src="uploaded_img/<?= $fetch_product['image_04']; ?>" alt="">
                    <div class="content">
                        <h3><?= $fetch_product['name']; ?></h3>
                        <div class="price"><span>Prix : </span><?= $fetch_product['price']; ?> €</div>
                        <div class="line"><span></span></div>
                        <p>
                            <span class="fas fa-circle"></span>1199 - 1598 cm3
                            <span class="fas fa-circle"></span>6.5 - 1.2 l/100 Km
                            <span class="fas fa-circle"></span>A - B
                        </p>
                        <a href="product_details.php?pid=<?= $fetch_product['id']; ?>" class="btn">En savoir plus</a>
                        <br><br><br><br>
                    </div>
                    <?php
                        }
                    }else{
                        echo '<p class="empty">Aucun produit ajouté pour le moment dans cette catégorie !</p>';
                    }
                    ?>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!--! Vehicles section ends -->

    <!--? Services section starts -->

    <section class="services" id="services">

        <h1 class="heading"> Nos <span>services</span></h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-car"></i>
                <h3>Vente de voitures</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-tools"></i>
                <h3>Réparation des pièces</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-car-crash"></i>
                <h3>Assurance automobile</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-car-battery"></i>
                <h3>Batterie</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-gas-pump"></i>
                <h3>Vidange d'huile</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-headset"></i>
                <h3>Assistance 24/7</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-key"></i>
                <h3>Reprise</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

            <div class="box">
                <i class="fas fa-file"></i>
                <h3>Contrôle technique</h3>
                <p>Ce service n'est pas disponible pour le moment.</p>
                <a href="#" class="btn">En savoir plus</a>
            </div>

        </div>

    </section>

    <!--? Services section ends -->

    <!--! Super cars section starts -->

    <!--? Ligne 1 -->

    <section class="super-cars" id="super-cars">

        <h1 class="heading"> Voitures <span>de sport</span></h1>

        <div class="swiper super-cars-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="images/audi-rs-7.png" alt="">
                    <h3>Audi RS 7 Sportback</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">145 850 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/jeep-cherokee.png" alt="">
                    <h3>Jeep Grand Cherokee 4xe PHEV</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">99 500 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/maserati-cielo.png" alt="">
                    <h3>Maserati MC20 Cielo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">266 650 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/lexus-lc.png" alt="">
                    <h3>Lexus LC</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">92 037 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/ferrari-tributo.png" alt="">
                    <h3>Ferrari F8 Tributo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">232 754 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/bmw-ix.png" alt="">
                    <h3>BMW iX</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">84 200 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

        <!--! Ligne 2 -->

        <div class="swiper super-cars-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img src="images/bmw-i4.png" alt="">
                    <h3>BMW i4</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">57 550 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/ford-explorer.png" alt="">
                    <h3>Ford Explorer</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">89 000 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/jaguar-f-type.png" alt="">
                    <h3>Jaguar F-Type Coupé</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">72 400 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/mercedes-benz-classe-g.png" alt="">
                    <h3>Mercedes-Benz Classe G</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">149 650 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/aston-martin-db11.png" alt="">
                    <h3>Aston Martin DB11</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">201 378 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

                <div class="swiper-slide box">
                    <img src="images/land-rover-range.png" alt="">
                    <h3>Land Rover Range Rover</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="price">127 400 €</div>
                    <a href="#" class="btn">En savoir plus</a>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!--! Super cars section ends -->

    <!-- Avis Clients -->

    <section class="vehicles" id="vehicles">

        <h1 class="heading"> Découvrez les avis de nos clients <span>fidèles</span></h1>

        <div class="swiper vehicles-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <img class="portrait" src="images/1.png" alt="">
                    <div class="content">
                        <h3>Ahmed Zakaria</h3>
                        <div class="price"><span>Avis :</span> Satisfait</div>
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic, voluptatum aut velit odio,
                            placeat ratione eligendi quo itaque libero, laborum possimus. Illum accusamus aut magni
                            facere ullam odio explicabo est.
                        </p>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img class="portrait" src="images/2.png" alt="">
                    <div class="content">
                        <h3>Maria Rodriguez</h3>
                        <div class="price"><span>Avis :</span> Très Satisfaite</div>
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maxime quis quisquam quo a
                            necessitatibus ipsam eaque molestiae corrupti sed quidem saepe aperiam sint vero rem
                            incidunt neque hic, repudiandae dignissimos?
                        </p>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img class="portrait" src="images/3.png" alt="">
                    <div class="content">
                        <h3>Lewis Jackson</h3>
                        <div class="price"><span>Avis :</span> Très Satisfait</div>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas quasi quod, animi ea
                            similique eum beatae eius? Quaerat, saepe hic minus magnam rem dicta adipisci aliquid? Eum
                            amet itaque laudantium!
                        </p>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img class="portrait" src="images/4.png" alt="">
                    <div class="content">
                        <h3>Olivia Edwards</h3>
                        <div class="price"><span>Avis :</span> Très Satisfaite</div>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque voluptatem maiores
                            consequuntur tenetur rerum, exercitationem debitis incidunt provident quas ex ad aspernatur
                            magni temporibus officiis architecto iste repellendus, laboriosam distinctio?
                        </p>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img class="portrait" src="images/5.png" alt="">
                    <div class="content">
                        <h3>Javier Hernández</h3>
                        <div class="price"><span>Avis :</span> Satisfait</div>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur harum magni vitae ipsam
                            quam commodi cupiditate tenetur, nam, consequuntur officiis blanditiis illo natus veniam
                            quis possimus consequatur in officia doloribus.
                        </p>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <img class="portrait" src="images/6.png" alt="">
                    <div class="content">
                        <h3>Charlotte Lee</h3>
                        <div class="price"><span>Avis :</span> Satisfaite</div>
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi quaerat eaque recusandae
                            laboriosam animi hic quia officia perferendis libero. Blanditiis saepe repellat sequi vero
                            laborum recusandae amet in molestias et.
                        </p>
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

    <!-- Avis Clients Fin -->

    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- JS File link -->

    <script src="js/script.js"></script>
</body>

</html>