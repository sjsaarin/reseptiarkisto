<?php

include "libs/naytavirheet.php";
echo '<br>';
echo 'Current PHP version: ' . phpversion();
echo '<br>';
$password = "foopassword";
echo 'Salasana ennen hashausta: ' . $password;
echo '<br>';
echo 'onko blowfish? '. CRYPT_BLOWFISH;
echo '<br>';
function luoHash($password) {
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2a$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        echo 'suola: ' . $salt;
        return crypt($password, $salt);
    }
}
echo '<br>';
$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
echo 'hashi' . crypt($password, $salt);
echo '<br>';
$hash = luoHash($password);
echo 'hashattuna: ' . $hash;
echo '<br>';
function verify($password, $hashedPassword) {
    return crypt($password, $hashedPassword) == $hashedPassword;
}

echo 'vastaako? ' . verify($password, $hash);
echo '<br>';
echo 'Blowfish:     ' . crypt('rasmuslerdorf', '$2a$07$usesomesillystringforsalt$') . "\n";