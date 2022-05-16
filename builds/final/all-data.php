<?php // Head
    $page_title = 'All Data';
    include_once 'include/head.php';
?>
<body>
    <table>
        <thead>
            <tr>
                <th colspan='13'>All Ride Data</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ride_id</td>
                <td>date</td>
                <td>time</td>
                <td>price</td>
                <td>distance</td>
                <td>duration</td>
                <td>discount</td>
                <td>type</td>
                <td>pickup</td>
                <td>destination_address</td>
                <td>destination_title</td>
                <td>driver</td>
                <td>driver_img</td>
            </tr>
    <?php
        include_once 'include/db.php';
        $sql = "SELECT * FROM ride_data;";
        $result = mysqli_query($connection, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                        echo "<tr>";
                            echo "<td>{$row['ride_id']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['time']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td>{$row['distance']}</td>";
                            echo "<td>{$row['duration']}</td>";
                            echo "<td>{$row['discount']}</td>";
                            echo "<td>{$row['type']}</td>";
                            echo "<td>{$row['pickup']}</td>";
                            echo "<td>{$row['destination_address']}</td>";
                            echo "<td>{$row['destination_title']}</td>";
                            echo "<td>{$row['driver']}</td>";
                            echo "<td>{$row['driver_img']}</td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "There is no data to display..";
                }
    ?>

                </tbody>
            </table>
            <?php include_once 'include/footer.php'; ?>
</body>
<style>
    table {
        width: 100%;
    }

    table tr:nth-child(odd) td {
        background-color: #e2e2e2;
    }
    table tr:nth-child(even) td {
        background-color: #fff;
    }   
</style>
</html>