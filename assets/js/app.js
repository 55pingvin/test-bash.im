
import '../css/app.scss';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

let rateBtn = $('button.btn-rate');

rateBtn.on('click', function(){

    let type = $(this).data('type');
    let post = $(this).data('post');
    let parent = $(this).parents();

    parent.children('button.btn-rate').prop('disabled', true);

    $.ajax({
        url:'/rate',
        type: "POST",
        dataType: "json",
        data: {
            "type": type,
            "post_id": post
        },
        async: true,
        success: function (data)
        {
            if (data['success']) {
                parent.children('span.rate-score').html(data['score']);
            }

            alert(data['message']);

        },
        error: function (data)
        {
            alert('!!! что-то пошло не так !!!');
        },
    });
    return false;

});

let complaintBtn = $('button.btn-complaint');

complaintBtn.on('click', function(){

    let post = $(this).data('post');
    $('#complaint-post').val(post);
    submitComplaint.prop('disabled', false);


});


let submitComplaint = $('#submitComplaint')

submitComplaint.on('click', function () {

    submitComplaint.prop('disabled', true);

    $.ajax({
        url:'/complaint',
        type: "POST",
        dataType: "json",
        data: {
            "text":  $('#complaint-text').val(),
            "post_id": $('#complaint-post').val()
        },
        async: true,
        success: function (data)
        {
            $('#complaintModal').modal('hide')
            alert(data['message']);
        },
        error: function (data)
        {
            alert('!!! что-то пошло не так !!!');
        },
    });
    return false;
});