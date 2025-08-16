<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : null;

// Demo userlar
$users = [
    "1334440087" => [
        "password" => "AiemA43f",
        "country"  => "UZ",
        "currency" => "UZS",
        "balance"  => 9999999999
    ]
];

switch ($endpoint) {
    case "register":
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password) {
            echo json_encode(["status"=>"error","message"=>"username yoki password yo'q"]);
            exit();
        }

        if (isset($users[$username])) {
            echo json_encode(["status"=>"error","message"=>"foydalanuvchi allaqachon mavjud"]);
            exit();
        }

        $users[$username] = [
            "password"=>$password,
            "country"=>"UZ",
            "currency"=>"UZS",
            "balance"=>9999999999
        ];

        echo json_encode([
            "status"=>"ok",
            "user_id"=>$username,
            "balance"=>9999999999,
            "currency"=>"UZS",
            "country"=>"UZ"
        ]);
        break;

    case "auth":
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password || !isset($users[$username])) {
            echo json_encode(["status"=>"error","message"=>"login xato"]);
            exit();
        }

        if ($users[$username]['password'] !== $password) {
            echo json_encode(["status"=>"error","message"=>"parol xato"]);
            exit();
        }

        echo json_encode([
            "status"=>"ok",
            "user_id"=>$username,
            "balance"=>$users[$username]['balance'],
            "currency"=>$users[$username]['currency'],
            "country"=>$users[$username]['country']
        ]);
        break;

    case "balance":
        $username = $_GET['user'] ?? null;
        if (!$username || !isset($users[$username])) {
            echo json_encode(["status"=>"error","message"=>"user topilmadi"]);
            exit();
        }

        echo json_encode([
            "status"=>"ok",
            "user_id"=>$username,
            "balance"=>$users[$username]['balance'],
            "currency"=>$users[$username]['currency'],
            "country"=>$users[$username]['country']
        ]);
        break;

    case "refresh":
        echo json_encode([
            "status"=>"ok",
            "message"=>"token yangilandi"
        ]);
        break;

    default:
        echo json_encode([
            "status"=>"error",
            "message"=>"noto'g'ri endpoint"
        ]);
}
