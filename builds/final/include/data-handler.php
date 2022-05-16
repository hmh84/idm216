<?php
    if ((!isset($_GET['month'])) && (!isset($_GET['year']))) { // If date is not specified, set default values
        $month = 8;
        $year = 2020;
    } else { // If date is set, parse it and set variables $month and $year to the date's value
        $month = $_GET['month'];
        $year = $_GET['year'];
    }
    
    // Check if inputted date is below table data range, if not, set it to minimum range + 1 month
    
    $monthObj = DateTime::createFromFormat('!m', $month); // Turns month # into object, '!m' declares it as a month type
    $monthName_3L = $monthObj->format('M'); // Converts object into name, 'M' is the format for a 3 letter month name, 'F' is full name
    $monthName_Full = $monthObj->format('F'); // Converts object into name, 'M' is the format for a 3 letter month name, 'F' is full name
?>