<!DOCTYPE html>
<html lang="en">
   <?php // Head
      $page_title = 'Year at Glance';
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
         $nav_title = 'Ride Data';
         $nav_icon = 'menu_rideData.svg';
         $nav_back_href = 'month-at-glance.php';
         include_once 'include/nav.php';
      ?>
      <main>
         <!-- The button you see first -->
         <div class="container dropdown-wrap">
            <div class="dropdown shadow" id="drop">
               <h1><?php echo $year; ?></h1>
               <img src="assets/svg/down-arrow.svg" id="down-arrow">
            </div>

            <div class="dropdown-elements" id="elements">
            <?php
               $sql =
                  "SELECT
                           YEAR(date) AS `year`
                  FROM     ride_data
                  GROUP BY
                           YEAR(date)
                  ORDER BY
                           YEAR(date);";

               $result = mysqli_query($connection, $sql);
               if (mysqli_num_rows($result) > 0) {
                  // Each form is 1 dropdown option
                  while ($row = mysqli_fetch_assoc($result)) {
            ?>
               <form target="_self" method="GET">
               <input name="month" value="0" hidden> <!-- Input is hidden, no need to style, do not edit value -->
                  <button type="submit" name="year" value="<?php echo $row['year']; ?>"><?php echo $row['year']; ?></button>
               </form>

            <?php }} ?>
         </div>
         </div>

         <div class="container">
            <h2><?php echo $year; ?> at a glance</h2>
         </div>

         <!-- THE DATA -->

         <div class="container ride-data">

            <!-- Total spent in YEAR -->
            <?php
               $sql =
               "SELECT  SUM(price) AS value_sum
               FROM     ride_data
               WHERE    YEAR(date) = $year";

               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/money.svg" alt="money">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Total spent in <?php echo $year; ?></p>
                  <p class="card-data"><?php echo '$'.$row['value_sum']; ?></p>
               </div>
            </div>

            <!-- Total rides taken in YEAR -->
            <?php
               $sql =
               "SELECT  COUNT(ride_id) AS value_sum
               FROM     ride_data
               WHERE    YEAR(date) = $year;";

               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/car.svg" alt="car">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Total rides taken in <?php echo $year; ?></p>
                  <p class="card-data"><?php echo $row['value_sum'].' rides'; ?></p>
               </div>
            </div>

            <!-- Most common ride type -->
            <?php
               $sql =
               "SELECT     `type`, COUNT(`type`) AS `value_occurrence`
               FROM        `ride_data`
               WHERE       YEAR(date) = $year
               GROUP BY    `type`
               ORDER BY    `value_occurrence`
               DESC LIMIT  1;";

               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/two-cars.svg" alt="two-cars">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Most common ride type</p>
                  <p class="card-data"><?php echo ucwords($row['type']); ?></p>
               </div>
            </div>

            <!-- Average monthly spending -->
            <?php
               $sql =
               "SELECT Avg(price) AS `average`, year(date) AS `year` FROM ride_data WHERE year(date) = $year GROUP BY year(date);";

               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);

               $average = number_format((float)$row['average'], 2, '.', '');
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/car-building.svg" alt="building">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Average monthly spending</p>
                  <p class="card-data"><?php echo '$'.$average ?></p>
               </div>
            </div>

            <!-- Average monthly rides -->
            <?php
               $sql =
               "SELECT  count(*) AS count,
                        MONTH(date) as mnth
               FROM     ride_data
               WHERE    YEAR(date) = $year
               GROUP BY mnth;";

               $result = mysqli_query($connection, $sql);

               if (mysqli_num_rows($result) > 0) {
                  $total = 0;
                  while ($row = mysqli_fetch_assoc($result)) {
                     $total = $total + $row['count'];
               }}
               $rowcount = mysqli_num_rows($result);
               $avg_monthly_rides = $total / $rowcount;
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/coupon.svg" alt="coupon">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Average monthly rides</p>
                  <p class="card-data"><?php echo $avg_monthly_rides ?> Rides</p>
               </div>
            </div>

         </div> <!-- END OF CONTAINER -->
         
         <!-- Rides per month -->
         <div class="container">
            <h2>Rides per month</h2>
         </div>

         <?php
            $sql =
               "SELECT COUNT(ride_id) AS month_sum, month(date) AS mnth FROM ride_data WHERE YEAR(date) = 2020 GROUP BY month(date);";
            $result = mysqli_query($connection, $sql);
         ?>

         <div class="container chart-bar-rides-per-month shadow" style="height: 300px;"></div>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
               var data = new google.visualization.arrayToDataTable([
                  ['Range', 'Occurrence'],
                  <?php
                     if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                           $dateObj   = DateTime::createFromFormat('!m', $row['mnth']); // Turns month # into object, '!m' declares it as a month type
                           $monthName = $dateObj->format('M'); // Converts object into name, 'M' is 3 letter month name, 'F' is full month name

                           echo "['{$monthName}', {$row['month_sum']}],";
                        }}
                  ?>
               ]);

               var options = {
                  width: $(window).width(),
                  legend: { position: 'none' },
                  chart: {
                     title: 'Rides per month',
                     subtitle: '' },
                  axes: {
                  x: {
                     0: { side: 'bottom', label: 'Month'}
                  }
                  },
                     bar: { groupWidth: "90%" }
                     };

                  var chart = new google.charts.Bar(document.querySelector('.chart-bar-rides-per-month'));
                  chart.draw(data, google.charts.Bar.convertOptions(options));
               };
         </script>
         
         <!-- Most common ride type -->
         <div class="container">
            <h2>Most common ride type</h2>
         </div>

         <div class="container chart-pie shadow">
            <?php
               $sql = "SELECT `type`, COUNT(*) AS `value_occurrence` FROM `ride_data` WHERE YEAR(date) = $year GROUP BY `type`;";
               $result = mysqli_query($connection, $sql);
            ?>
            <!-- Google Pie Chart JS https://developers.google.com/chart/interactive/docs/gallery/piechart -->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
               // Load google charts
               google.charts.load('current', {'packages':['corechart']});
               google.charts.setOnLoadCallback(drawChart);

               // Draw the chart and set the chart values
               function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                     ['Type', '# per month'],
                     <?php
                        if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_array($result)) {
                              echo "['{$row['type']}', {$row['value_occurrence']}],";
                        }}
                     ?>
               ]);

               // Optional; add a title and set the width and height of the chart
               var options = {'title':'', 'width': $(window).width(), 'height':400};

               // Display the chart inside the <div> element with id="piechart"
               var chart = new google.visualization.PieChart(document.querySelector('.chart-pie'));
               chart.draw(data, options);
               }
            </script>
         </div>
            
         <!-- Common price ranges -->
         <div class="container">
            <h2>Common price ranges</h2>
         </div>

         <?php
            $sql =
               "SELECT 
               SUM(CASE WHEN price BETWEEN 1  AND 5  THEN 1 ELSE 0 END) AS '1-5',
               SUM(CASE WHEN price BETWEEN 6  AND 10 THEN 1 ELSE 0 END) AS '6-10',
               SUM(CASE WHEN price BETWEEN 11 AND 15 THEN 1 ELSE 0 END) AS '11-15',
               SUM(CASE WHEN price BETWEEN 16 AND 20 THEN 1 ELSE 0 END) AS '16-20',
               SUM(CASE WHEN price >= 20 THEN 1 ELSE 0 END) AS '20+'
               FROM ride_data
               WHERE YEAR(date) = $year;";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
         ?>

         <div class="container chart-bar-common-price-ranges shadow" style="height: 300px;"></div>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff_common_price_ranges);

            function drawStuff_common_price_ranges() {
               var data = new google.visualization.arrayToDataTable([
                  ['Price Range', 'Rides in this Range'],
                  ["$1-5", <?php echo $row['1-5']; ?>],
                  ["$6-10", <?php echo $row['6-10']; ?>],
                  ["$11-15", <?php echo $row['11-15']; ?>],
                  ["$16-20", <?php echo $row['16-20']; ?>],
                  ["$20+", <?php echo $row['20+']; ?>]
               ]);

               var options = {
                  width: $(window).width(),
                  legend: { position: 'none' },
                  chart: {
                     title: 'Common price ranges',
                     subtitle: '' },
                  axes: {
                  x: {
                     0: { side: 'bottom', label: 'Ride Price Range'}
                  }
                  },
                     bar: { groupWidth: "90%" }
                     };

                  var chart = new google.charts.Bar(document.querySelector('.chart-bar-common-price-ranges'));
                  chart.draw(data, google.charts.Bar.convertOptions(options));
               };
         </script>

         <div class="container"> <!-- Frequently visited locations -->
            <h2>Frequently visited locations</h2>
         </div>
            
            <div class="container frequent-locations shadow">
               <ul class="frequent-locations-ul">
                  <?php
                     $sql = "SELECT `destination_title`, COUNT(`destination_title`) AS `value_occurrence` FROM `ride_data` WHERE year(date) = $year GROUP BY `destination_title` ORDER BY `value_occurrence` DESC LIMIT 5;";
                     $result = mysqli_query($connection, $sql);

                     if (mysqli_num_rows($result) > 0) {
                        $num = 1;
                        while ($row = mysqli_fetch_array($result)) {
                  ?>

                  <li class="frequent-locations-li">
                     <div class="frequent-list-num-area">
                        <h2 class="frequent-nums"><?php echo ($num++).'.'; ?></h2>
                     </div>
                     <div class="frequent-list-main-area">
                        <h2><?php echo $row['destination_title']; ?></h2>
                        <p class="frequent-p">You visited this location <?php echo $row['value_occurrence']; ?> times this month</p>
                     </div>
                  </li>

            <?php }} ?>

               </ul>
            </div> <!-- END OF CONTAINER -->
         
      </main>

   </body>
</html>