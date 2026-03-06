<?php
session_start();
session_unset();
session_destroy();

header("Location: /task-manager/auth/login.php");
exit;
