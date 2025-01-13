
<header>
      <div class="header-left">
        <a href="index.php"><img src="media/organic-2724527_640.png" alt="" class="logo"></a>

        <div class="dropdown-admin"> 
   <?php
   //Oikeasti tämä olisi varmasti huomattavasti paljon turvallisemmin, mutta nyt mennään näin.
   if (isset($_SESSION["user_id"]) && $_SESSION["user_type"] == "Admin") {
   ?>
       <button class="admin-btn"><b>ADMIN</b></button>
       <div class="submenu-admin">
           <a href="admin.php">Admin - Main</a>
           <a href="admin_products.php">Admin - Products Page</a>
           <a href="admin_users.php">Admin - Users Page</a>
           <a href="admin_orders.php">Admin - Orders Page</a>
       </div>
   <?php
   }
   ?>
</div>


      </div>
        
      <div class="header-center">
            <form action="search.php" method="get" class="search" >
                <input type="text" placeholder="Search" name="q">
                <button type="submit" ><img src="media/search.png"></button>
            </form>
       </div>     
            <nav class="header-right">
            <div class="login-menu">
    <?php
    if (!isset($_SESSION["user_id"])) {
        echo "Log In:";
        if (isset($_GET["error"]) && $_GET["error"] == "login") {
            if (isset($_SESSION["errors_login"])) {
                foreach ($_SESSION["errors_login"] as $error) {
                    echo "<p class='error-text'>$error</p>";
                }
            } else {
                echo "<p class='error-text'>E-mail and password do not match!</p>";
            }
        }
        echo "<form action='log_in.php' method='post'> 
    <input type='text' name='username' placeholder='Enter e-mail'>
    <input type='password' name='password' placeholder='Enter password'>
    <div class='loginbutton'>
        <input type='submit' value='Log In' class='button'>
    </div>
</form>";
?>
<a href="register.php">Register a new account here!</a>
 <?php   } ?>
   
  
</div>
<div class="logout-menu">
    <?php
if (isset($_SESSION["user_id"])) {
    echo "You are logged in as:<br>" . $_SESSION["username"];
    echo "<form action='logout.php' method='post'>
          <input type='submit' value='Log Out' class='button'>
         </form>";
}
    ?>
</div>

     <div class="header-buttons">
     <button id="user" ><a href="profile.php"><img src="media/person.png"></a></button> 
     <button id="cart" class="white-hover "><a href="cart.php"><img src="media/cart.png"></a></button>
     </div>
     <div class="keep-mainmenu-in-place">
     <div class="dropdown">
  <button class="hamburger-menu">
    <div class="button-items">
    <img src="media/menu.png" class="menu-image"><p class="menu-text">Menu</p>
    </div>
  </button>
  <div class="main-menu">
  <a href="index.php">Front Page</a>
  <a href="all_products.php">All Products</a>
  <a href="profile.php">User Account</a>
  <a href="cart.php">Shopping Cart</a>
  <a href="faq.php">FAQ</a>
  <a href="terms.php">Terms of Service</a>
  </div>
</div>
</div> <!--keep-mainmenu-in-place end
... Kyllä, tämä oli tärkeä div haha.-->
</nav>
        
    </header>