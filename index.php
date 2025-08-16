<?php
header('Content-Type: application/json');

// Oldindan belgilangan user
$validUser = [
    "username" => "1334440087",
    "password" => "AiemA43f",
    "country"  => "UZ",
    "currency" => "UZS",
    "balance"  => 5000
];

// Endpointni olish
$endpoint = $_GET['endpoint'] ?? null;

// So‘rovni olish (JSON yoki POST)
$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    $input = $_POST;
}

switch ($endpoint) {
    case "auth":
        $username = $input['username'] ?? null;
        $password = $input['password'] ?? null;

        if ($username === $validUser['username'] && $password === $validUser['password']) {
            echo json_encode([
                "status"   => "ok",
                "username" => $validUser['username'],
                "balance"  => $validUser['balance'],
                "currency" => $validUser['currency'],
                "country"  => $validUser['country']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Check entered data"]);
        }
        break;

    case "balance":
        echo json_encode([
            "status"   => "ok",
            "username" => $validUser['username'],
            "balance"  => $validUser['balance'],
            "currency" => $validUser['currency']
        ]);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Noto‘g‘ri endpoint"]);
}
