<?php

    session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="app.css">
    <title>logging system- pure PHP</title>
</head>

<body>

<?php

    echo "<p>Hello ".$_SESSION['user']." <a href='logout.php'>[ Logout ]</a>"."!</p>";
    echo "<p><b>Drewno</b>: ".$_SESSION['drewno'];
    echo " | <b>Kamień</b>: ".$_SESSION['kamien'];
    echo " | <b>Zboże</b>: ".$_SESSION['zboze'];

    echo "<br /><br /><b>E-mail</b>: ".$_SESSION['email'];
    echo "<br /><b>Dni premium</b>: ".$_SESSION['dnipremium']."</p>";

?>

</body>
</html>


