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
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/student/batch/' + bid+ '/' + action,
            success: function (res) {
                $('#studentsTblforBatch').addClass('active');
                $(".studentsDetail").html(res);
                showFooter(action);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewSyllabusForCourse", function(){
        let cid = $(this).data('cid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/course/syllabus/' + cid + '/' + action,
            success: function (res) {
                $('#syllabusTblforCourse').addClass('active');
                $(".syllabusDetail").html(res);
                $(".modal-select").select2();
                showFooter(action);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewSubjectsForSyllabus", function(){
        let sid = $(this).data('sid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/syllabus/subject/' + sid + '/' + action,
            success: function (res) {
                $('#subjectsTblforSyllabus').addClass('active');
                $(".subjectDetail").html(res);
                $(".modal-select").select2();
                showFooter(action);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewModulesForSubjects", function(){
        let sid = $(this).data('sid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/subject/module/' + sid + '/' + action,
            success: function (res) {
                $('#modulesTblforSubject').addClass('active');
                $(".moduleDetail").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewTopicsForModule", function(){
        let mid = $(this).data('mid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/module/topic/' + mid + '/' + action,
            success: function (res) {
                $('#topicsTblforModule').addClass('active');
                $(".topicDetail").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });
});

function showFooter(action){    
    if(action == 'add'){
        $('.card-footer').removeClass('d-none');
    }else{
        $('.card-footer').addClass('d-none');
    }
}