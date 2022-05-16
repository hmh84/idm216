<?php // Head
   $page_title = 'Month at Glance';
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
         $nav_back_href = 'month-ride-history.php?month='.$month.'&year='.$year;
         include_once 'include/nav.php';
      ?>
      <main>
         <!-- The button you see first -->
         <div class="container dropdown-wrap">
            <div class="dropdown shadow" id="drop">
               <h1><?php echo $monthName_3L.' '.$year; ?></h1>
               <img src="assets/svg/down-arrow.svg" id="down-arrow">
            </div>

            <div class="dropdown-elements" id="elements">
            <?php
               $sql =
                  "SELECT YEAR(date) AS `year`, MONTH(date) AS `month` FROM ride_data GROUP BY YEAR(date), MONTH(date) ORDER BY YEAR(date) DESC, MONTH(date) DESC;";

               $result = mysqli_query($connection, $sql);
               if (mysqli_num_rows($result) > 0) {
                  // Each form is 1 dropdown option
                  while ($row = mysqli_fetch_assoc($result)) {

                     $monthObj   = DateTime::createFromFormat('!m', $row['month']); // Turns month # into object, '!m' declares it as a month type
                     $monthName = $monthObj->format('M'); // Converts object into name, 'M' is 3 letter month name, 'F' is full month name
            ?>
               <form target="_self" method="GET" data-month="<?php echo $row['month']; ?>">
                  <input name="month" value="<?php echo $row['month']; ?>" hidden> <!-- Input is hidden, no need to style -->
                  <button type="submit" name="year" value="<?php echo $row['year']; ?>"><?php echo $monthName.' '.$row['year']; ?></button>
               </form>

         <?php }} ?>
         </div>
         </div>

         <div class="container">
            <a class="button shadow" href="year-at-glance.php?month=<?php echo $month ?>&year=<?php echo $year ?>&rememberyear=<?php echo $year;
               ?>"><?php echo $year; ?> Summary</a>
         </div>

         <div class="container">
            <h2><?php echo $monthName_3L.' '.$year; ?>  at a glance</h2>
         </div>

         <!-- THE DATA -->

         <div class="container ride-data">

            <!-- Total spent this month -->
            <?php
               $sql = "SELECT SUM(price) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/money.svg" alt="money">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Total spent this month</p>
                  <p class="card-data"><?php echo '$'.$row['value_sum']; ?></p>
               </div>
            </div>

            <!-- Total rides taken this month -->
            <?php
               $sql = "SELECT COUNT(ride_id) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/car.svg" alt="car">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Total rides taken this month</p>
                  <p class="card-data"><?php echo $row['value_sum'].' rides'; ?></p>
               </div>
            </div>

            <!-- Average cost per Ride -->
            <?php
               $sql = "SELECT AVG(price) AS value_avg FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/averageCost_ridingData.svg" alt="building">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Average cost per ride</p>
                  <p class="card-data"><?php echo '$'.number_format((float)$row['value_avg'], 2, '.', ''); ?></p>
               </div>
            </div>

            <!-- Average distance per Ride -->
            <?php
               $sql = "SELECT AVG(distance) AS value_avg FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/route.svg" alt="route">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Average distance per ride</p>
                  <p class="card-data"><?php echo number_format((float)$row['value_avg'], 2, '.', '').' mi'; ?></p>
               </div>
            </div>

            <!-- Most common ride type -->
            <?php
               $sql = "SELECT `type`, COUNT(`type`) AS `value_occurrence` FROM `ride_data` WHERE MONTH(date) = $month AND YEAR(date) = $year GROUP BY `type` ORDER BY `value_occurrence` DESC LIMIT 1;";
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

            <!-- Total coupon & promo savings -->
            <?php
               $sql = "SELECT SUM(discount) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
               $result = mysqli_query($connection, $sql);
               $row = mysqli_fetch_assoc($result);
            ?>

            <div class="ride-data-card shadow">
               <div class="card-img-area">
                  <img class="card-icon" src="assets/svg/coupon.svg" alt="coupon">
               </div>
               <div class="card-content-area">
                  <p class="card-title">Total coupon & promo savings</p>
                  <p class="card-data"><?php echo '$'.$row['value_sum'] ?></p>
               </div>
            </div>

         </div> <!-- END OF CONTAINER -->

         <!-- Most common ride type -->
         <div class="container chart-title">
            <h2>Most common ride type</h2>
         </div>

         <div class="container chart-pie shadow rounded-corners">
            <?php
               $sql = "SELECT `type`, COUNT(*) AS `value_occurrence` FROM `ride_data` WHERE MONTH(date) = $month AND YEAR(date) = $year GROUP BY `type`;";
               $result = mysqli_query($connection, $sql);
            ?>
            <!-- Google Pie Chart JS https://developers.google.com/chart/interactive/docs/gallery/piechart -->
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
               var options = {'title':'Most Common Ride Type', 'width': $(window).width()*.8, 'height': $(window).width()*.7, colors: ['#B6D7F4', '#FF80DF', '#276DF6']};

               // Display the chart inside the <div> element with id="piechart"
               var chart = new google.visualization.PieChart(document.querySelector('.chart-pie'));
               chart.draw(data, options);
               }
            </script>
         </div>

         <!-- Common price ranges -->
         <div class="container chart-title">
            <h2>Common price ranges</h2>
         </div>

         <?php
            $sql =
               "SELECT 
               SUM(CASE WHEN price BETWEEN 1  AND 5  THEN 1 ELSE 0 END) AS '1-10',
               SUM(CASE WHEN price BETWEEN 6  AND 10 THEN 1 ELSE 0 END) AS '10-20',
               SUM(CASE WHEN price BETWEEN 11 AND 15 THEN 1 ELSE 0 END) AS '20-30',
               SUM(CASE WHEN price >= 30             THEN 1 ELSE 0 END) AS '30+'
               FROM ride_data
               WHERE MONTH(date) = $month AND YEAR(date) = $year;";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
         ?>

         <div class="container chart-bar shadow rounded-corners"></div>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
               var data = new google.visualization.arrayToDataTable([
                  ['Price Range', 'Rides in this Range'],
                  ["$1-10", <?php echo $row['1-10']; ?>],
                  ["$10-20", <?php echo $row['10-20']; ?>],
                  ["$20-30", <?php echo $row['20-30']; ?>],
                  ["$30+", <?php echo $row['30+']; ?>]
               ]);

               var options = {
                  colors: ["#C8CCF8"],
                  width: $(window).width()*.7,
                  height: $(window).width()*.7,
                  legend: { position: 'none' },
                  chart: {
                     title: '',
                     subtitle: '' },
                  axes: {
                  x: {
                     0: { side: 'bottom', label: 'Ride Price Range'}
                  }
                  },
                     bar: { groupWidth: "90%" }
                     };

                  var chart = new google.charts.Bar(document.querySelector('.chart-bar'));
                  chart.draw(data, google.charts.Bar.convertOptions(options));
               };
         </script>

         <div class="container chart-title">
            <h2>Frequently visited locations</h2>
         </div>

         <!-- Frequently visited locations -->
         <div class="container frequent-locations shadow rounded-corners">
               <ul class="frequent-locations-ul">
            <?php
               $sql = "SELECT `destination_title`, COUNT(`destination_title`) AS `value_occurrence` FROM `ride_data` WHERE MONTH(date) = $month AND YEAR(date) = $year GROUP BY `destination_title` ORDER BY `value_occurrence` DESC LIMIT 5;";
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
         </div>

      </main>
      <?php include_once 'include/footer.php'; ?>
   </body>
</html>