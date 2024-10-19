<?php
// Base64 解码加密后的字符串
$ciphertext_base64 = "U2FsdGVkX1+I+tvvemquRYEMNsjvCBQj5X4k/tAgOOq6BHvMqEDGzAQXVvs5Yjbv";
$ciphertext = base64_decode($ciphertext_base64);

// 提取加密使用的盐值，OpenSSL 使用前 8 个字节作为标识，后面 8 个字节为盐值
$salt = substr($ciphertext, 8, 8);

// 实际的密文内容
$encrypted_data = substr($ciphertext, 16);

// 使用的密码
$password = "idspro";

// 密钥和 IV 生成函数
function openssl_get_key_iv($password, $salt) {
    $key_iv = '';
    $last = '';
    // 通过反复哈希生成密钥和 IV，直到满足 48 字节的长度（32 字节密钥 + 16 字节 IV）
    while (strlen($key_iv) < 48) {
        $last = md5($last . $password . $salt, true);
        $key_iv .= $last;
    }
    return $key_iv;
}

// 生成密钥和 IV
$key_iv = openssl_get_key_iv($password, $salt);
$key = substr($key_iv, 0, 32);  // 前 32 字节是密钥
$iv = substr($key_iv, 32, 16);  // 后 16 字节是 IV

// 解密数据
$decrypted = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

echo "解密后的内容: " . $decrypted;
?>
