<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // 处理 OPTIONS 请求
}

// 获取原始 POST 数据
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['decodedData'])) {
    $decodedData = $data['decodedData'];
    $response = [
        'success' => true,
        'message' => 'QR Code decoded successfully. Data: ' . $decodedData
    ];
} else {
    $response = [
        'success' => false,
        'error' => 'No decoded data received.'
    ];
}

echo json_encode($response);
?>

