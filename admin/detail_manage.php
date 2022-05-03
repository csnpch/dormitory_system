<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href=" ../assets/img/logoKmutnb.webp">
    <title>ระบบจัดการหอพักนักศึกษา มจพ.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    
    <div class="w-full h-full">
        <form method="post">
            <div class="flex flex-col tiems-center justify-center">
                <p class="text-center mt-8 text-2xl">กำหนดค่าธรรมเนียมหอพัก</p>
                <div class="flex flex-col gap-x-4 items-center justify-center gap-y-2 mt-12">
                    <div class="mb-2">
                        <p class="mb-2 text-lg">หอพักชาย</p>
                        <input id="price_male" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">หอพักหญิง 1<p>
                        <input id="price_female_1" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">หอพักหญิง 2 ชั้น 1-3<p>
                        <input id="price_female_2_f_1-3" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">หอพักหญิง 2 ชั้น 4-5<p>
                        <input id="price_female_2_f_4-5" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">ประกันทรัพย์สินเสียหาย</p>
                        <input id="price_guarantee" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">ค่าประกันกุญแจ</p>
                        <input id="price_key" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                    <div class="mb-2">
                        <p class="mb-2 text-lg">ค่าห้องพักภาคฤดูร้อน</p>
                        <input id="price_summer" type="text" class="text-center p-1 rounded-md border-blue-600/40 text-lg w-60 sm:w-80 border-2"
                            onChange="onUpdate()"
                        >
                    </div>
                </div>
                <textarea class="hidden mx-auto block border-2" id="txt_area_data" name="txt_area_data" id="" cols="30" rows="10"></textarea>
                <div class="col-span-2 mx-auto">
                    <button onclick="onUpdate()" id="btn_save_fee" name="btn_save_fee" class="hidden rounded-md mt-8 px-4 py-2 bg-green-600 text-white w-20">
                        บันทึก
                    </button>
                </div>
            </div>
        </form>
        <div>
        
        <a href="./news_manage.php" class="fixed left-6 bottom-6 md:left-20 md:bottom-10 rounded-md mt-8 px-4 py-2 bg-indigo-600 text-white">
            <- กลับ
        </a>
    
        </div>
    <div>


    <?php
        if(isset($_POST['btn_save_fee'])) {
            $datas = $_POST['txt_area_data'];
            if (file_put_contents("./../assets/data/fee_dorm.json", json_encode($datas))) {
                echo '<center class="timeoutHidden mt-6 text-lg font-semibold text-green-700">แก้ไขข้อมูลสำเร็จ</center>';
            } else {
                echo "<center class='timeoutHidden mt-6 text-lg font-semibold text-red-700'>เกิดข้อผิดพลาดบ่างอย่าง!</center>";
            }
        }
    ?>


    <script type="text/javascript">
        
        var elements = {
            fee_dorm: {
                male: document.getElementById('price_male'),
                female_1: document.getElementById('price_female_1'),
                female_2_floor_1_to_3: document.getElementById('price_female_2_f_1-3'),
                female_2_floor_4_to_5: document.getElementById('price_female_2_f_4-5')
            },
            insurance: {
                guarantee_room: document.getElementById('price_guarantee'),
                key_door: document.getElementById('price_key'),
                price_room_on_summer: document.getElementById('price_summer')
            }
        };

        axios.get('./../assets/data/fee_dorm.json')
            .then(function (res) {
                res.data = JSON.parse(res.data);
                elements.fee_dorm.male.value = `${res.data.fee_dorm.male}`;
                elements.fee_dorm.female_1.value = `${res.data.fee_dorm.female_1}`;
                elements.fee_dorm.female_2_floor_1_to_3.value = `${res.data.fee_dorm.female_2_floor_1_to_3}`;
                elements.fee_dorm.female_2_floor_4_to_5.value = `${res.data.fee_dorm.female_2_floor_4_to_5}`;
                elements.insurance.guarantee_room.value = `${res.data.insurance.guarantee_room}`;
                elements.insurance.key_door.value = `${res.data.insurance.key_door}`;
                elements.insurance.price_room_on_summer.value = `${res.data.insurance.price_room_on_summer}`;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });


        var datas = elements;
            
        function onUpdate() {
            datas.fee_dorm.male = document.getElementById('price_male').value;
            datas.fee_dorm.female_1 = document.getElementById('price_female_1').value;
            datas.fee_dorm.female_2_floor_1_to_3 = document.getElementById('price_female_2_f_1-3').value;
            datas.fee_dorm.female_2_floor_4_to_5 = document.getElementById('price_female_2_f_4-5').value;
            datas.insurance.guarantee_room = document.getElementById('price_guarantee').value;
            datas.insurance.key_door = document.getElementById('price_key').value;
            datas.insurance.price_room_on_summer = document.getElementById('price_summer').value;
            document.getElementById('txt_area_data').value = JSON.stringify(datas);
            document.getElementById('btn_save_fee').click();
        }
        setTimeout(() => {
            document.getElementsByClassName('timeoutHidden')[0].classList.add('hidden');
            document.getElementsByClassName('timeoutHidden')[1].classList.add('hidden');
        }, 2000);

    </script>
</body>
</html>