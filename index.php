<?php
header("Content-Type: application/json");

// --- Database ulanish (agar kerak bo‘lsa) ---
// $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");

// So‘rov endpointini aniqlash
$endpoint = $_GET['endpoint'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($endpoint) {

    // 🔹 Registration
    case "register":
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        $country  = $data['country'] ?? "UZ";
        $currency = $data['currency'] ?? "сўм";

        if ($username && $password) {
            // DB saqlash mumkin, hozircha faqat javob
            echo json_encode([
                "status" => "ok",
                "message" => "User registered",
                "username" => $username,
                "balance" => 0,
                "currency" => $currency,
                "country"  => $country
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Missing fields"]);
        }
        break;

    // 🔹 Authentication
    case "auth":
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        // oddiy tekshiruv
        if ($username && $password) {
            echo json_encode([
                "status" => "ok",
                "message" => "User authenticated",
                "token"   => md5($username.time()),
                "balance" => 100  // misol uchun
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
        }
        break;

    // 🔹 Get Balance
    case "balance":
        $user_id = $data['user_id'] ?? null;

        if ($user_id) {
            echo json_encode([
                "status" => "ok",
                "user_id" => $user_id,
                "balance" => 0,
                "currency" => "сўм"
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Missing user_id"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Unknown endpoint"]);
        break;
}
