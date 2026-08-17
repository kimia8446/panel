<?php

require_once __DIR__ . '/config/database.php';

$file = fopen('users_200_for_import.csv', 'r');

if (!$file) {
    die("فایل CSV پیدا نشد.");
}

// رد کردن خط اول که عنوان ستون‌هاست
fgetcsv($file);

$success = 0;
$duplicate = 0;

while (($row = fgetcsv($file)) !== false) {

    $username = trim($row[0]);
    $phone = trim($row[1]);
    $password = $row[2];

    $check = $conn->prepare(
        "SELECT id FROM users
         WHERE username = :username
         OR phone = :phone"
    );

    $check->execute([
        "username" => $username,
        "phone" => $phone
    ]);

    if ($check->fetch()) {
        $duplicate++;
        continue;
    }

    // تبدیل رمز به hash
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // ذخیره کاربر
    $stmt = $conn->prepare(
        "INSERT INTO users (username, phone, password)
         VALUES (:username, :phone, :password)"
    );

    $stmt->execute([
        "username" => $username,
        "phone" => $phone,
        "password" => $hashedPassword
    ]);

    $success++;
}

fclose($file);

echo "Import با موفقیت انجام شد.<br>";
echo "تعداد کاربران اضافه شده: " . $success . "<br>";
echo "تعداد کاربران تکراری: " . $duplicate;

