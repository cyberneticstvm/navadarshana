$(function(){
    "use strict"

    setTimeout(function () {
        var dzSettingsOptions = {
            typography: "Inter, sans-serif",
            version: "light",
            layout: "horizontal",
            primary: "color_1",
            headerBg: "color_4",
            navheaderBg: "color_4",
            sidebarBg: "color_1",
            sidebarStyle: "full",
            sidebarPosition: "fixed",
            headerPosition: "fixed",
            containerLayout: "full",
        };
        new dzSettings(dzSettingsOptions);
        jQuery(window).on('resize', function () {
            new dzSettings(dzSettingsOptions);
        })
    }, 1000);
    
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1.5,
        spaceBetween: 15,
        navigation: {
            nextEl: "",
            prevEl: "",
        },
        breakpoints: {
            // when window width is <= 499px
            1199: {
                slidesPerView: 2.5,
                spaceBetweenSlides: 15
            },
            // when window width is <= 999px
            1600: {
                slidesPerView: 1.5,
                spaceBetweenSlides: 15
            }
        },
    });

    $(document).on("click", ".radAttendance", function(){
        let dis = $(this);
        let radGrp = dis.data('group');
        if(dis.is(":checked")){
            dis.parent().next().val('1')
            $("."+radGrp).each(function(){
                $(this).not(dis).prop("checked", false)
                $(this).not(dis).parent().next().val('0')               
            });
        }else{
            dis.parent().next().val('0')
        }
    })

    $(document).on("click", ".emailBox", function(){
        let fid = $(this).data('fid');
        $.ajax({
            type: 'GET',
            url: '/ajax/student/fee/' + fid,
            success: function (res) {
                $('#emailBox').addClass('active');
                $(".studentFee").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

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

    $(document).on("click", ".viewTopicsForCourse", function(){
        let cid = $(this).data('cid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/course/topics/' + cid+ '/' + action,
            success: function (res) {
                $('#topicTblforCourse').addClass('active');
                $(".topicDetail").html(res);
                showFooter(action);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".viewModulesForSyllabus", function(){
        let sid = $(this).data('sid');
        let action = $(this).data('action');
        $.ajax({
            type: 'GET',
            url: '/ajax/syllabus/module/' + sid + '/' + action,
            success: function (res) {
                $('#moduleTblforSyllabus').addClass('active');
                $(".moduleDetail").html(res);
                showFooter(action);
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

    $(document).on("click", ".viewModuleTopicForBatch", function(){
        let sid = $(this).data('sid');
        let bid = $(this).data('bid');
        let fid = $(this).data('fid');
        $.ajax({
            type: 'GET',
            url: '/ajax/batch/module/topic/' + sid + '/' + bid + '/' + fid,
            success: function (res) {
                $('#moduleTopicDetailsBox').addClass('active');
                $(".moduleTopicDetails").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("click", ".chkModuleTopic", function(){
        let dis = $(this);
        let isChecked = dis.is(":checked") ? 1 : 0;
        let sid = dis.data('syllabus');
        let mid = dis.data('module');
        let tid = dis.data('topic');
        let bid = dis.data('batch');
        let fid = dis.data('faculty');
        $.ajax({
            type: 'POST',
            data: {'batch': bid, 'syllabus': sid, 'module': mid, 'topic': tid, 'faculty': fid, 'isChecked': isChecked},
            url: '/ajax/update/batch/topic/status',
            success: function (res) {
                if(res.success){
                    success(res)
                }else{
                    if(isChecked){
                        dis.prop('checked', false);
                    }
                    failed(res)
                }
            },
            error: function (err) {
                console.log(err);
            }
        });        
    });

    $(document).on("click", ".viewNoteDetail", function(){
        let tid = $(this).data('tid');
        $.ajax({
            type: 'GET',
            url: '/ajax/note/detail/' + tid,
            success: function (res) {
                $('#noteDetailsBox').addClass('active');
                $(".noteDetails").html(res);
            },
            error: function (err) {
                console.log(err)
            }
        });        
    });

    $(document).on("change", ".selChange", function(){
        let dis = $(this);
        let typeId = dis.val();
        let give = dis.data('give');
        let take = dis.data('take');
        $.ajax({
            type: 'GET',
            data: {"typeId": typeId, "give": give, "take": take},
            url: '/ajax/get/ddl',
            success: function (res) {                
                var xdata = $.map(res.items, function (obj) {
                    obj.text = obj.name || obj.id;
                    return obj;
                });
                if(take == 'module'){                    
                    $('.selModule').html("<option value=''>Select</option>").select2({
                        data: xdata,
                    });                   
                }                   
                if(take == 'topic'){
                    $('.selTopic').html("<option value=''>Select</option>").select2({
                        data: xdata,
                    });
                }
                if(take == 'syllabus'){                
                    $('.selSyllabus').html("<option value=''>Select</option>").select2({
                        data: xdata,
                    });                                     
                }
            },
            error: function (err) {
                console.log(err)
            }
        });   
    });

    $(document).on("click", ".addOptionEditor", function(){
        $('#questionOptionBox').addClass('active');        
    });

    $(document).on("click", ".btnAddOption", function(){
        let data = $(".optionEditor").val();
        console.log(data);
        $('.optionsContainer').append("<div class='col-md-12'>"+data+"</div>");        
    });

    $(document).on("change", ".status-select", function(){
        let month = $("#selectMonth1").val();
        let year = $("#selectYear1").val();
        let batch = 0;
        feePending(month, year, batch);
    });
    feePending($("#selectMonth1").val(), $("#selectYear1").val(), 0)
});

function showFooter(action){    
    if(action == 'add'){
        $('.card-footer').removeClass('d-none');
    }else{
        $('.card-footer').addClass('d-none');
    }
}

function feePending(month, year, batch){
    $.ajax({
            type: 'POST',
            url: '/ajax/fee/pending',
            data: {'month': month, 'year': year, 'batch': batch},
            success: function (res) {
                $(".feePending").html(res.fee)
            },
            error: function (err) {
                console.log(err)
            }
        });
}