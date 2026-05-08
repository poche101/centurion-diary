<?php

putenv('OPENSSL_CONF=C:\\php-8.4.13\\extras\\ssl\\openssl.cnf');

$config = [
    'curve_name' => 'prime256v1',
    'private_key_type' => OPENSSL_KEYTYPE_EC,
    'config' => 'C:\\php-8.4.13\\extras\\ssl\\openssl.cnf',
];

$key = openssl_pkey_new($config);

if (!$key) {
    echo "OpenSSL error: " . openssl_error_string() . "\n";
    exit(1);
}

$details = openssl_pkey_get_details($key);

$privateKey = base64_encode($details['ec']['d']);
$publicKey  = base64_encode("\x04" . $details['ec']['x'] . $details['ec']['y']);

$privateKey = rtrim(strtr($privateKey, '+/', '-_'), '=');
$publicKey  = rtrim(strtr($publicKey,  '+/', '-_'), '=');

echo "VAPID_PUBLIC_KEY={$publicKey}\n";
echo "VAPID_PRIVATE_KEY={$privateKey}\n";
