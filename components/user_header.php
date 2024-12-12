<?php

include 'components/connect.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<style>
    .custom-navbar {
        height: 80px; /* Adjust the height as needed */
    }

    .nav-link.active {
        font-size: 16px;
        margin: 4px;

    }

    .navbar-brand {
        font-size: 20px;
        margin: 5px;
    }

    .dropdown-menu {
        font-size: 16px;
    }

    .nav-link.dropdown-toggle {
        font-size: 16px;
        margin: 4px;
    }
</style>


<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark custom-navbar" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ZoZo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="orders.php">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <?php if ($user_id != '') { ?>
                        <a class="nav-link active" aria-current="page" href="profile.php?<?php echo"$user_id"?>">Profile</a>
                    <?php } else { ?>
                        <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                    <?php } ?>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="category.php?category=fast food">Fast Food</a></li>
                        <li><a class="dropdown-item" href="category.php?category=main dish">Main Dishes</a></li>
                        <li><a class="dropdown-item" href="category.php?category=drinks">Drinks</a></li>
                        <li><a class="dropdown-item" href="category.php?category=desserts">Deserts</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
            <?php
    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $count_cart_items->execute([$user_id]);
    $total_cart_items = $count_cart_items->rowCount();
    ?>
    <a href="cart.php" style="color: white;"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            </div>
            
</div>
        </div>
    </div>
</nav>
