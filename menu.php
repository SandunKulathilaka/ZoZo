<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menu</title>
   <link rel="icon" href="images/LYgjKqzpQb.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user/menu.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>our menu</h3>
   <p><a href="home.php">home</a> <span> / menu</span></p>
</div>

<!-- menu section starts  -->

<section class="products">

   <h1 style="font-size: 50px;
         text-align: center;">Latest Dishes</h1>

   <main>
      <section class="cards">

         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            if($select_products->rowCount() > 0){
               while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
         ?>
        
            <div class="card">
                  <div class="card__image-container">
                     <img
                     src="uploaded_img/<?= $fetch_products['image']; ?>"
                     />
                  </div>
               <div class="card__content">
                  <p class="card__title text--medium">
                  <?= $fetch_products['description']; ?>
                  </p>
                  <div class="card__info">
                     <p class="text--medium">
                        <?= $fetch_products['name']; ?>
                        <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                     </p>
                     <p class="card__price text--medium">$ <?= $fetch_products['price']; ?></p>
                  </div>
                  <div class="card__info">
                     <p class="text--medium">
                        Add to Cart
                     </p>
                     <p class="card__price2 text--medium">
                     <form id="cartForm" action="" method="post" class="box">
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                        <!-- Button for cart icon -->
                        <button id="cartIcon" type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                     </form>
                     </p>
                  </div>
               </div>
            </div>
         <?php
               }
            }else{
               echo '<p class="empty">no products added yet!</p>';
            }
         ?>
      </section>
   </main>

</section>
<!-- menu section ends -->

























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>