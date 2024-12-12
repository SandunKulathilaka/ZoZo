<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, description, category, price, image) VALUES(?,?,?,?,?)");
         $insert_product->execute([$name, $description, $category, $price, $image]);

         $message[] = 'new product added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="icon" href="images/LYgjKqzpQb.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
    /* Table Styles */
    .box-container {
        display: flex;
        justify-content: center;
        align-items: center;
        
    }
    .product-table {
        width: 50%; /* Adjust the width as needed */
        border-collapse:inherit;
        height: 300px;
    }
    .product-table th,
    .product-table td {
        padding: 8px 12px;
        border: 1px solid #ddd;
        text-align: left;
        
        
    }

    .box-container .product-table img{
   width: 100%;
   height: 20rem;
   object-fit: contain;
   margin-bottom: 1rem;
}

    .product-table th {
        background-color: #f2f2f2;
        color: #333;
    }
    .product-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    /* Button Styles */
    .option-btn,
    .delete-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }
    .option-btn {
        background-color: #4caf50;
        color: white;
    }
    .option-btn:hover {
        background-color: #45a049;
    }
    .delete-btn {
        background-color: #f44336;
        color: white;
    }
    .delete-btn:hover {
        background-color: #da190b;
    }
</style>

</head>
<body style="background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add product</h3>
      <h2>Product Name</h2><input type="text" required  name="name" maxlength="100" class="box"><br>
      <h2>description</h2><input type="text" required  name="description" maxlength="100" class="box"> <br>
      <h2>Product Price</h2><input type="number" min="0" max="9999999999" required name="price" onkeypress="if(this.value.length == 10) return false;" class="box"> <br>
      <h2>select category </h2><select name="category" class="box" required>
         <option value="" disabled selected>category --</option>
         <option value="main dish">main dish</option>
         <option value="fast food">fast food</option>
         <option value="drinks">drinks</option>
         <option value="desserts">desserts</option>
      </select><br>
      <h2>Input Image</h2><input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<div class="box-container">
       <table class="product-table">
           <thead>
               <tr>
                   <th>Image</th>
                   <th>Price</th>
                   <th>Category</th>
                   <th>Name</th>
                   <th>Description</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
           <?php
              $show_products = $conn->prepare("SELECT * FROM `products`");
              $show_products->execute();
              if($show_products->rowCount() > 0){
                 while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
           ?>
               <tr>
                   <td><img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt=""></td>
                   <td><?= $fetch_products['price']; ?>$</td>
                   <td><?= $fetch_products['category']; ?></td>
                   <td><?= $fetch_products['name']; ?></td>
                   <td><?= $fetch_products['description']; ?></td>
                   <td>
                       <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                       <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                   </td>
               </tr>
           <?php
                 }
              } else {
                 echo '<tr><td colspan="6">No products added yet!</td></tr>';
              }
           ?>
           </tbody>
       </table>
   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>