<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="/freshkart/assets/css/global.css">

<meta charset="UTF-8">
<title>FreshKart | Login</title>
<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="login-container">
  <div class="login-card">

    <h2 class="title">Login</h2>

    <form method="post" action="auth/login_process.php">

      <select name="role" required>
        <option value="user">Customer</option>
        <option value="admin">Admin</option>
        <option value="delivery">Delivery Boy</option>
      </select>

      <input type="email" name="email" placeholder="Email" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit" class="btn-login">Login</button>

    </form>

    <a href="user/home.php" class="btn-skip">Skip & Continue</a>

    <p class="register-text">
      New user?
      <a href="auth/register.php">Register here</a>
    </p>

  </div>
</div>

</body>
</html>
