<!DOCTYPE html>
<html lang="en">
   <?php // Head
      $page_title = 'Prototype';
      $page_specific_style = 'assets/css/prototype.css';
      include_once 'include/head.php';
   ?>
   <body>

      <div class="dark-bg"></div>
      <div class="landscape-warning shadow">
         <img class="warning" src="assets/svg/landscape-warning.svg">
         <p>Please turn your device</p>
      </div>

      <div id="mySidenav" class="sidenav">
         <div class="scroll">

         <div class="profile">
            <img class="profile-icon shadow" src="assets/svg/prototype/menu_driverProfile.png">
            <h1>Jeffery</h1>
            <h2>View profile</h2>
         </div>

         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_getARide.svg">About</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_help.svg">Help</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_notifications.svg">Notifications</a>
         <a class="sidebar-btn shadow" href="month-ride-history.php"><img src="assets/svg/prototype/menu_rideHistory.svg">Ride History</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_payment.svg">Payment</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_promos.svg">Promos</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_donate.svg">Donate</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_lyftPink.svg">Lyft Pink</a>
         <a class="sidebar-btn shadow" href="#"><img src="assets/svg/prototype/menu_settings.svg">Settings</a>

      </div>
      </div>

      <button class="menu-btn shadow" onclick="openNav()">
         <img src="assets/svg/hamburger.svg">
      </button>


      <div id="home" class="home" onclick="closeNav()">
         <!-- <iframe class="maps-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24467.884007121145!2d-75.17777023713809!3d39.95289673297466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c6c62f36fbe869%3A0xa436e1d13cf7c05b!2sCenter%20City%2C%20Philadelphia%2C%20PA!5e0!3m2!1sen!2sus!4v1597365323781!5m2!1sen!2sus" frameborder="0" style="border:0;" allowfullscreen="no" aria-hidden="true" tabindex="0"></iframe> -->
         <img class="landing-bg" src="assets/img/map.png">
         <div class="landing-footer shadow">
            <img class="help-btn" src="assets/svg/prototype/home_helpButton.svg">
            <h2>Hey there, Jeffery</h2>
            <h1>Where are you going?</h1>
            <div class="search shadow">
               <img src="assets/svg/prototype/home_search.svg">
               <p>Search destination</p>
            </div>
            <h3>Recent destinations</h3>

            <!-- Recent Destinations -->
            <?php
               $sql = "SELECT date, destination_title, destination_address FROM ride_data ORDER BY date DESC LIMIT 2;";
               $result = mysqli_query($connection, $sql);
               if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
            ?>

                     <div class="destination">
                        <img src="assets/svg/prototype/home_destination.svg">
                        <p><?php echo $row['destination_title'] .'<br>'. $row['destination_address']; ?></p>
                     </div>

            <?php }} else { echo 'No data to display!'; } ?>

         </div>
      </div>

   </body>
</html>
