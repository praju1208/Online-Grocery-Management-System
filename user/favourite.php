<?php
require_once("../app/helpers/auth.php");
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

$fav = mysqli_query($conn,"
SELECT 
  p.id,
  p.name,
  p.price,
  p.weight,
  p.image
FROM favourites f
JOIN products p ON f.product_id = p.id
WHERE f.user_id = '$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>FreshKart | My Favourites</title>
<link rel="stylesheet" href="../assets/css/bg.css">

<link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="site-body">
<div class="site-wrapper">
  <main class="site-content">

<?php include("navbar.php"); ?>

<div class="container">

  <div class="page-header">
    <h2>❤️ My Favourites</h2>
    <a href="home.php" class="back-link">← Back to Shop</a>
  </div>

<?php if(mysqli_num_rows($fav) == 0){ ?>
  <p>No favourite products added yet.</p>
<?php } ?>

<?php while($p = mysqli_fetch_assoc($fav)){ ?>
  <div class="product-card">

    <img src="../assets/images/<?= $p['image'] ?>">

    <h3><?= $p['name'] ?></h3>
    <p><?= $p['weight'] ?></p>
    <p class="price">₹<?= $p['price'] ?></p>

    <div class="btn-group">
      <a class="add-cart"
         href="../app/config/controllers/CartController.php?id=<?= $p['id'] ?>">
         Add to Cart
      </a>

      <button class="heart-btn active"
              onclick="toggleFav(<?= $p['id'] ?>, this)">
        ♥
      </button>
    </div>

  </div>
<?php } ?>
</main>
<footer class="footer">
  <div class="footer-container">

    <div>
      <h3>FreshKart</h3>
      <p>FreshKart is an online grocery delivery platform bringing
        fresh vegetables, fruits, dairy products and essentials
        to your doorstep.</p>
    </div>

    <div class="footer-links">
      <h3>Quick Links</h3>
      <a href="#" onclick="openAbout();return false;">About Us</a>
      <a href="#" onclick="openContact();return false;">Contact Us</a>
      
    </div>

  </div>

  <div class="footer-bottom">
    © <?= date('Y') ?> FreshKart. All rights reserved.
  </div>
</footer>
</div>
<script>
function openContact(){
  document.getElementById('contactModal').style.display = 'block';
}

function openAbout(){
  document.getElementById('aboutModal').style.display = 'block';
}

function closeModal(){
  document.getElementById('contactModal').style.display = 'none';
  document.getElementById('aboutModal').style.display = 'none';
}
</script>
<?php if(isset($_SESSION['feedback_success'])){ ?>
<script>
  alert("✅ Thank you! Your feedback has been submitted successfully.");
</script>
<?php unset($_SESSION['feedback_success']); } ?>

</body>
<!-- CONTACT MODAL -->
<div id="contactModal" class="modal">
  <div class="modal-box">
    <span class="close" onclick="closeModal()">×</span>
    <h2>Contact Us</h2>
<form method="post" action="../app/config/controllers/FeedbackController.php">
  <input type="text" name="name" placeholder="Your Name" required>
  <input type="email" name="email" placeholder="Your Email" required>
  <textarea name="message" placeholder="Your Feedback" required></textarea>
  <button type="submit">Send Feedback</button>
</form>


<script>
document.getElementById('feedbackForm').onsubmit = function(e){
  e.preventDefault();

  fetch('../app/config/controllers/FeedbackController.php',{
    method:'POST',
    body:new FormData(this)
  })
  .then(res=>res.text())
  .then(data=>{
    if(data==='success'){
      alert('Thank you for your feedback!');
      closeModal();
      this.reset();
    }
  });
}
</script>

  </div>
</div>

<!-- ABOUT MODAL -->
<div id="aboutModal" class="modal">
  <div class="modal-box">
    <span class="close" onclick="closeModal()">×</span>
    <h2>About FreshKart</h2>
    <p>
FreshKart is a modern online grocery delivery platform designed to make
daily shopping simple, fast, and reliable. We bring fresh vegetables,
fruits, dairy products, groceries, and household essentials directly
to your doorstep.
</p>

<p>
Our platform connects customers with quality products at affordable
prices while ensuring quick delivery and secure transactions.
FreshKart focuses on freshness, convenience, and customer satisfaction.
</p>

<p>
With features like category-wise browsing, real-time offers,
favourite products, easy ordering, and multiple payment options,
FreshKart provides a smooth and user-friendly shopping experience.
</p>

<p>
Our goal is to save your time, reduce effort, and make grocery shopping
stress-free through technology and smart delivery solutions.
</p>
<ul>
  <li>✔ Fresh & quality products</li>
  <li>✔ Easy ordering process</li>
  <li>✔ Secure payments (Cash / UPI / Card)</li>
  <li>✔ Fast and reliable delivery</li>
</ul>

  </div>
</div>
<script>
function toggleFav(id, btn){
  fetch('../app/config/controllers/FavouriteController.php?id='+id)
    .then(res => res.text())
    .then(data => {
      if(data === 'removed'){
        btn.closest('.product-card').remove();
      }
    });
}
</script>


</body>
</html>
