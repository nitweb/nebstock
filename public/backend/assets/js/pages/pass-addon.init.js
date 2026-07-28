// $("#password-addon").on("click",function(){0<$(this).siblings("input").length&&("password"==$(this).siblings("input").attr("type")?$(this).siblings("input").attr("type","input"):$(this).siblings("input").attr("type","password"))});

$(".password-addon").on("mousedown", function () {
    var input = $(this).siblings("input");
    if (input.length > 0) {
        input.attr("type", "text");
    }
}).on("mouseup mouseleave", function () {
    var input = $(this).siblings("input");
    if (input.length > 0) {
        input.attr("type", "password");
    }
});