<?php
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($db->connect_errno) {
    printf('Connect failed %s\n', $db->connect_error);
    exit;
}