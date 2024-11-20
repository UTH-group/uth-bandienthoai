<?php
$mockData = [
    'username' => 'exampleUser',
    'user_id' => 123,
    'fName' => 'Nguyễn Văn',
    'lName' => 'B',
    'phone' => '0901234567',
    'email' => 'example@example.com',
    'gender' => 'Nam',
    'birthday' => '1990-01-01',
    'pob_id' => 1, // Hồ Chí Minh
    'pob_options' => [
        1 => 'Hồ Chí Minh',
        2 => 'Hà Nội',
        3 => 'Khánh Hòa',
        4 => 'Đà Nẵng'
    ],
    'address' => [
        [
            'street' => '123 Đường ABC',
            'ward' => 'Phường XYZ',
            'district' => 'Quận 1',
            'city' => 'Hồ Chí Minh',
            'nation' => 'Việt Nam'
        ],
        [
            'street' => '456 Đường DEF',
            'ward' => 'Phường LMN',
            'district' => 'Quận 3',
            'city' => 'Hồ Chí Minh',
            'nation' => 'Việt Nam'
        ]
    ],
    'countCart' => 3, 
];

// Thay thế dữ liệu thực tế bằng dữ liệu giả
$username = $mockData['username'];
$user_id = $mockData['user_id'];
$fName = $mockData['fName'];
$lName = $mockData['lName'];
$phone = $mockData['phone'];
$email = $mockData['email'];
$gender = $mockData['gender'];
$birthday = $mockData['birthday'];
$pob_id = $mockData['pob_id'];
$address = $mockData['address'];
$pob_options = $mockData['pob_options'];
$countCart = $mockData['countCart'];
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
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
        </div>
        <div class="navigation">
            <div class="nav-center container d-flex">
                <a href="/" class="logo">
                    <img src="./images/main-logo.png" alt="Logo">
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
                                    <label for="user-info-phone">Số điện thoại</label>
                                    <input type="text" name="user-info-phone" id="user-info-phone" class="input-control" value="<?= $phone ?>">
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-email">
                                    <label for="user-info-email">Email</label>
                                    <input type="text" name="user-info-email" id="user-info-email" class="input-control" value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="user-info">
                                <div class="field-input-gender">
                                    <label for="user-info-gender">Giới tính</label><br>
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
                                    <label for="user-info-birthday">Ngày sinh</label>
                                    <input type="date" name="user-info-birthday" id="user-info-birthday" class="input-control" value="<?= $birthday ?>">
                                </div>

                                <div class="field-input-pob">
                                    <label for="user-info-pob">Nơi sinh</label><br>
                                    <select name="user-info-pob" id="user-info-pob" class="input-control">
                                        <?php foreach ($pob_options as $id => $name): ?>
                                            <option value="<?php echo $id; ?>" <?php if ($pob_id == $id) echo 'selected'; ?>>
                                                <?php echo $name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button commit-change">
                        <button type="submit">Lưu thay đổi</button>
                    </div>
                </form>
            </section>

            <!-- Địa chỉ -->
            <section id="address">
                <h2>Địa chỉ</h2>
                <div>
                    <h3>Địa chỉ của bạn</h3>
                    <?php foreach ($address as $addr): ?>
                        <p><?php echo $addr['street'] . ', ' . $addr['ward'] . ', ' . $addr['district'] . ', ' . $addr['city'] . ', ' . $addr['nation']; ?></p>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Đơn hàng gần đây -->
            <section id="orders">
                <h2>Đơn hàng gần đây</h2>
                <p>Hiện tại bạn chưa có đơn hàng nào.</p>
            </section>
        </div>
    </div>
</body>
</html>
