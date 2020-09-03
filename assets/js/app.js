
import '../css/app.scss';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

function blockUnblockBtn(btn, field) {
    field.keyup(function () {
        if (field.val().length !== 0) {
            btn.prop('disabled', false);
        } else {
            btn.prop('disabled', true);
        }
    });
}


let rateBtn = $('button.btn-rate');

rateBtn.on('click', function(){

    let type = $(this).data('type');
    let post = $(this).data('post');
    let parent = $(this).parents();

    parent.children('button.btn-rate').prop('disabled', true);

    $.ajax({
        url:'/rate/'+ type +'/' + post,
        type: "POST",
        dataType: "json",
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

let postContentField = $('#post_content');
let postSubmitBtn = $('#post_submit');

postSubmitBtn.prop('disabled', true);

postContentField.keyup(function () {
    blockUnblockBtn(postSubmitBtn, postContentField);
});

let complaintBtn = $('button.btn-complaint');

complaintBtn.on('click', function(){

    let post = $(this).data('post');
    $('#complaint-post').val(post);

});

let submitComplaint = $('#submitComplaint');
let complaintField = $('#complaint-text');

complaintField.keyup(function () {
    blockUnblockBtn(submitComplaint, complaintField);
});


submitComplaint.on('click', function () {

    submitComplaint.prop('disabled', true);

    $.ajax({
        url:'/complaint/post/' + $('#complaint-post').val(),
        type: "POST",
        dataType: "json",
        data: {
            "text":  $('#complaint-text').val(),
        },
        async: true,
        success: function (data)
        {
            $('#complaintModal').modal('hide');
            alert(data['message']);
        },
        error: function (data)
        {
            alert('!!! что-то пошло не так !!!');
        },
    });
    return false;
});


