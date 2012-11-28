$("input").placeholder();
$("#login").click( function() {
    submitLogin();
});
$("input, #login").keydown( function(event) {
    if (event.which == 13) {
        submitLogin();
    }
});
function submitLogin() {
    document.forms["login-form"].submit();
}