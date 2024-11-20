<?php
session_start();
require_once("./config/connect.php");
require_once('../config/auth.php');
?>
<!doctype html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--  Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Quản lý sản phẩm</title>
</head>
<div>
    <button type="button" onclick="handleLogout()" name="delete_product" class="btn btn-danger btn-sm">Đăng xuất</button>
    <div class="container mt-4">

        <?php include('./config/message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Quản lý sản phẩm
                            <a href="addsanpham.php" class="btn btn-primary float-end">Thêm sản phẩm</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Giảm giá</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM products";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $products) {
                                ?>
                                        <tr>
                                            <td><?= $products['product_id']; ?></td>
                                            <?php if (isset($products['image_url']) && !empty($products['image_url'])): ?>
                                                <td>
                                                    <img class="w-25 h-25" src="../images/<?= $products['image_url'] ?>" alt="">
                                                </td>
                                            <?php else: ?>
                                                <td>
                                                    <p>Chưa có hình ảnh</p>
                                                </td>
                                            <?php endif; ?>

                                            <td><?= $products['name']; ?></td>
                                            <td>
                                                <?php
                                                $description = $products['description'];

                                                if (strlen($description) > 30) {
                                                    echo '<span class="short-text">' . substr($description, 0, 30) . '...</span>';
                                                    echo '<span class="full-text" style="display: none;">' . $description . '</span>';
                                                    echo '<a href="#" class="toggle-text">xem thêm</a>';
                                                } else {
                                                    echo '<span class="short-text">' . $description . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?= number_format($products['price'], 0, '', ','); ?> đ</td>
                                            <td><?= $products['stock']; ?></td>
                                            <td><?= $products['discount']; ?>%</td>
                                            <td>
                                                <a href="sanpham-view.php?id=<?= $products['product_id']; ?>" class="btn btn-info btn-sm">Xem</a>
                                                <a href="sanpham-edit.php?id=<?= $products['product_id']; ?>" class="btn btn-success btn-sm">Sửa</a>
                                                <form action="editsanpham.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_product" value="<?= $products['product_id']; ?>" class="btn btn-danger btn-sm">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<h5>Không tìm thấy sản phẩm nào</h5>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <?php include('./config/message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Quản lý người dùng
                            <a href="addnguoidung.php" class="btn btn-primary float-end">Thêm người dùng</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Email</th>
                                    <th>Mật khẩu</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Giới tính</th>
                                    <th>Ngày sinh</th>
                                    <th>Vai trò</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM users";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $users) {
                                ?>
                                        <tr>
                                            <td><?= $users['user_id']; ?></td>
                                            <td><?= $users['username']; ?></td>
                                            <td><?= $users['email']; ?></td>
                                            <td><?= substr($users['password_hash'], 0, 10) . '*'; ?></td>
                                            <td><?= $users['first_name']; ?></td>
                                            <td><?= $users['last_name']; ?></td>
                                            <td><?= $users['phone']; ?></td>
                                            <td><?= $users['gender'] == 'male' ? 'Nam' : 'Nữ'; ?></td>
                                            <td><?= $users['birthday']; ?></td>
                                            <td><?= $users['role'] == 'admin' ? 'Quản trị viên' : 'Người dùng'; ?></td>
                                            <td>
                                                <a href="user-view.php?id=<?= $users['user_id']; ?>" class="btn btn-info btn-sm">Xem</a>
                                                <a href="user-edit.php?id=<?= $users['user_id']; ?>" class="btn btn-success btn-sm">Sửa</a>
                                                <form action="edituser.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_user" value="<?= $users['user_id']; ?>" class="btn btn-danger btn-sm">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<h5>Không tìm thấy người dùng nào</h5>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Quản lý đơn hàng</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Đơn hàng</th>
                                        <th>ID Người dùng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đặt</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM orders ORDER BY created_at DESC";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $order) {
                                            $status_text = '';
                                            switch($order['status']) {
                                                case 'pending':
                                                    $status_text = 'Chờ xử lý';
                                                    break;
                                                case 'processing':
                                                    $status_text = 'Đang xử lý';
                                                    break;
                                                case 'shipped':
                                                    $status_text = 'Đang giao hàng';
                                                    break;
                                                case 'delivered':
                                                    $status_text = 'Đã giao hàng';
                                                    break;
                                                case 'cancelled':
                                                    $status_text = 'Đã hủy';
                                                    break;
                                                default:
                                                    $status_text = $order['status'];
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $order['order_id']; ?></td>
                                                <td><?= $order['user_id']; ?></td>
                                                <td><?= number_format($order['total_price'], 0, '', ','); ?> đ</td>
                                                <td><?= $status_text; ?></td>
                                                <td><?= $order['created_at']; ?></td>
                                                <td>
                                                    <a href="order-view.php?id=<?= $order['order_id']; ?>" class="btn btn-info btn-sm">Xem</a>
                                                    <a href="order-edit.php?id=<?= $order['order_id']; ?>" class="btn btn-success btn-sm">Sửa</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<h5>Không tìm thấy đơn hàng nào</h5>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/index.js"></script>
</div>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleLinks = document.querySelectorAll('.toggle-text');
        
        toggleLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const shortText = this.previousElementSibling.previousElementSibling;
                const fullText = this.previousElementSibling;
                
                if (fullText.style.display === 'none') {
                    shortText.style.display = 'none';
                    fullText.style.display = 'inline';
                    this.textContent = 'thu gọn';
                } else {
                    shortText.style.display = 'inline';
                    fullText.style.display = 'none';
                    this.textContent = 'xem thêm';
                }
            });
        });
    });
</script>