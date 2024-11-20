<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . "/connect.php");

if (isset($_COOKIE['username'])) {
    try {
        $username = $_COOKIE['username'];
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Error preparing user query: " . $conn->error);
        }
        
        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            throw new Exception("Error executing user query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        if (!$result || $result->num_rows === 0) {
            throw new Exception("User not found");
        }
        
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];
        $stmt->close();

        // First, let's check what products are in the orders
        $checkSql = "SELECT p.product_id, p.name, p.image_url 
                    FROM orders o
                    JOIN productorders po ON o.order_id = po.order_id
                    JOIN products p ON po.product_id = p.product_id
                    WHERE o.user_id = ?";
        
        $checkStmt = $conn->prepare($checkSql);
        if (!$checkStmt) {
            throw new Exception("Error preparing check query: " . $conn->error);
        }
        
        $checkStmt->bind_param("i", $user_id);
        if (!$checkStmt->execute()) {
            throw new Exception("Error executing check query: " . $checkStmt->error);
        }
        
        $checkResult = $checkStmt->get_result();
        while ($row = $checkResult->fetch_assoc()) {
            error_log("Product in order - ID: " . $row['product_id'] . ", Name: " . $row['name'] . ", Image: " . $row['image_url']);
        }
        $checkStmt->close();

        // Now get the full order details
        $ordersSql = "
            SELECT o.*, po.*, p.name as product_name, p.image_url, p.description
            FROM orders o
            LEFT JOIN productorders po ON o.order_id = po.order_id
            LEFT JOIN products p ON po.product_id = p.product_id
            WHERE o.user_id = ?
            ORDER BY o.created_at DESC
        ";
        
        $stmt = $conn->prepare($ordersSql);
        if (!$stmt) {
            throw new Exception("Error preparing orders query: " . $conn->error);
        }
        
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Error executing orders query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error getting orders result: " . $stmt->error);
        }

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orderId = $row['order_id'];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_info' => [
                        'order_id' => $row['order_id'],
                        'created_at' => $row['created_at'],
                        'total_price' => $row['total_price'],
                        'status' => $row['status']
                    ],
                    'items' => []
                ];
            }
            if ($row['product_id']) {
                $orders[$orderId]['items'][] = [
                    'product_id' => $row['product_id'],
                    'name' => $row['product_name'],
                    'image_url' => $row['image_url'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price']
                ];
                error_log("Added product to order {$orderId} - Name: {$row['product_name']}, Image: {$row['image_url']}");
            }
        }
        $stmt->close();

    } catch (Exception $e) {
        error_log("Error in get_order.php: " . $e->getMessage());
        $orders = [];
    }
} else {
    $orders = [];
}
?>
