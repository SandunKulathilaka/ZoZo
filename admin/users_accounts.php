<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_order->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users Accounts</title>
   <link rel="icon" href="images/LYgjKqzpQb.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Bootstrap CSS CDN link -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
    /* Table Styles */
    .accounts {
        padding: 20px;
    }
    .accounts h1{
        color: black;
    }
    .heading {
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    .delete-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #f44336;
        color: white;
        text-decoration: none;
    }
    .delete-btn:hover {
        background-color: #da190b;
    }
</style>

</head>
<body style="background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include '../components/admin_header.php' ?>

<!-- user accounts section starts  -->


<section class="accounts">

   <h1 class="heading">Users Account</h1>

   <table>
      <thead>
         <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
            if(isset($_GET['search'])) {
               $search = $_GET['search'];
               $select_account = $conn->prepare("SELECT * FROM `users` WHERE name LIKE ?");
               $select_account->execute(["%$search%"]);
            } else {
               $select_account = $conn->prepare("SELECT * FROM `users`");
               $select_account->execute();
            }

            if($select_account->rowCount() > 0){
               while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
         ?>
         <tr>
            <td><?= $fetch_accounts['id']; ?></td>
            <td><?= $fetch_accounts['name']; ?></td>
            <td><a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a></td>
         </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="3" class="empty">No accounts available</td></tr>';
            }
         ?>
      </tbody>
   </table>

</section>

<!-- user accounts section ends -->

<!-- Bootstrap JS CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
