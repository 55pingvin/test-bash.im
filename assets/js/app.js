
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
    let $postInputField = $('#complaint_post');

    $postInputField.val(post);
    console.log($postInputField);

    // $.ajax({
    //     url:'/rate',
    //     type: "POST",
    //     dataType: "json",
    //     data: {
    //         "type": type,
    //         "post_id": post
    //     },
    //     async: true,
    //     success: function (data)
    //     {
    //         if (data['success']) {
    //             parent.children('span.rate-score').html(data['score']);
    //         }
    //
    //         alert(data['message']);
    //
    //     },
    //     error: function (data)
    //     {
    //         alert('!!! что-то пошло не так !!!');
    //     },
    // });
    // return false;

});
