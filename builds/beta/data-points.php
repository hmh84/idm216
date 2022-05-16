<?php // Head
    $page_title = 'Data Points';
    include_once 'include/head.php';
?>
<body>
    <?php
        if ((!isset($_GET['month'])) && (!isset($_GET['year']))) {
            // If date is not specified, set default values
            echo 'date not set';
            $month = 5;
            $year = 2020;
        } else {
            // If date is set, parse it and set variables $month and $year to the date's value
            $month = $_GET['month'];
            $year = $_GET['year'];
            echo 'date = '.$month.'-'.$year;
        }
    ?>
    <section>
    <div class="range-input-wrap">
            <form action="data-points.php" method="get">
                <input type="number" name="month" required value="<?php echo $month ?>" min='1' max="12">
                <input type="year" name="year" required value="<?php echo $year ?>">
                <button type="submit">Set Date</button>
            </form>
    </div>
    </section>
    <main>
        <section>
            <h1>Month Ride History - Limited to 3 on purpose</h1>
            <?php

                $sql = "SELECT * FROM ride_data
                WHERE MONTH(date) = $month AND YEAR(date) = $year
                ORDER BY date DESC LIMIT 3;";

                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $orig_date = $row['date'];
                        $new_date = date("m/d/y", strtotime($orig_date));  

                    echo "<div class='card'>";
                    echo "<div class='card-img-area'>";
                    echo "<img class='driver-img' src='assets/img/driver_profile_pictures/{$row['driver_img']}' alt='{$row['driver']}'>";
                    echo "<p class='driver-name'>{$row['driver']}</p>";
                    echo "</div>";
                    echo "<div class='card-mid-area'>";
                    echo "<div class='mid-area-top'";
                    echo "<h2 class='ride-timestamp'>{$new_date} | {$row['time']}</h2>";
                    echo "<p class='ride-distance-and-duration'>{$row['distance']}mi | {$row['duration']}mins</p>";
                    echo "</div>";
                    echo "<div class='mid-area-btm'>";
                    echo "<p class='ride-start'>{$row['pickup']}</p>";
                    echo "<p class='ride-end'>{$row['destination_address']}</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='card-end-area'>";
                    echo "<h2 class='ride-price'>{$row['price']}</h2>";
                    echo "</div>";
                    echo "</div>";

                    }
                } else {
                    echo 'No data to display!';
                }
            ?>

        </section>
        <!-- Month at a Glance Data -->
        <h1>Month at a Glance Metrics</h1>

            <section>
                <?php
                    // Month Spent price_Sum (NEEDS WHERE MONTH = mm)
                    $sql = "SELECT SUM(price) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/money.svg' alt='Money'>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Total spent this month</p>
                            <h2 class='glance-figure'><?php echo '$'.$row['value_sum'] ?></h2>
                    </div>
                    
            </section>
            <section>

                <?php
                    // Total Rides
                    $sql = "SELECT COUNT(ride_id) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/car.svg' alt=''>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Total rides taken this month</p>
                            <h2 class='glance-figure'><?php echo $row['value_sum'].' rides' ?></h2>
                    </div>

            </section>
            <section>

                <?php
                    // Average Cost
                    $sql = "SELECT AVG(price) AS value_avg FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/car-building.svg' alt=''>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Average cost per Ride</p>
                            <h2 class='glance-figure'><?php echo '$'.number_format((float)$row['value_avg'], 2, '.', ''); ?></h2>
                    </div>

            </section>
            <section>

                <?php
                    // Average Distance
                    $sql = "SELECT AVG(distance) AS value_avg FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/route.svg' alt=''>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Average distance per Ride</p>
                            <h2 class='glance-figure'><?php echo number_format((float)$row['value_avg'], 2, '.', '').' mi'; ?></h2>
                    </div>

            </section>
            <section>

                <?php
                    // Most Common Ride Type
                    
                    $sql = "SELECT `type`, COUNT(`type`) AS `value_occurrence` FROM `ride_data` WHERE MONTH(date) = $month AND YEAR(date) = $year GROUP BY `type` ORDER BY `value_occurrence` DESC LIMIT 1;";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/two-cars.svg' alt=''>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Most common ride type</p>
                            <h2 class='glance-figure'><?php echo ucwords($row['type']); ?></h2>
                    </div>

            </section>
            <section>

                <?php
                    // Coupon Sum
                    $sql = "SELECT SUM(discount) AS value_sum FROM ride_data WHERE MONTH(date) = $month AND YEAR(date) = $year";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class='glance-card'>
                        <div class='glance-icon-area'>
                            <img class='black_svg' src='assets/svg/coupon.svg' alt=''>
                        </div>
                        <div class='glance-content'>
                            <p class='glance-title'>Total coupon & promo savings</p>
                            <h2 class='glance-figure'><?php echo '$'.$row['value_sum'] ?></h2>
                    </div>

            </section>
            <section>
                <!-- Most Frequent Ride Pie Chart -->
                <?php
                
                    // Frequently visited locations
                    $sql = "SELECT `type`, COUNT(*) AS `value_occurrence` FROM `ride_data` WHERE MONTH(date) = $month AND YEAR(date) = $year GROUP BY `type`;";
                    $result = mysqli_query($connection, $sql);
                
                ?>

                <h1>Most common ride type</h1>

                    <div class="piechart"></div>
                                    
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
                        var options = {'title':'Most Common Ride Type', 'width':550, 'height':400};
                    
                        // Display the chart inside the <div> element with id="piechart"
                        var chart = new google.visualization.PieChart(document.querySelector('.piechart'));
                        chart.draw(data, options);
                    }
                    </script>
            </section>
            <section>
                    <!-- Google Column Chart JS https://developers.google.com/chart/interactive/docs/gallery/columnchart -->

                    <?php
                        $sql =
                            "SELECT 
                            SUM(CASE WHEN price BETWEEN 1  AND 5  THEN 1 ELSE 0 END) AS '1-5',
                            SUM(CASE WHEN price BETWEEN 6  AND 10 THEN 1 ELSE 0 END) AS '6-10',
                            SUM(CASE WHEN price BETWEEN 11 AND 15 THEN 1 ELSE 0 END) AS '11-15',
                            SUM(CASE WHEN price BETWEEN 16 AND 20 THEN 1 ELSE 0 END) AS '16-20',
                            SUM(CASE WHEN price >= 20 THEN 1 ELSE 0 END) AS '20+'
                            FROM ride_data
                            WHERE MONTH(date) = $month AND YEAR(date) = $year;";
                        $result = mysqli_query($connection, $sql);
                        $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="chart-bar" style="width: 800px; height: 600px;"></div>

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawStuff);

                        function drawStuff() {
                            var data = new google.visualization.arrayToDataTable([
                                ['Range', 'Occurrence'],
                                ["$1-5", <?php echo $row['1-5']; ?>],
                                ["$6-10", <?php echo $row['6-10']; ?>],
                                ["$11-15", <?php echo $row['11-15']; ?>],
                                ["$16-20", <?php echo $row['16-20']; ?>],
                                ["$20+", <?php echo $row['20+']; ?>]
                            ]);

                        var options = {
                            width: 800,
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

                            var chart = new google.charts.Bar(document.querySelector('.chart-bar'));
                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        };
                            </script>
                            
            </section>
            <section>

                <div class="frequent-locations-wrapper">
                    <h1>Frequently visited locations</h1>
                    <ul class="frequent-locations-ul">
                <?php
                    // Frequently visited locations
                    $sql = "SELECT `destination_title`, COUNT(`destination_title`) AS `value_occurrence` FROM `ride_data` GROUP BY `destination_title` ORDER BY `value_occurrence` DESC LIMIT 5;";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $num = 1;
                        while ($row = mysqli_fetch_array($result)) {
                ?>

                            <li class="frequent-locations-li">
                                <div class="frequent-list-num-area">
                                    <h3 class="frequent-nums"><?php echo ($num++).'.'; ?></h3>
                                </div>
                                <div class="frequent-list-main-area">
                                    <h3><?php echo $row['destination_title']; ?></h3>
                                    <p>You visited this location <?php echo $row['value_occurrence']; ?> times this month</p>
                                </div>
                            </li>

                <?php
                        }
                    }
                ?>

                </ul>
                </div>

            </section>
            
            <?php
                // Trash all variables
                foreach(get_defined_vars() as $k => $v)
                unset($$k);
                unset($k, $v);
            ?>
    </main>
</body>
<style>
    .card {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        background-color: whitesmoke;
        width: 100%;
        max-width: 25rem;
        border-radius: 1rem;
        margin: 1rem;
        padding: .5rem;
    }

    .card-img-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: .5rem;
        width: 25%;
    }

    .card-mid-area {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 50%;
        padding: .5rem;
    }

    .card-end-area {
        padding: .5rem;
        display: flex;
        width: 25%;
    }

    .driver-img {
        width: 5rem;
        border-radius: 50%;
    }

    /* At a glance */

    .glance-card:nth-of-type(even) {
        background: #eec0c6 linear-gradient(315deg, #eec0c6 0%, #7ee8fa 74%);
    }

    .glance-card:nth-of-type(odd) {
        background: #eec0c6 linear-gradient(315deg, #eec0c6 0%, #7ee8fa 74%);
    }

    .glance-card {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        width: 100%;
        max-width: 25rem;
        border-radius: 1rem;
        margin: 1rem;
        padding: .5rem;
    }

    .glance-icon-area {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 30%;
    }

    .glance-content {
        display: flex;
        flex-direction: column;
        background-color: white;
        width: 70%;
        padding: .5rem;
        border-radius: 0 1rem 1rem 0;
    }

    .black_svg {
        filter: invert(1);
        width: 3rem;
    }

    .glance-title, .glance-figure {
        margin: .5rem;
    }

    /* Frequent Locations */

    .frequent-locations-wrapper {
        width: 100%;
        max-width: 30rem;
        margin: 1rem;
    }

    .frequent-locations-ul {
        display: flex;
        flex-direction: column;
        list-style: none;
        background-color: whitesmoke;
        border-radius: 3rem;
    }

    .frequent-locations-li {
        display: flex;
        flex-direction: row;
    }

    .frequent-list-num-area {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 15%;
    }

    .frequent-list-main-area {
        display: flex;
        flex-direction: column;
        width: 75%;
        border-bottom: pink solid;
    }

    .frequent-nums {
        color: blue;
    }



</style>
</html>