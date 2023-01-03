# Student dormitory management website
**This project is part of a "Web Programming" course and Charity project for student dormitory Increase convenience for students to use the booking website.

## Tools
1. PHP 8
2. SweetAlert2
3. Javascirpt
4. DataTalbe
5. Scss
6. Tailwind Css
7. DaisyUI
8. jsToExcel

## Creators
1. Chitsanuphong
2. Thanaphoom       (Consultant)

## System recomment:
- autoChangeStatusStd for not created >= 1 year
- autoDestroyStdAll for not update&active >= 7 year
- autoDestroyStdIsNotRoomId for not update&active >= 5 year 
- autoDestroyRoomByStd for not update&active >= 4 year
- autoDestroyLogBooks >= 2 year
- autoDestroyNews >= 3 year

## For dev:
tb_branch insert 1 row default -> (branch_id = 0, fac_id = null, branch_name = '-')
- _adm_book_std_manage.js line 124-127 plz change on deploy!
