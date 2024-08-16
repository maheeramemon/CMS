<?php
session_start();
session_destroy();
echo 'You have been logged out. <a href="Login.php">Go back</a>';