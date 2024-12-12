<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
      
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
   html{
      font-size: 67.5%;
   }
   .checkout{
   display: flex;
   flex-direction: row;
   align-items: center;
   justify-content: space-between;

   }
   .checkout form{
   max-width: 50rem;
   margin:0 auto;
   padding:2rem;
}

.checkout form h3{
   font-size: 2.5rem;
   text-transform: capitalize;
   padding: 2rem 0;
   color:var(--black);
}

.checkout .cart-items{
   display: flex;
   flex-direction: column;
   align-items: center;
   justify-content: space-evenly;
   background-color: var(--black);
   padding:2rem;
   padding-top: 0;
   height: 400px;
   width: 350px;
}

.checkout .cart-items h3{
   color:var(--white);
}

.checkout .cart-items p{
   display: flex;
   align-items: center;
   gap:1.5rem;
   justify-content: space-between;
   margin:1rem 0;
   line-height: 1.5;
   font-size: 2rem;
}

.checkout .cart-items p .name{
   color:var(--light-color);
}

.checkout .cart-items p .price{
   color:var(--yellow);
}

.checkout .cart-items .grand-total{
   background-color: var(--white);
   padding:.5rem 1.5rem;
}

.checkout .cart-items .grand-total .price{
   color:var(--red);
}

.checkout form .user-info p{ 
   font-size: 2rem;
   line-height: 1.5;
   padding:1rem 0;
}

.checkout form .user-info p i{
   color:var(--light-color);
   margin-right: 1rem;
}

.checkout form .user-info p span{
   color:var(--black);
}

.checkout form .user-info .box{
   width: 100%;
   border:var(--border);
   padding:1.4rem;
   margin-top: 2rem;
   margin-bottom: 1rem;
   font-size: 1.8rem;
}
.checkout form .user-info{
   height: 400px;
   width: 350px;
}
.checkout .user-info2{
   height: 400px;
   width: 350px;
   border:var(--border);
   padding:1.4rem;
   margin-top: 2rem;
   margin-bottom: 1rem;
   font-size: 1.8rem;
}

.checkout .user-info2 p{ 
   font-size: 2rem;
   line-height: 1.5;
   padding:1rem 0;
}

.checkout .user-info2 p i{
   color:var(--light-color);
   margin-right: 1rem;
}

.checkout .user-info2 p span{
   color:var(--black);
}

.checkout .user-info2 .box{
   width: 100%;
   border:var(--border);
   padding:1.4rem;
   margin-top: 2rem;
   margin-bottom: 1rem;
   font-size: 1.8rem;
}

      html{
         font-size: 90%;
      }
      .title{
         font-size: 50px;
      }
      .heading{
         display: flex;
         align-items: center;
         justify-content: center;
         gap:1rem;
         flex-flow: column;
         background-color: #2B3035;
         min-height: 8rem;
}
      .heading h3{
         font-size: 3rem;
         color:var(--white);
         text-transform: capitalize;
}

      .heading p{
         font-size: 1.3rem;
         color:var(--light-color);
      }


   </style>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

<div class="cart-items">
      <h3>Cart Items</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">$<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">grand total :</span><span class="price">$<?= $grand_total; ?></span></p>
      <a href="cart.php" class="btn">veiw cart</a>
   </div>
   <?php  
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$user_id]);
         $fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);
      ?>
<form action="" method="post" id="myForm">

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info2">   
      <h3>delivery address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="cash on delivery">cash on delivery</option>
         <option value="credit card">credit card</option>
         <option value="paytm">paytm</option>
         <option value="paypal">paypal</option>
      </select>
      <input type="submit" value="place order" onclick="submitForm()" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>

<div class="user-info2">
         <h3>your info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
         <a href="update_profile.php" class="btn">update info</a>
</div>
   
</section>








<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
   function submitForm(){
      var form = document.getElementById("myForm");
  form.submit();
   }
</script>
</body>
</html>