<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <link rel="icon" href="images/LYgjKqzpQb.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
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
   <h3>orders</h3>
   <p><a href="home.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <table class="table table-hover">
  <thead>
    <tr class="table-dark">
      <th scope="col">#</th>
      <th scope="col">Placed On</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Number</th>
      <th scope="col">Address</th>
      <th scope="col">Payment Method</th>
      <th scope="col">Items</th>
      <th scope="col">Total Price</th>
      <th scope="col">Order Status</th>
    </tr>
  </thead>
  <tbody>

   <?php
   $con_num= 0;
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
               $con_num++;
   ?>
    <tr>
      <th scope="row"><?=$con_num?></th>
      <td><?= $fetch_orders['placed_on']; ?></td>
      <td><?= $fetch_orders['name']; ?></td>
      <td><?= $fetch_orders['email']; ?></td>
      <td><?= $fetch_orders['number']; ?></td>
      <td><?= $fetch_orders['address']; ?></td>
      <td><?= $fetch_orders['method']; ?></td>
      <td><?= $fetch_orders['total_products']; ?></td>
      <td>$<?= $fetch_orders['total_price']; ?>/-</td>
      <td><span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span></td>
    </tr>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

</tbody>
</table>

   </div>

</section>



<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>