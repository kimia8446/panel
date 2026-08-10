<?php 
include ("config/database.php");
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit('شناسه نامعتبر است');
}
$sql = "DELETE FROM product WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->execute([$id]);
//$result = $stmt->get_result();
header("location:products.php");
exit;
?>
