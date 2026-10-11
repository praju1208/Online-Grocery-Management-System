<?php
session_start();
include "navbar.php";

include("../app/config/db.php");


$search = $_GET['search'] ?? '';
$cat = $_GET['cat'] ?? '';

$userId = $_SESSION['user_id'] ?? 0;

$sql = "
SELECT 
  p.id,
  p.name,
  p.price,
  p.weight,
  p.image,
  c.name AS category,
  IFNULL(c.offer, 0) AS category_offer,
  IF(f.id IS NULL, 0, 1) AS is_fav
FROM products p
JOIN categories c ON p.category_id = c.id
LEFT JOIN favourites f 
  ON f.product_id = p.id 
  AND f.user_id = $userId
WHERE 1
";


if (!empty($search)) {
  $sql .= " AND p.name LIKE '%$search%'";
}

if (!empty($cat)) {
  $sql .= " AND p.category_id = '$cat'";
}


$result = mysqli_query($conn, $sql);

/* fetch categories */
$cats = mysqli_query($conn,"SELECT * FROM categories");

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/bg.css">
<title>FreshKart | Home</title>
<link rel="stylesheet" href="../assets/css/main.css">
</head>

<body class="site-body">
<div class="site-wrapper">
  <main class="site-content">
<!-- CATEGORY TABS (STEP-2) -->
<div class="category-tabs">
  <a href="home.php"
     class="<?= empty($cat) ? 'active' : '' ?>">
     All
  </a>

  <?php
  mysqli_data_seek($cats, 0);
  while($c = mysqli_fetch_assoc($cats)){ ?>
    <a href="home.php?cat=<?= $c['id'] ?>"
       class="<?= ($cat == $c['id']) ? 'active' : '' ?>">
       <?= $c['name'] ?>
    </a>
  <?php } ?>
</div>

<!-- PRODUCTS -->
<div class="container">

<?php while($p = mysqli_fetch_assoc($result)){ 

$offer = (int)$p['category_offer'];

$finalPrice = $offer > 0
  ? $p['price'] - ($p['price'] * $offer / 100)
  : $p['price'];

  $offer = (int)($p['category_offer'] ?? 0);

$mrp = (float)$p['price'];

$sell = $offer > 0
  ? $mrp - ($mrp * $offer / 100)
  : $mrp;

?>
  <div class="product-card">

    <img src="../assets/images/<?= $p['image'] ?>" alt="product">

    <h3><?= $p['name'] ?></h3>
<p class="category"><?= $p['category'] ?></p>
<p><?= $p['weight'] ?></p>
<p class="price">
  ₹<?= number_format($sell, 2) ?>

  <?php if ($offer > 0) { ?>
    <span class="old">₹<?= number_format($mrp, 2) ?></span>
    <span class="off"><?= $offer ?>% OFF</span>
  <?php } ?>
</p>




<div class="btn-group">
  <a class="add-cart" href="../app/config/controllers/CartController.php?id=<?= $p['id'] ?>">
    Add to Cart
  </a>
<button class="heart-btn <?= $p['is_fav'] ? 'active' : '' ?>"
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
<script src="../assets/js/favourite.js"></script>
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

  </div>
</div>

<script>
function toggleFav(id, btn){
  fetch('../app/config/controllers/FavouriteController.php?id='+id)
    .then(res => res.text())
    .then(data => {
      btn.classList.toggle('active');

      // If on favourite page → remove card visually
      if(data === 'removed' && document.body.classList.contains('fav-page')){
        btn.closest('.product-card').remove();
      }
    });
}
</script>
</html>
