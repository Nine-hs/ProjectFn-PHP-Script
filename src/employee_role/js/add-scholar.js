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

    $('#formid').submit(function (e) {
        e.preventDefault()
        $.ajax({
            url: "src/add-scholar.php",
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                if (res) {
                    alert(res)
                    location.reload();
                }
            }
        })
    })

});