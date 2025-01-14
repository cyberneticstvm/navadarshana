$(function(){
    "use strict"

    $(document).on("click", ".viewStudentDetail", function(){
        let sid = $(this).data('sid');
        $.ajax({
            type: 'GET',
            url: '/ajax/student/detail/' + sid,
            success: function (res) {
                $('#studentDetailsBox').addClass('active');
                $(".studentDetails").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewStudentsForBatch", function(){
        let bid = $(this).data('bid');
        $.ajax({
            type: 'GET',
            url: '/ajax/student/batch/' + bid,
            success: function (res) {
                $('#studentsTblforBatch').addClass('active');
                $(".studentsDetail").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });
})