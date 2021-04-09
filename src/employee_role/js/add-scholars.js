$(document).ready(function () {

    let i = 1
    $('#btnplus').click(function () {
        i++
        $('#tb').append('<tr id="row' + i + '"><td colspan="4"><input type="text" name="nameDonat[]" class="form-control"></td><td colspan="4"><input type="text" name="phone[]" class="form-control"></td><td><button class="btn btn-danger btn-minus"  id="' + i + '" type="button">-</button></div></td></tr>');
    })

    $(document).on('click', '.btn-minus', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    setInterval(function () {
        $('#scholars_show').load('src/search-scholar.php')
    }, 2000)


    $(document).on('click', '.btn-detail-scho', function () {
        var button_id = $(this).attr("id");
        var namescho = $(this).attr("attr1");
        var amount = $(this).attr("attr2");
        var total = $(this).attr("attr3");
        $.ajax({
            url: "src/detail.php",
            type: "POST",
            data: {
                find_detail_scho: button_id
            },
            success: function (res) {

                $('#title-detail').html(namescho)
                $('#nameSCHO').html(namescho)
                $('#am_sholar').html(amount)
                $('#tt_scholar').html(total)
                $('#giver_show').html(res);
                $('#Modal_DETAIL_SCHO').modal('show');
            }
        })
    });

    $('#formid').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                $('#Scholar-id').val("")
                $('#nameScholar').val("")
                $('#amount_sholar').val("")
                $('#total_scholar').val("")
                $('#YOS').val("")
                $('#COS').val("")
                $('#Modal_ADD_SCHO').modal('hide');
            }
        })
    })


    $('.btn_add_SCHO').click(function () {
        $('#Modal_ADD_SCHO').modal('show');
    })

    $(document).on('click', '.btn-update', function () {
        var button_id = $(this).attr("id");
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            dataType: "json",
            data: {
                up_id: button_id
            },
            success: function (res) {
                $('#Modal').modal('show');
                $('#title-update').html(res.SCHOLAR_NAME)
                $('#scholar-id').val(res.SCHOLAR_ID)
                $('#scholar-name').val(res.SCHOLAR_NAME)
                $('#scholar-amount').val(res.SCOLAR_AMOUNTH)
                $('#scholar-value').val(res.SCHOLAR_VALUE)
                $('#scholar-gived').val(res.GIVED)
                $('#scholar-valued').val(res.VALUED)
                $('#scholar-curamount').val(res.CURR_AMOUNT)
                $('#scholar-curvalue').val(res.CURR_VALUE)
            }
        })
    });

    $(document).on('click', '.btn-delete', function () {

        var button_id = $(this).attr("id");
        if (confirm("ต้องการลบข้อมูลทุนฯนี้หรือไม่"))
            $.ajax({
                url: "src/add-scholar.php",
                type: "POST",
                data: {
                    del_id: button_id
                },
                success: function (res) {
                    if (res === "ลบรายการสำเร็จ") {
                        alert(res)
                    } else {
                        alert(res)
                    }
                }
            })
    });

    $('#form-update').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                if (res === "แก้ไขข้อมูลสำเร็จ") {
                    $('#Modal').modal('hide');
                } else {
                    $('#alert').html(res)
                }
            }
        })
    })

    /********************/
    /* ส่วนของจัดการผู้ใช้ */
    /*******************/

    setInterval(function () {
        $('#tbody_users').load('src/load_users.php')
    }, 3000)

    $(document).on('click', '.btn-update-users', function () {
        var button_id = $(this).attr("id");
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            dataType: "json",
            data: {
                find_edit: button_id
            },
            success: function (res) {
                $('#e_user_id').val(res.EM_ID)
                $('#e_fname').val(res.EM_NAME)
                $('#e_lname').val(res.EM_LASTNAME)
                $('#e_username').val(res.EM_USERNAME)
                $('#e_status').val(res.EM_DEPART)
                $('#Modals').modal('show');
            }
        })
    });

    $(document).on('click', '.btn-save-update-user', function () {
        var button_id = $(this).attr("id");
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            data: {
                edit_data: button_id
            },
            success: function (res) {
                console.log(res)
            }
        })
    });

    $('.btn-add').click(function () {
        $('#Modal_Add').modal('show');

    })

    $('#form-update-user').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/update_users.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                $('#e_user_id').val("")
                $('#e_fname').val("")
                $('#e_lname').val("")
                $('#e_username').val("")
                $('#e_status').val("")
                $('#Modals').modal('hide');
            }
        })
    })

    /*
    $('#form-add-user').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/m_users.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                if (res === "ลงทะเบียนเข้าสู่ระบบสำเร็จ") {
                    $('#user_id').val("")
                    $('#fname').val("")
                    $('#lname').val("")
                    $('#username').val("")
                    $('#password').val("")
                    $('#status').val("")
                    $('#Modal_Add').modal('hide');
                } else {
                    $('#alert').html("hello")
                }

            }
        })
    })
*/
    $(document).on('click', '.btn-delete-user', function () {
        var button_id = $(this).attr("id");
        if (confirm("ต้องการลบข้อมูลผู้ใช้")) {
            $.ajax({
                url: "src/m_users.php",
                type: "POST",
                data: {
                    del_user: button_id
                },
                success: function (res) {
                    alert(res)
                }
            })
        }

    });



});