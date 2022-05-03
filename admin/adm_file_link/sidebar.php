<div id="overlay" class="deactive bg-black opacity-40 z-20 w-full h-full fixed" onclick="slideSidebar()"></div>


<div id="sidebar" class="fixed top-0 defocus -ml-64 lg:ml-0 z-30 w-64 bg-gray-800 trasition-all duration-300">
    
    <p class="text-lg text-center text-neutral-content mt-4 pt-0.5 pl-2">
        <a href="././../admin/dashboard.php">ระบบจัดการหอพักนักศึกษา</a>
        <span id="closeSidebar" class="hidden">
            <i onclick="slideSidebar()" class="fas fa-chevron-circle-left cursor-pointer ml-1 hover:text-blue-200"></i>
        </span>
    </p>

    <div class="mt-10 w-full text-left text-white overflow-y-auto outline-none overflow-x-hidden" style="height: 80vh !important">

        <p class="ml-6 mt-2 mb-2 font-light text-sm mb-4">:: MENU ::</p>

        <a href="./../admin/dashboard.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50 trasition-all duration-300">
                <i class="fas fa-tachometer-alt mr-1 w-5"></i>
                <span>Dashboard</span>
            </button>
        </a>

        <a href="./../admin/control_system.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-tasks w-6"></i>
                <span>ควบคุมระบบ</span>
            </button>
        </a>

        <a href="./../admin/news_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <!-- <i class="fas fa-file-alt w-5"></i> -->
                <i class="far fa-file-alt w-6"></i>
                <span>จัดการข่าวสาร</span>
            </button>
        </a>

        <a href="./../admin/dorm_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="far fa-building w-6"></i>
                <span>จัดการหอพัก</span>
            </button>
        </a>

        <a href="./../admin/member_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <!-- <i class="fas fa-user-cog w-6"></i> -->
                <i class="fas fa-users-cog w-6"></i>
                <span>จัดการสมาชิก</span>
            </button>
        </a>

        <a href="./../admin/admin_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-user-tie w-6"></i>
                <span>จัดการผู้ดูแล</span>
            </button>
        </a>

        <a href="./../admin/book_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-bed w-6"></i>
                <span>การจองห้องพัก</span>
            </button>
        </a>

        <a href="./../admin/fix_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-hammer w-6"></i>
                <span>รายการแจ้งซ่อม</span>
            </button>
        </a>

        <a href="./../admin/fac_branch_manage.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-graduation-cap w-6"></i>
                <span>จัดการคณะ / สาขา</span>
            </button>
        </a>

        <a href="./../admin/contact_develop.php">
            <button class="menuBtn mb-0.5 rounded-lg ml-3 w-full p-3 hover:bg-gray-700 text-left text-gray-300 hover:text-gray-50">
                <i class="fas fa-hands-helping w-6"></i>
                <!-- <i class="fas fa-user-tie w-6"></i> -->
                <span>ติดต่อผู้พัฒนาระบบ</span>
            </button>
        </a>

        <div class="space mt-10 xl:mt-15"></div>

    </div>

    <div class="h-screen text-white">
        
        <a class="bottom-0 line_t_white_2 fixed w-64 h-9 text-center bg-gray-900 hover:bg-black trasition-all duration-200"
            href="./adm_file_link/logout.php">
            <div class="mt-1.5">
                <i class="fa fa-sign-out-alt"></i>
                <span>ออกจากระบบ</span>
            </div>
        </a>

    </div>

</div>
