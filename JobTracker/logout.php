<?php require('../includes/config.php');

//include('..classes/user.php);

//logout
$user->logout(); 

//logged in return to index page
//header('Location: ../Reviews/index.php');
header('Location: index.php');
exit;
?>
