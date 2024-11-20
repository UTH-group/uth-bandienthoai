<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/opt/lampp/logs/php_error_log');

// Start session at the very beginning
session_start();

require_once(__DIR__ . "/connect.php");
require_once(__DIR__ . "/../vendor/autoload.php");
require_once("./send_email_order.php");

try {
    // Validate session ID
    if (!isset($_GET['session_id'])) {
        error_log("Missing session_id parameter");
        die("Session ID không hợp lệ.");
    }

    // Validate username cookie
    if (!isset($_COOKIE['username'])) {
        error_log("Missing username cookie");
        die("Username không hợp lệ.");
    }

    // Log session data for debugging
    error_log("Session data: " . print_r($_SESSION, true));
    
    $stripe_secret_key = 'sk_test_51PtpAPGH56JC4HtHnS2pPQN0207Y20xnDYaKzeHgcJsojH5HEyl5KvyHSSiUV4hXgbNSOFL4B1WhCTCXnNDkDhjc00u8nHYvhC';
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $session_id = $_GET['session_id'];
    error_log("Processing Stripe session: " . $session_id);
    
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    error_log("Stripe session status: " . $session->payment_status);
    
    if ($session->payment_status == 'paid') {
        $username = $_COOKIE['username'];
        
        // Use prepared statements to prevent SQL injection
        $userInfoStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if (!$userInfoStmt) {
            error_log("Failed to prepare user info statement: " . $conn->error);
            die("Database error");
        }
        
        $userInfoStmt->bind_param("s", $username);
        if (!$userInfoStmt->execute()) {
            error_log("Failed to execute user info query: " . $userInfoStmt->error);
            die("Database error");
        }
        
        $userInfoResult = $userInfoStmt->get_result();
        $userInfo = $userInfoResult->fetch_assoc();
        
        if (!$userInfo) {
            error_log("User not found: " . $username);
            die("User không tồn tại.");
        }
        
        $user_id = $userInfo['user_id'];
        error_log("Processing order for user_id: " . $user_id);
        
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Insert order using prepared statement - Note the lowercase table name 'orders'
            $orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
            if (!$orderStmt) {
                throw new Exception("Failed to prepare order statement: " . $conn->error);
            }
            
            $totalAmount = $session->amount_total;
            $orderStmt->bind_param("id", $user_id, $totalAmount);
            
            if (!$orderStmt->execute()) {
                throw new Exception("Failed to insert order: " . $orderStmt->error);
            }
            
            $order_id = $conn->insert_id;
            error_log("Created order_id: " . $order_id);
            
            // Validate product list in session
            if (!isset($_SESSION['productList'])) {
                error_log("Product list not found in session");
                throw new Exception("Danh sách sản phẩm không tồn tại trong session.");
            }
            
            $productListString = $_SESSION['productList'];
            error_log("Product list: " . $productListString);
            
            if (empty($productListString)) {
                throw new Exception("Danh sách sản phẩm trống.");
            }
            
            // Process products
            $products = explode('|', $productListString);
            foreach ($products as $product) {
                $attributes = explode('\\', $product);
                if (count($attributes) < 8) {
                    error_log("Invalid product data: " . print_r($attributes, true));
                    throw new Exception("Dữ liệu sản phẩm không hợp lệ.");
                }
                
                $productId = $attributes[2];
                $quantity = $attributes[3];
                $price = $attributes[7];
                
                // Insert product order - Note the lowercase table name 'productorders'
                $productOrderStmt = $conn->prepare("INSERT INTO productorders (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                if (!$productOrderStmt) {
                    throw new Exception("Failed to prepare product order statement: " . $conn->error);
                }
                
                $productOrderStmt->bind_param("iiid", $order_id, $productId, $quantity, $price);
                if (!$productOrderStmt->execute()) {
                    throw new Exception("Failed to insert product order: " . $productOrderStmt->error);
                }
                
                // Update stock - Note the lowercase table name 'products'
                $updateStockStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
                if (!$updateStockStmt) {
                    throw new Exception("Failed to prepare stock update statement: " . $conn->error);
                }
                
                $updateStockStmt->bind_param("ii", $quantity, $productId);
                if (!$updateStockStmt->execute()) {
                    throw new Exception("Failed to update stock: " . $updateStockStmt->error);
                }
            }
            
            // Delete cart
            $delCartStmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            if (!$delCartStmt) {
                throw new Exception("Failed to prepare cart delete statement: " . $conn->error);
            }
            
            $delCartStmt->bind_param("i", $user_id);
            if (!$delCartStmt->execute()) {
                throw new Exception("Failed to delete cart: " . $delCartStmt->error);
            }
            
            // Commit transaction
            $conn->commit();
            error_log("Transaction committed successfully");
            
            // Send confirmation email
            $orderDetails = [
                'order_id' => $order_id,
                'invoice_symbol' => 'INV-' . $order_id,
                'invoice_number' => $order_id,
                'invoice_date' => date('Y-m-d'),
                'customer_name' => $username,
                'tax_id' => '1234567890'
            ];
            
            try {
                $products = getProductsByOrderId($order_id, $conn);
                sendOrderConfirmationEmail($userInfo['email'], $orderDetails, $products);
                error_log("Confirmation email sent successfully");
            } catch (Exception $e) {
                error_log("Failed to send confirmation email: " . $e->getMessage());
                // Don't throw the exception here as the order is already processed
            }
            
            // Clear session data
            unset($_SESSION['productList']);
            
            header("Location: ../success_page.php");
            exit;
            
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Transaction failed: " . $e->getMessage());
            die("Lỗi khi xử lý đơn hàng: " . $e->getMessage());
        }
    } else {
        error_log("Payment not completed. Status: " . $session->payment_status);
        die("Thanh toán không thành công. Vui lòng thử lại.");
    }
} catch (Exception $e) {
    error_log("Error processing Stripe session: " . $e->getMessage());
    die("Lỗi khi xử lý phiên Stripe: " . $e->getMessage());
}
