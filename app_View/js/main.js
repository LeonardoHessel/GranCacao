$(document).ready(function () {

    $(".toggle-password").click(function () {

        $(this).toggleClass("fas fa-eye-slash")
        var input = $($(this).attr("toggle"))

        if (input.attr("type") == "password") {
            input.attr("type", "text")

        } else {
            input.attr("type", "password")
        }
    })
})




































