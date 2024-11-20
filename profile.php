<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("./config/connect.php");
require_once("./config/get_order.php");

$countCart = 0;
$orders = [];

if (!isset($_COOKIE['username'])) {
    header("Location: ./login.php");
    exit;
}

try {
    $username = $_COOKIE['username'];

    // Get user information first
    $userInfoSql = "SELECT A.*, B.*, A.user_id as user_id FROM users A LEFT JOIN address B ON A.user_id = B.user_id WHERE A.username = ?";
    $stmt = $conn->prepare($userInfoSql);
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        throw new Exception("Error retrieving user information: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception("Error getting result: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $userInfo = $result->fetch_assoc();
        $user_id = $userInfo['user_id'];
        $fName = $userInfo['first_name'];
        $lName = $userInfo['last_name'];
        $phone = $userInfo['phone'];
        $email = $userInfo['email'];
        $gender = $userInfo['gender'];
        $birthday = $userInfo['birthday'];
        $pob_id = $userInfo['pob'];
        
        $address = [$userInfo];
        while ($row = $result->fetch_assoc()) {
            $address[] = $row;
        }

        // Get cart count
        $countSql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
        $countStmt = $conn->prepare($countSql);
        if (!$countStmt) {
            throw new Exception("Error preparing cart count query: " . $conn->error);
        }

        $countStmt->bind_param("i", $user_id);
        if ($countStmt->execute()) {
            $countResult = $countStmt->get_result();
            if ($countResult) {
                $row = $countResult->fetch_assoc();
                $countCart = $row['count'];
            }
        }
        $countStmt->close();

        // Get orders with product details
        $orderSql = "SELECT o.*, po.*, p.name as product_name, p.image_url 
                    FROM orders o 
                    LEFT JOIN productorders po ON o.order_id = po.order_id 
                    LEFT JOIN products p ON po.product_id = p.product_id
                    WHERE o.user_id = ? 
                    ORDER BY o.created_at DESC";
        $orderStmt = $conn->prepare($orderSql);
        if (!$orderStmt) {
            throw new Exception("Error preparing order query: " . $conn->error);
        }

        $orderStmt->bind_param("i", $user_id);
        if (!$orderStmt->execute()) {
            throw new Exception("Error executing order query: " . $orderStmt->error);
        }

        $orderResult = $orderStmt->get_result();
        if (!$orderResult) {
            throw new Exception("Error getting order result: " . $orderStmt->error);
        }

        $orders = [];
        while ($row = $orderResult->fetch_assoc()) {
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
            }
        }
        $orderStmt->close();

    } else {
        throw new Exception("User not found");
    }

    $stmt->close();
} catch (Exception $e) {
    error_log("Error in profile.php: " . $e->getMessage());
    die("An error occurred: " . $e->getMessage());
}

$pob_options = [
    1 => 'Hồ Chí Minh',
    2 => 'Hà Nội',
    3 => 'Khánh Hòa',
    4 => 'Đà Nẵng'
];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Boxicons -->
    <link
        href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
        rel="stylesheet" />
    <!-- Glide js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <!-- Header -->
    <header class="header" id="header">
        <!-- Top Nav -->
        <div class="top-nav">
            <div class="container d-flex">
                <p>Đặt hàng online qua: (+84) 090.090.090</p>
                <ul class="d-flex">
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Liện hệ</a></li>
                </ul>
            </div>
        </div>
        <div class="navigation">
            <div class="nav-center container d-flex">
                <a href="/" class="logo">
                    <img src="./images/main-logo.png" alt="">
                </a>

                <ul class="nav-list d-flex">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a href="./product.php" class="nav-link">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a href="#terms" class="nav-link">Điều khoản</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">Về chúng tôi</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Liên hệ</a>
                    </li>
                    <li class="icons d-flex">
                        <a href="./profile.php" class="icon" id="user-icon">
                            <i class="bx bx-user"></i>
                        </a>
                        <div class="icon">
                            <i class="bx bx-search"></i>
                        </div>
                        <div class="icon">
                            <i class="bx bx-heart"></i>
                            <span class="d-flex">0</span>
                        </div>
                        <a onclick="handelLoadCart()" class="icon">
                            <i class="bx bx-cart"></i>
                            <span class="d-flex"><?php echo $countCart ?></span>
                        </a>
                    </li>
                </ul>

                <div class="icons d-flex">
                    <div class="icon" id="user-icon">
                        <a id="user-link" href="./profile.php">
                            <i class="bx bx-user"></i>
                        </a>
                        <div id="user-menu" class="user-menu">
                            <ul>
                                <li><a href="./profile.php">Chỉnh sửa thông tin</a></li>
                                <li><a onclick="handleLogout()">Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="search-icon" class="icon">
                        <i class="bx bx-search"></i>

                        <div id="searchPopup" class="search-popup">
                            <input id="searchInput" type="text" placeholder="Tìm kiếm sản phẩm" oninput="search(this.value)" />
                            <button type="submit">Search</button>

                            <div id="resultsContainer">
                                <div id="search-results" class="search-results">
                                    <!-- Kết quả search hiển thị ở đây -->
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="icon">
                        <i class="bx bx-heart"></i>
                        <span class="d-flex">0</span>
                    </div>
                    <a onclick="handelLoadCart()" class="icon">
                        <i class="bx bx-cart"></i>
                        <span class="d-flex"><?php echo $countCart ?></span>
                    </a>
                </div>

                <div class="hamburger">
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- User Info -->
    <div class="user-info-container">
        <div class="user-info-sidebar">
            <ul>
                <li><a href="#basic-info" class="active">Thông tin cơ bản</a></li>
                <li><a href="#address">Sổ địa chỉ</a></li>
                <li><a href="#orders">Đơn hàng gần đây</a></li>
            </ul>
        </div>
        <div class="user-info-content">
            <section id="basic-info">
                <h2>Thông tin cơ bản</h2>
                <form action="" onsubmit="event.preventDefault(); saveUserInfo();">
                    <!-- load -->
                    <div id="loadingPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0, 0, 0, 0.8); padding: 20px; border-radius: 5px; color: #fff; text-align: center; z-index: 1000;">
                        <p>Đang tải...</p>
                        <div class="loader"></div>
                    </div>

                    <div class="info-row">
                        <div class="profile-detail">
                            <div class="user-info">
                                <div class="field-input-name">
                                    <label for="user-info-fname">Họ và tên đệm*</label>
                                    <input type="text" name="user-info-fname" id="user-info-fname" class="input-control" value="<?= $fName ?>">
                                </div>
                                <div class="field-input-name">
                                    <label for="user-info-lname">Tên*</label>
                                    <input type="text" name="user-info-lname" id="user-info-lname" class="input-control" value="<?= $lName ?>">
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-phone">
                                    <label for="user-info-position">Số điện thoại</label><br>
                                    <input type="text" name="user-info-phone" id="user-info-phone" class="input-control" value="<?= $phone ?>">
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-email">
                                    <label for="user-info-position">Email</label><br>
                                    <input type="text" name="user-info-email" id="user-info-email" class="input-control" value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-gender">
                                    <label for="user-info-position">Giới tính</label><br>
                                    <div>
                                        <p>Nam</p>
                                        <input type="radio" name="user-info-gender" id="user-info-gender" value="Nam" <?php if ($gender == 'Nam') echo 'checked'; ?> class="input-control">
                                    </div>

                                    <div>
                                        <p>Nữ</p>
                                        <input type="radio" name="user-info-gender" id="user-info-gender" value="Nữ" <?php if ($gender == 'Nữ') echo 'checked'; ?> class="input-control">
                                    </div>

                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-birthday">
                                    <label for="user-info-position">Ngày sinh</label><br>
                                    <input type="date" name="user-info-birthday" id="user-info-birthday" class="input-control" value="<?php echo htmlspecialchars($birthday); ?>">
                                </div>

                                <div class="field-input-pob">
                                    <label for="user-info-position">Nơi sinh</label><br>
                                    <select name="user-info-pob" id="user-info-pob"
                                        class="input-control" style="width: 100%;">
                                        <?php foreach ($pob_options as $id => $name): ?>
                                            <option value="<?php echo $id; ?>"
                                                <?php if ($pob_id == $id) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-checkpw">
                                    <label for="user-info-checkpw">Đặt lại mật khẩu</label>
                                    <input type="checkbox" name="user-info-checkpw" id="user-info-checkpw" class="input-control">
                                </div>
                            </div>

                            <div class="user-pass-container">
                                <div class="user-info">
                                    <div class="field-input-old-pass">
                                        <label for="user-info-position">Mật khẩu cũ</label><br>
                                        <input type="password" name="user-info-old-pass" id="user-info-old-pass" class="input-control">
                                    </div>
                                </div>

                                <div class="user-info">
                                    <div class="field-input-new-pass">
                                        <label for="user-info-position">Mật khẩu Mới</label><br>
                                        <input type="password" name="user-info-new-pass" id="user-info-new-pass" class="input-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="button commit-change">
                        <button type="submit">Lưu thay đổi</button>
                    </div>
                </form>
            </section>
            <section id="address">
                <h2>Sổ địa chỉ</h2>
                <button onclick="addAddress()">Thêm địa chỉ mới</button>
                <?php foreach ($address as $item): ?>
                    <div class="address-item">
                        <div class="address-info">
                            <?= $item['street'] . ', ' . $item['ward'] . ', ' . $item['district'] . ', ' . $item['city'] . ', ' . $item['nation'] ?>
                        </div>
                        <div class="address-action">
                            <a href="" class="btn-update">Chỉnh sửa</a>
                            <a href="" class="btn-del">Xóa</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <section id="orders">
                <div id="orders" class="mt-12">
                    <h2>Đơn hàng của bạn</h2>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order_id => $order): ?>
                            <div class="border-t border-gray-200 py-6">
                                <h3 class="text-lg font-semibold text-gray-800">Đơn hàng #<?php echo $order['order_info']['order_id']; ?></h3>
                                <p class="text-gray-600">Ngày đặt: <?php echo $order['order_info']['created_at']; ?></p>
                                <p class="text-gray-600">Tổng tiền: <?php echo number_format($order['order_info']['total_price'], 2); ?> đ</p>
                                <p class="text-gray-600">Trạng thái: <?php echo $order['order_info']['status']; ?></p>

                                <h4 class="mt-4 font-semibold">Sản phẩm trong đơn hàng:</h4>
                                <ul class="space-y-2">
                                    <?php foreach ($order['items'] as $product): ?>
                                        <li class="flex p-4 bg-gray-50 rounded-lg gap-20">
                                            <img src="./images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-16 h-16 object-cover">
                                            <div>
                                                <strong class="text-gray-800"><?php echo htmlspecialchars($product['name']); ?></strong><br>
                                                <span class="text-gray-600">Số lượng: <?php echo $product['quantity']; ?></span><br>
                                            </div>

                                            <div class="ml-auto text-right">
                                                <span class="text-gray-600">Giá: <?php echo number_format($product['price'], 2); ?> đ</span>
                                            </div>
                                        </li>

                                        <?php if ($order['order_info']['status'] == 'delivered'): ?>
                                            <div class="mt-4">
                                                <form action="./config/submit_review.php" method="POST">
                                                    <h5 class="font-semibold">Đánh giá sản phẩm</h5>
                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_info']['order_id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                                                    <!-- Hiển thị đánh giá sao -->
                                                    <div class="rating-stars">
                                                        <input type="hidden" name="rating" id="rating-<?php echo $product['product_id']; ?>" value="0">
                                                        <span class="star" data-value="1">★</span>
                                                        <span class="star" data-value="2">★</span>
                                                        <span class="star" data-value="3">★</span>
                                                        <span class="star" data-value="4">★</span>
                                                        <span class="star" data-value="5">★</span>
                                                    </div>

                                                    <label for="comment-<?php echo $product['product_id']; ?>">Nhận xét:</label>
                                                    <textarea name="comment" id="comment-<?php echo $product['product_id']; ?>" class="form-control" rows="2"></textarea>

                                                    <button type="submit" name="submit_review" class="btn btn-primary mt-2">Gửi đánh giá</button>
                                                </form>
                                            </div>
                                            <style>
                                                .rating-stars {
                                                    gap: 5px;
                                                }

                                                .rating-stars .star {
                                                    font-size: 1.5em;
                                                    cursor: pointer;
                                                    color: #ccc;
                                                    margin-right: 20px;
                                                    position: relative;
                                                }

                                                .rating-stars .star.selected {
                                                    color: #ffc107;
                                                }
                                            </style>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-600">Không có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="row">
            <div class="col d-flex">
                <h4>THÔNG TIN</h4>
                <a href="">Về chúng tôi</a>
                <a href="">Liên hệ</a>
                <a href="">Điều khoản & dịch vụ</a>
                <a href="">Vận chuyển</a>
            </div>
            <div class="col d-flex">
                <h4>LIÊN KẾT</h4>
                <a href="">Cửa hàng trực tuyến</a>
                <a href="">Dịch vụ khách hàng</a>
                <a href="">Khuyến mãi</a>
                <a href="">Top bán chạy</a>
            </div>
            <div class="col d-flex">
                <span><i class='bx bxl-facebook-square'></i></span>
                <span><i class='bx bxl-instagram-alt'></i></span>
                <span><i class='bx bxl-github'></i></span>
                <span><i class='bx bxl-twitter'></i></span>
                <span><i class='bx bxl-pinterest'></i></span>
            </div>
        </div>
    </footer>


</body>
<script src="./js/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
<script src="./js/slider.js"></script>

</html>