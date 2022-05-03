<!-- Menu  -->
<div id="container_navbar">
    <div class="areaNav">
        <div class="textTitle"> 
            <a href="index.php">หอพักนึกศึกษา มจพ. ปราจีนฯ</a>
        </div>
        <div class="menu">
            <div class="item">
                <a href="index.php" onmouseover="openSubmenu(2)">หน้าหลัก</a>
            </div>
            <div class="item">
                <a class="sub-MenuMain" onmouseover="openSubmenu(1)" style="cursor: pointer;">เกี่ยวกับหอพัก <i class="fas fa-angle-down dropdown"></i></a>
                <div id="verSub" class="verSubMenuMain" onmouseover="openSubmenu(1)" onmouseout="openSubmenu(0)">
                    <a href="room_sample.php" class="sub-item">ตัวอย่างห้องพัก</a>
                    <a href="dorm_plan.php" class="sub-item">แผนผังหอพัก</a>
                    <a href="dorm_fee.php" class="sub-item">ค่าธรรมเนียมหอพัก</a>
                </div>
            </div>
            <div class="item destroyAdminLogin">
                <a href="./system_book.php" onmouseover="openSubmenu(2)">จองห้องพัก</a>
            </div>
            <div class="item adminLogin deactive" onmouseover="openSubmenu(2)">
                <a href="./admin/dashboard.php" style="color: rgb(255, 230, 0);">จัดการระบบหอพัก</a>
            </div>

            <?php if (isset($_SESSION['std_id'])): ?>
                <div class="item userLogin">
                    <a href="system_profile.php" onmouseover="openSubmenu(2)"><span>สวัสดี</span><?php echo $_SESSION['std_firstname'] ?></a>
                </div>
            <?php elseif (isset($_SESSION['adm_id'])): ?>
                <div class="item userLogin">
                    <a href="./admin/dashboard.php" style="color: rgb(255, 230, 0);">จัดการระบบหอพัก</a>
                </div>
            <?php else: ?>
                <div id="popupLogin" class="item destroyUserLogin mt-1">
                    <a href="login.php" onmouseover="openSubmenu(2)">เข้าสู่ระบบ/สมัครสมาชิก</a>
                </div>
            <?php endif; ?>

        </div>
        <div class="menu-btn" style="display: none;">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</div>

<!-- Menu Responsive -->
<div class="overlay"></div>
<div id="sidebarNav" class="side-bar">
    <div class="close-btn-sidebar">
        <i class="fas fa-times"></i>
    </div>
    <div class="menu">
        <?php if (isset($_SESSION['std_id'])): ?>
            <div class="item userLogin">
                <a href="system_profile.php"><span>สวัสดี </span><?php echo $_SESSION['std_firstname'] ?></a>
            </div>
        <?php endif; ?>

        <div class="item">
            <a href="index.php">หน้าหลัก</a>
        </div>
        <div class="item" onclick="activeSubMenuResponsive()">
            <a class="sub-btn" href="##">เกี่ยวกับหอพัก<i class="fas fa-angle-right dropdown"></i></a>
            <div id="sub-menu-respons" class="sub-menu deactive">
                <a href="room_sample.php" class="sub-item">ตัวอย่างห้องพัก</a>
                <a href="dorm_plan.php" class="sub-item">แผนผังหอพัก</a>
                <a href="dorm_fee.php" class="sub-item">ค่าธรรมเนียมหอพัก</a>
            </div>
        </div>
        <div class="item destroyAdminLogin">
            <a href="./system_book.php">จองห้องพัก</a>
        </div>
        <div class="item adminLogin deactive">
            <a href="./admin/dashboard.php" style="color: rgb(255, 230, 0);">จัดการระบบหอพัก</a>
        </div>

        <?php if (isset($_SESSION['std_id'])): ?>
            <div class="item userLogin btnLogout">
                <a href="logout.php" style="font-size: 14px !important; transition: 0.2s !important;">ออกจากระบบ</a>
            </div>
        <?php elseif (isset($_SESSION['adm_id'])): ?>
            <div class="item adminLogin">
                <a href="./admin/dashboard.php" style="color: rgb(255, 230, 0);">จัดการระบบหอพัก</a>
            </div>
        <?php else: ?>
            <div id="popupLogin" class="item destroyUserLogin">
                <a href="login.php">เข้าสู่ระบบ/สมัครสมาชิก</a>
            </div>
        <?php endif; ?>

    </div>
</div>
<script src="./assets/js/_navbar.js"></script>
