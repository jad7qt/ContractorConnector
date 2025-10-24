<?php

session_start();

session_unset();

session_destroy();

header("Location: login"); // WHERE THE USER IS DIRECTED TO AFTER LOGOUT
?>