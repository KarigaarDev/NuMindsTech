<?php
session_start();
session_unset();
session_destroy();

require '../app/core/helpers.php';
redirect('login');
