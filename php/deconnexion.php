<?php
//cette page permet de simplement déconnecter son compte 
session_start();
session_destroy();
header("Location: index.php");
?> 
