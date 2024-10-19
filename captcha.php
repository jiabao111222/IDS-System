<?php
if (isset($_POST['g-recaptcha-response'])) {
    $secret = '6LeM8jcqAAAAAEq1OSU0PbUUgOWTzCTQNHTWm5aS';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false) {
        echo "You're a robot!";
    } else {
        echo "You're a human!";
        // 继续处理登录逻辑
    }
}
?>
