<!DOCTYPE html>
<html lang="en">
   <?php // Head
      $page_title = 'Month Ride History';
      $page_specific_style = 'assets/css/prototype-pages.css';
      include_once 'include/head.php';

      include_once 'include/data-handler.php'; // Only for data pages
   ?>
   <body>

      <div class="dark-bg"></div>
      <div class="landscape-warning shadow">
         <img class="warning" src="assets/svg/landscape-warning.svg">
         <p>Please turn your device</p>
      </div>

      <?php // Nav
         $nav_title = 'Ride History';
         $nav_icon = 'menu_rideHistory.svg';
         $nav_back_href = 'prototype.php';
         include_once 'include/nav.php';
      ?>
      <main>
      <!-- The button you see first -->
         <div class="container dropdown-wrap">
            <div class="dropdown shadow" id="drop">
               <h1><?php echo $monthRangeName.' '.$year; ?></h1>
               <img src="assets/svg/down-arrow.svg" id="down-arrow">
            </div>

            <div class="dropdown-elements" id="elements">
            <?php
               $sql =
                  "SELECT
                           YEAR(date) AS `year`,
                           MONTH(date) AS `month`
                  FROM     ride_data
                  GROUP BY
                           YEAR(date),
                           MONTH(date)
                  ORDER BY
                           YEAR(date),
                           MONTH(date);";

               $result = mysqli_query($connection, $sql);
               if (mysqli_num_rows($result) > 0) {
                  // Each form is 1 dropdown option
                  while ($row = mysqli_fetch_assoc($result)) {

                     $monthObj   = DateTime::createFromFormat('!m', $row['month']); // Turns month # into object, '!m' declares it as a month type
                     $monthName = $monthObj->format('M'); // Converts object into name, 'M' is 3 letter month name, 'F' is full month name
            ?>
               <form target="_self" method="GET">
                  <input name="month" value="<?php echo $row['month']; ?>" hidden> <!-- Input is hidden, no need to style -->
                  <button type="submit" name="year" value="<?php echo $row['year']; ?>"><?php echo $monthName.' '.$row['year']; ?></button>
               </form>
         <?php }} ?>
         
         </div>
         </div>


         <div class="container">
            <a class="button shadow" href="month-at-glance.php?month=<?php echo $month ?>&year=<?php echo $year ?>">View All Data for <?php echo $monthRangeName.' '.$year; ?></a>
         </div>

         <div class="container">
            <h2><?php echo $monthRangeName.' '.$year; ?> Ride History</h2>
            <a class="export shadow" href="">Export</a>
         </div>


         <!-- THE DATA -->

         <?php
            $sql =
               "SELECT * FROM ride_data
               WHERE MONTH(date) = $month AND YEAR(date) = $year
               ORDER BY date DESC LIMIT 3;";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  $orig_date = $row['date'];
                  $new_date = date("M jS Y", strtotime($orig_date));
         ?>

         <div class="container ride-history">
            <div class="ride-history-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/img/driver_profile_pictures/<?php echo $row['driver_img']; ?>" alt="<?php echo $row['driver']; ?>">
                  <p class="driver-name"><?php echo $row['driver']; ?></p>
               </div>
               <div class="card-mid-area">
                  <div class="card-mid-top">
                     <p class="card-title"><?php echo $new_date.' • '.$row['time']; ?></p>
                     <p class="card-subtitle"><?php echo $row['distance'].'mi • '.$row['duration'].'mins'; ?></p>
                  </div>
                  <div class="card-mid-btm">
                     <div class="location-icons">
                        <img class="location-a-b" src="assets/svg/prototype/ride-a-b.svg" alt="Ride AB">
                     </div>
                     <div class="locations">
                        <p class="card-pickup"><?php echo $row['pickup']; ?></p>
                        <p class="card-destination"><?php echo $row['destination_address']; ?></p>
                     </div>
                  </div>
               </div>
               <div class="card-end-area">
                  <p class="card-price"><?php echo '$'.$row['price']; ?></p>
                  <img class="card-view-btn" src="assets/svg/back.svg" alt="View Btn">
               </div>
            </div>
         </div>

         <?php }} else { echo 'No data to display!'; } ?>

      </main>

   </body>
</html>