<?php

setcookie('un', '', time() - 60 * 60 * 24, '/');
setcookie('pw', '', time() - 60 * 60 * 24, '/');
setcookie('time', '', time() - 60 * 60 * 24, '/');

header("Location: home.php");
exit();