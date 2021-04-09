$(document).ready(function () {



    $('#search').change(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/scholarperyear.php",
            type: "POST",
            data: { search: $(this).val() },
            success: function (res) {
                $('#show').html(res)
            }
        })

    })

    $('#search').keyup(function (event) {
        event.preventDefault();
        $.ajax({
            url: "src/scholarperyear.php",
            type: "POST",
            data: { searchOption: $(this).val() },
            success: function (res) {
                $('#datalistOptions').html(res)
            }
        })
    })


    $('#form-peryear').submit(function (event) {
        alert('hello')
        event.preventDefault();

        /*
                $.ajax({
                    url: "src/search-scholar.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (res) {
                        alert(res)
                            location.reload()
                    }
                })
        */


    });

    $('#dt').change(function (e) {
        $.ajax({
            url: "src/search-load.php",
            type: "POST",
            data: {
                search: $(this).val()
            },
            success: function (res) {
                $('#tbody').html(res)
            }
        })
        e.preventDefault()
    })

    $(document).on('click', '.btnshow', function () {
        var button_id = $(this).attr("id");
            $.ajax({
                url: "src/search-load.php",
                type: "POST",
                dataType: "json",
                data: {
                    find: button_id
                },
                success: function (res) {
                    console.log(res)
                    $('#grade').html(res.GRADE_SC+" /15 คะแนน")
                    $('#is_sc').html(res.IC_SC+" /15 คะแนน")
                    $('#fm_sc').html(res.FM_SC+" /25 คะแนน")
                    $('#ps_sc').html(res.PS_SC+" /25 คะแนน")
                    $('#acty_sv').html(res.ACTY_SC+" /20 คะแนน")
                    $('#tt_sc').html(res.TTAL_SC+" /100 คะแนน")
                    $('#Modal').modal('show')
                }
            })
        
    });

});
