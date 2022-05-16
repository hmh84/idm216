<!-- 
░░░▒█ █▀▀ █▀▀█ ▀█░█▀ █▀▀█ 　 ░░░▒█ █▀▀█ █░░░█ █▀▀▄ █▀▀ 
░▄░▒█ █▀▀ █▄▄▀ ░█▄█░ █░░█ 　 ░▄░▒█ █▄▄█ █▄█▄█ █░░█ ▀▀█ 
▒█▄▄█ ▀▀▀ ▀░▀▀ ░░▀░░ ▀▀▀▀ 　 ▒█▄▄█ ▀░░▀ ░▀░▀░ ▀░░▀ ▀▀▀
-->
<?php include_once 'include/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Init -->
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Styles -->
    <link rel="stylesheet" href="assets\css\normalize.css">
    <link rel="stylesheet" href="assets\css\prototype-shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <?php if (!isset($page_specific_style)) {} else { echo '<link rel="stylesheet" href="'.$page_specific_style.'">'; }; // Page Specific Style ?>
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <?php if ($page_title == 'Month at Glance' || $page_title == 'Year at Glance') { ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php } ?>
    <script src="assets/js/main.js" defer></script>
    <script src="assets/js/prototype.js" defer></script>
    <?php if (isset($is_map)) : echo '<!-- add google map stuff on home page-->'; include_once 'include/key.php'; endif ?>
    <script>const page_title = '<?php echo $page_title ?>';</script>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicons/favicon-16x16.png">
</head>