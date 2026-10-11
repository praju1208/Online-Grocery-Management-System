<?php
session_start();
include("../../config/db.php");

/* 🔐 Check login */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "user/home.php";
    header("Location: ../../../index.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

/* 🔍 Get product ID safely */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid product');history.back();</script>";
    exit();
}

$product_id = (int) $_GET['id'];

/* ✅ Check product exists (VERY IMPORTANT for FK error) */
$pcheck = mysqli_query($conn, "SELECT id FROM products WHERE id = $product_id");

if (mysqli_num_rows($pcheck) === 0) {
    echo "<script>alert('Product not found');history.back();</script>";
    exit();
}

/* 🛒 Check if product already in cart */
$check = mysqli_query($conn, "
    SELECT id, quantity 
    FROM cart 
    WHERE user_id = $user_id 
    AND product_id = $product_id
");

if (mysqli_num_rows($check) > 0) {

    /* ➕ Increase quantity */
    mysqli_query($conn, "
        UPDATE cart 
        SET quantity = quantity + 1 
        WHERE user_id = $user_id 
        AND product_id = $product_id
    ");

} else {

    /* ➕ Insert new cart item */
    mysqli_query($conn, "
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES ($user_id, $product_id, 1)
    ");
}

/* ✅ Success */
echo "<script>
    alert('Product added to cart');
    window.location.href='../../../user/cart.php';
</script>";
exit();
