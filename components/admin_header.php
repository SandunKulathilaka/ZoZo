<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Message Styles */
    .message {
        background-color: #f1c40f; /* Yellow background */
        color: #333;
        padding: 10px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .message span {
        margin-right: 10px;
    }
    /* Header Styles */
    .header {
        background: linear-gradient(to right, #3498db, #2ecc71); /* Gradient background */
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Box shadow */
    }
    /* Flex Container Styles */
    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    /* Logo Styles */
    .logo {
        color: white;
        text-decoration: none;
        font-size: 1.5em;
        font-weight: bold;
        margin-right: 20px;
    }
    .logo span {
        color: #f1c40f; /* Yellow color for "Panel" */
    }
    /* Navbar Styles */
    .navbar {
        display: flex;
        margin-right: auto;
    }
    .navbar a {
        color: white;
        text-decoration: none;
        margin-right: 20px;
        font-size: large;
    }
    .navbar a:hover {
        text-decoration: underline;
    }
    /* Icons Styles */
    .icons {
        margin-left: 20px;
    }
    .icons .fa-bars {
        color: white;
        font-size: 1.5em;
        cursor: pointer;
    }
    .icons .fa-bars:hover {
        color: #f1c40f; /* Yellow color on hover */
    }
    /* Profile Styles */
    .profile {
        display: none; /* Hide profile initially */
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(to right, #3498db, #2ecc71);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        
    }
    .profile p {
        margin-bottom: 5px;
    }
    .profile .btn,
    .profile .option-btn,
    .profile .delete-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 10px;
        margin: 10px;
        display:block;
    }
    .profile .btn {
        background-color: #f1c40f; /* Yellow color */
        color: white;
    }
    .profile .btn:hover {
        background-color: #d4ac0d; /* Darker yellow on hover */
    }
    .profile .option-btn {
        background-color: #3498db; /* Blue color */
        color: white;
    }
    .profile .option-btn:hover {
        background-color: #2980b9; /* Darker blue on hover */
    }
    .profile .delete-btn {
        background-color: #e74c3c; /* Red color */
        color: white;
    }
    .profile .delete-btn:hover {
        background-color: #c0392b; /* Darker red on hover */
    }
</style>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
   <section class="flex">
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>
      <img src="images/logo-zozo.svg" width="100" height="100" alt="Logo">
      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
         <a href="messages.php">Messages</a>
      </nav>
     
      <nav class="navbar">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <div id="user-btn" class="fas fa-user" style="font-size: 1.6em; cursor: pointer;">
            <?= $fetch_profile['name']; ?>
         </div>
      </nav>
      <div class="profile" id="profile-section">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Login</a>
            <a href="register_admin.php" class="option-btn">Register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">Logout</a>
      </div>
   </section>
</header>

<script>
   // Toggle profile section visibility on clicking user icon
   document.getElementById('user-btn').addEventListener('click', function() {
      var profileSection = document.getElementById('profile-section');
      profileSection.style.display = profileSection.style.display === 'none' ? 'block' : 'none';
   });
</script>

</body>
</html>
