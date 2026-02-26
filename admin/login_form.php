<?php
session_start();

/* I take the error message from session (if any) so I can show it on this page. */
$error_message = '';
if (isset($_SESSION['login_error'])) {
  $error_message = $_SESSION['login_error'];
  unset($_SESSION['login_error']);
}

/* I keep the old username (if any) so user doesn't need to retype it. */
$old_username = '';
if (isset($_SESSION['old_username'])) {
  $old_username = $_SESSION['old_username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Nguyen Linh Portfolio</title>

  <link rel="stylesheet" href="../css/grid.css">
  <link rel="stylesheet" href="../css/main.css">

  <!-- FONTS & ICON -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/png" href="../L_Favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/svg+xml" href="../L_Favicon/favicon.svg">
  <link rel="shortcut icon" href="../L_Favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="../L_Favicon/apple-touch-icon.png">
  <link rel="manifest" href="../L_Favicon/site.webmanifest">
</head>


  <!-- HEADER -->
  <header id="header" class="grid-con">
    <h1 class="hidden"> Admin Login - Nguyen Linh Portfolio </h1>

    <div class="header-logo col-span-2 m-col-span-3 l-col-span-2">
      <a href="../index.php" class="logo-wrapper">
        <img src="../images/L_Logo.svg" alt="Linh Nguyen Logo">
        <div class="logo-text">
          <span>Linh</span>
          <span>Nguyen</span>
        </div>
      </a>
    </div>

    <input type="checkbox" id="menu-toggle" hidden>

    <label for="menu-toggle" class="header-hamburger col-start-4 col-end-5">
      <span></span><span></span><span></span>
    </label>

    <nav class="header-nav m-col-start-6 m-col-end-8 l-col-start-6 l-col-end-8">
      <h2 class="hidden"> Main Navigation</h2>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="login_form.php" class="active">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li class="mobile-connect"><a href="../contact.php">Contact</a></li>
      </ul>
    </nav>

    <div class="header-connect m-col-start-12 m-col-end-13 l-col-start-12 l-col-end-13">
      <a href="../contact.php" class="btn-connect">Contact</a>
    </div>
  </header>

  <body>
  <!-- LOGIN FORM -->
  <section id="contact-form" class="grid-con">
    <h2 class="col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">Admin Login</h2>

    <div id="form-box" class="contact-form-box col-span-full m-col-start-2 m-col-end-12 l-col-start-2 l-col-end-12">

      <form action="login.php" method="post" novalidate>

        <div class="form-group">
          <label for="username">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Your Username"
            value="<?php echo($old_username); ?>"
          >
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Your Password"
          >

          <small>
            This is a restricted area of my website.
            If you need any help, reach me in my
            <a href="../contact.php" class="admin-contact-link">Contact Page</a>
          </small>

          <?php if ($error_message != ''): ?>
            <div class="custom-errors-box form-errors-under-btn">
              <ul>
                <li>
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <?php echo($error_message); ?>
                </li>
              </ul>
            </div>
          <?php endif; ?>

        </div>

        <button type="submit" class="btn-submit">Login</button>

      </form>

    </div>
  </section>

  <!-- FOOTER -->
  <footer id="footer-admin" class="grid-con">
    <div class="footer-bottom-admin col-span-full">
      <p class="credit-left">Design and Developed by Linh Nguyen</p>
      <p class="credit-right">© 2026 All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>