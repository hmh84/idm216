<?php // Head
   $page_title = 'Prototype';
   $page_specific_style = 'assets/css/prototype.css';
   $is_map = True;
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
         <span></span>
         <span></span>
         <span></span>
      </button>

      <div id="home" class="home" onclick="closeNav()">
         <div id="mapwrapper">
            <div id="map"></div>
         </div>
         <div class="landing-footer shadow">
            <img class="help-btn" src="assets/svg/prototype/home_helpButton.svg">
            <h2>Hey there, Jeffery</h2>
            <h1>Where are you going?</h1>
            <div class="search shadow">
               <img src="assets/svg/prototype/home_search.svg">
               <p> <!-- DO NOT DELETE THIS P TAG -->
                  <input type="text" placeholder="Search Destination">
               </p>
            </div>
            <h3>Recent destinations</h3>

            <!-- Recent Destinations -->
            <?php
               $sql = "SELECT date, destination_title, destination_address FROM ride_data ORDER BY date DESC LIMIT 2;";
               $result = mysqli_query($connection, $sql);
               if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                     if ($row['destination_title'] == $row['destination_address']) {
                        $the_recent_rides = $row['destination_title'];
                     } else {
                        $the_recent_rides = $row['destination_title'] .'<br>'. $row['destination_address'];
                     }
            ?>

                     <div class="destination">
                        <img src="assets/svg/prototype/home_destination.svg">
                        <p><?php echo $the_recent_rides; ?></p>
                     </div>

            <?php }} else { echo 'No data to display!'; } ?>

         </div>
      </div>
      <?php include_once 'include/footer.php'; ?>
   </body>
</html>