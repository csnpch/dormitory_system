<div class="menu_scroll hidden z-10 fixed bg-white rounded-lg mt-2 ml-2 shadow-md">
    <button id="btnOpenSidebar" class="btn btn-square btn-ghost" onclick="activeSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">           
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>               
        </svg>
    </button>
</div>

<div class="flex justify-between navbar shadow-lg bg-neutral text-neutral-content h-10">
    <div>
        <button id="btnOpenSidebar" class="btn btn-square btn-ghost" onclick="activeSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">           
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>               
            </svg>
        </button>
    
        <span class="defocus text-lg md:ml-2 font_prompt lg:hidden sm_hidden">
            ระบบจัดการหอพักนักศึกษา
        </span>
    </div> 

    <div class="flex flex-row items-stretch md:gap-x-4 mr-0 lg:mr-4">
        <a href="./../index.php" class="watchMyWeb deactive mt-0.5 btn btn-active btn-sm rounded-btn sm_hidden">
            <i class="far fa-eye fa-lg w-6 mr-2"></i>
            เยี่ยมชมเว็บไซค์
        </a>
        <a href="./detail_manage.php" class="websiteDetailManagerButton deactive mt-0.5 btn btn-active btn-sm rounded-btn">
            แก้ไขข้อมูลรายละเอียดหน้าเว็บไซค์
        </a>
        <a class="websiteDetailManagerButton flex flex-row justify-center items-center btn btn-ghost btn-sm rounded-btn">
            <div class="mt-0.5 inline-block w-5 mr-2 stroke-current">       
                <i class="far fa-user-circle text-xl"></i>
            </div>
            <div class="text-sm mb:text-md mt-1.5 sm:mt-1">
                <?php echo 'ADMIN : '.explode(' ', $_SESSION['adm_fullname'])[0] ?>
            </div>
        </a>
    </div>
    
</div>

<script type="text/javascript" src="../assets/js/_adm_sidebar_navbar.js"></script>
