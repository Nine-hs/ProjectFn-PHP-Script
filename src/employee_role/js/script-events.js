$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: './activities/load.php',
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            $('#exampleModal').modal('show')
            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
            $('#other').prop('disabled', true)
            $('#show-start-date').val(datetoStart(start))
            $('#show-end-date').val(datetoEnd(end))
            $('#start-date').val(start)
            $('#end-date').val(end)
        },
        editable: true,
        eventResize: function (event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            var title = event.title;
            var id = event.id;
            $.ajax({
                url: "./activities/update.php",
                type: "POST",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    id: id
                },
                success: function () {
                    calendar.fullCalendar('refetchEvents');
                    alert('อัพเดทกิจกรรมสำเร็จ');
                    window.location.href = 'events.php'
                }
            })
        },

        eventDrop: function (event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            var title = event.title;
            var id = event.id;
            $.ajax({
                url: "./activities/update.php",
                type: "POST",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    id: id
                },
                success: function () {
                    calendar.fullCalendar('refetchEvents');
                    alert("อัพเดทกิจกรรมสำเร็จ");
                    window.location.href = 'events.php'
                }
            });
        },

        eventClick: function (event) {
            if (confirm("ต้องการลบกิจกรรมนี้หรือไม่")) {
                var id = event.id;
                $.ajax({
                    url: "./activities/delete.php",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function () {
                        calendar.fullCalendar('refetchEvents');
                        alert("ลบกิจกรรมสำเร็จ");
                        window.location.reload()
                    }
                })
            }
        },

    });

    function datetoStart(datestart) {
        dateFull = datestart.split(" ")[0]
        timeFull = datestart.split(" ")[1]
        date = dateFull.split("-")
        date_toSTR = date[2] + "/" + date[1] + "/" + (parseInt(date[0]) + 543) + " " + timeFull
        return date_toSTR
    }

    function datetoEnd(datestart) {
        dateFull = datestart.split(" ")[0]
        timeFull = datestart.split(" ")[1]
        date = dateFull.split("-")
        date_toSTR = date[2] + "/" + date[1] + "/" + (parseInt(date[0]) + 543) + " " + timeFull
        return date_toSTR
    }


    $('#Check1').change(function () {
        x = $(this).is(':checked')
        if (x) {
            $('#other').prop('disabled', false)
            $('#acty').prop('disabled', true)
        } else {
            $('#other').prop('disabled', true)
            $('#acty').prop('disabled', false)
        }
    })

    $('#checkevents').change(function () {
        check = $(this).is(':checked')
        df = 0
        id = $('#events_id').val()
        if (check) {
            df = 1
        }
        if (id === 0) {
            $(this).is(':checked')
        }
        console.log(id)
        $.ajax({
            url: "src/switch.php",
            type: "POST",
            data: {
                sw: $(this).val(),
                id: id
            },
            success: function (res) {
                console.log(res)
            }
        })
    })
});

