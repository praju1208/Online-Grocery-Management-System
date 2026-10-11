<?php if(!isset($_SESSION)) session_start(); ?>
<link rel="stylesheet" href="../assets/css/main.css">

<div class="navbar">
  <div class="nav-left">
    <h2 class="logo">FreshKart</h2>
  </div>

 <div class="nav-center">
    <form method="get" action="home.php" class="search-form">
      <input type="text" name="search" placeholder="Search products...">
      <button type="submit" class="search-btn">Search</button>
    </form>
</div>

  <div class="nav-right">
    <a href="cart.php" class="nav-btn">🛒 Cart</a>
    <a href="orders.php" class="nav-btn">📦 Orders</a>
    <a href="favourite.php" class="nav-btn">❤️ Favourite</a>
 <?php if(isset($_SESSION['user_name'])){ ?>

    <span class="user">👤 <?= $_SESSION['user_name'] ?></span>
    <a href="../auth/logout.php" class="btn-logout">Logout</a>

  <?php } else { ?>

    <a href="../index.php" class="btn-nav login-btn">Login</a>

    <a href="../auth/register.php" class="btn-nav register-btn">Register</a>

  <?php } ?>
  </div>
</div>

<hr class="nav-line">
