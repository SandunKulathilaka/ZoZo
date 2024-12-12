<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admins Accounts</title>
   <link rel="icon" href="images/LYgjKqzpQb.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
    /* Table Styles */
    .accounts {
        padding: 20px;
    }
    .accounts h1 {
        color: black;
    }
    .h
    .heading {
        text-align: center;
        color: #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
        color: #333;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .empty {
        text-align: center;
        color: #666;
    }
    /* Button Styles */
    .action-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    .delete-btn {
      padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #f44336;
        color: white;
        text-decoration: none;
        display: flex;
        width: 20rem;
    }
    .delete-btn:hover {
        background-color: #da190b;

    }
    .update-btn {
        background-color: #4caf50;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        width: 20rem;
    }
    .update-btn:hover {
        background-color: #45a049;
    }
</style>
</head>
<body style="background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include '../components/admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">

   <h1 class="heading">Admin Accounts</h1>

   <table>
      <thead>
         <tr>
            <th>Admin ID</th>
            <th>Username</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $select_account = $conn->prepare("SELECT * FROM `admin`");
            $select_account->execute();
            if($select_account->rowCount() > 0){
               while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
         ?>
         <tr>
            <td><?= $fetch_accounts['id']; ?></td>
            <td><?= $fetch_accounts['name']; ?></td>
            <td>
               <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
              <br>
              <?php
                  if($fetch_accounts['id'] == $admin_id){
                     echo '<a href="update_profile.php" class="action-btn update-btn">Update</a>';
                  }
               ?>
            </td>
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


<!-- admins accounts section ends -->




















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>