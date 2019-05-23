$(document).ready(function() {
    $(".reply").click(function(e) {
        $(e.target).parent().parent().find('.answer-form').toggle();
    });

    $(".show-replies").click(function(e) {
        $(e.target).parent().parent().parent().find('.comment-replies').toggle();
    });
});



