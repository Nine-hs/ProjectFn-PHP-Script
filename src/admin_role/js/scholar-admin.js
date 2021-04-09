$(document).ready(function () {
    $('#majors').attr('disabled', true)
    $('#scholarship').change(function (e) {
        $('#majors').attr('disabled', false)
        $.ajax({
            url: "sv/add-scho.php",
            type: "POST",
            data: {
                scholar: $(this).val()
            },
            dataType: "JSON",
            success: function (res) {
                $('#r_id').val(res.SCHOLAR_ID)
                $('#name_scho').text(res.SCHOLAR_NAME)
                $('#amount').text(res.SCOLAR_AMOUNTH)
                $('#total').text(res.SCHOLAR_VALUE)
                $('#cur_amount').text(res.CURR_AMOUNT)
                $('#cur_total').text(res.CURR_VALUE)
                $('#txtamount').val(res.SCOLAR_AMOUNTH)
                $('#txttotal').val(res.SCHOLAR_VALUE)
                $('#txtcur_amount').val(res.CURR_AMOUNT)
                $('#txtcur_total').val(res.CURR_VALUE)
            }
        })
        e.preventDefault()
    })

    $('#majors').change(function (e) {
        $.ajax({
            url: "sv/add-scho.php",
            type: "POST",
            data: {
                major_id: $(this).val()
            },
            success: function (respon) {
                $('#showMajor').html(respon)
            }
        })
        e.preventDefault()
    })

    $('#search').keyup(function () {
        $.ajax({
            url: "sv/search_students.php",
            type: "POST",
            data: {
                search: $(this).val()
            },
            success: function (respon) {
                $('#tbody').html(respon)
                $('#tbody2').hide()
            }
        })
    })



    $(document).on('click', '.btn-edit', function () {
        var button_id = $(this).attr("id");
        $.ajax({
            url: "sv/add-score.php",
            type: "POST",
            dataType: "json",
            data: {
                edit_id: button_id
            },
            success: function (res) {
                $('.modal').show()
                //console.log(res)
                $('#req_id').val(res.R_SCHOLAR_ID)
                $('#oldscho_id').val(res.R_ID)
                $('#fullnameST').val(res.student)
                $('#grade').val(res.MAJOR)
                $('#schoname').val(res.R_ID)
                $('#util').val(res.amount)
                $('#value').val(res.values_scholar)
                $('#oldutil').val(res.amount)
                $('#oldvalue').val(res.values_scholar)
            }
        })
    });

    $(document).on('click', '#close', function () {
        $('.modal').hide();
    });

    $('#save').click(function (e) {
        $.ajax({
            url: "sv/add-scho.php",
            type: "POST",
            data: {
                button_save: $(this).attr('id'),
                r_id: $('#r_id').val(),
                student: $('#student').val()
            },
            success: function (res) {
                if (res === "บันทึกข้อมูลสำเร็จ") {
                    alert(res)
                    location.reload();
                } else {
                    alert(res)
                }
            }
        })
        e.preventDefault()
    })

    /************/
    /* แก้ไขข้อมูลทุนฯ schoname */
    /***********/

    $('#schoname').change(function () {
        $.ajax({
            url: "sv/add-scho.php",
            type: "POST",
            dataType: "json",
            data: {
                findscholar: $(this).val()
            },
            success: function (res) {
                $('#value').val(res[1][1])
                $('#oldutil').val(res[1][0])
                console.log(res)
            }
        })
    })

    $('#create_excel').click(function () {
        $(".table").table2excel({
            exclude: ".excludeThisClass",
            name: "รายการให้ทุนประจำปีการศึกษาที่" + new Date().getFullYear() + 543,
            filename: `ให้ทุนปี-${new Date().getFullYear() + 543}.xls`, // do include extension
            preserveColors: false // set to true if you want background colors and font colors preserved
        });
    });

});