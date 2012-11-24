/**************/
/*  MESSAGES  */
/**************/
var messages = new Object();
messages.valid = new Object();
messages.error = new Object();
messages.duplicate = new Object();
messages.def = new Object();

messages.valid.email = "Your email is safe with us!";
messages.valid.password = "You're almost ready!";
messages.valid.confirm = "That's everything we need! You're ready!";
messages.valid.confirmPending = "All that's left is the email!";
messages.valid.name = "Thanks! We'll refer to you by this.";
messages.valid.alias = "Cool! Other users will see this name instead of \"anonymous\".";
messages.error.email = "That email is not formatted correctly. It should be similar to john.doe@email.com.";
messages.error.password = "Sorry, that password is too simple. Use at least 1 letter, 1 number, and 8 characters minimum.";
messages.error.confirm = "Sorry, the passwords don't match.";
messages.duplicate.email = "That email has already been registered with us. Please log in or enter a different email.";
messages.duplicate.alias = "Sorry, that alias has already been taken. Please try another one!"
messages.def.name = "You can give us your real name if you want to.";
messages.def.alias = "An alias is like a fake name for public use.";

//  STILL NEED TO ADD:
//  - AJAX call to validate email uniqueness
//  - AJAX call to validate alias uniqueness
//  - More appealing "Welcome" -- image??

$(document).ready( function() {
    if ($("#email").val() != "") {
        emailChange();
    }
    if ($("#name").val() != "" || $("#alias").val() != "") {
        $("#password").parent().show();
        $("#confirm").parent().show();
        $("#name").parent().show();
        $("#alias").parent().show();
        nameChange();
        aliasChange();
    } else {
        $("#nameNote").html(messages.def.name);
        $("#aliasNote").html(messages.def.alias);
    }
});

$("#welcome").disableSelection();

$("#email").change( function() {
    emailChange();
});

$("#password").change( function() {
    passwordChange();
});

$("#confirm").change( function() {
    confirmChange();
});

$("#name").change( function() {
    nameChange();
});

$("#alias").change( function() {
    aliasChange();
});

function nameChange() {
    if ($("#name").val() != "") {
        $("#nameNote").addClass("valid").html(messages.valid.name);
    } else {
        $("#nameNote").removeClass("valid").html(messages.def.name);
    }
}

function aliasChange() {
    if ($("#alias").val() != "") {
        if (isUniqueAlias($("#alias").val())) {
            $("#aliasNote").removeClass("error").addClass("valid").html(messages.valid.alias);
        } else {
            $("#aliasNote").removeClass("valid").addClass("error").html(messages.duplicate.alias);
        }
    } else {
        $("#aliasNote").removeClass("error").removeClass("valid").html(messages.def.alias);
    }
}

function emailChange() {
    if (isValidEmail($("#email").val())) {
        if (isUniqueEmail($("#email").val())) {
            $("#emailNote").removeClass("error").addClass("valid").html(messages.valid.email);
            $("#password").parent().show();
            $("#password").focus();
        } else {
            $("#emailNote").removeClass("valid").addClass("error").html(messages.duplicate.email);
        }
    } else {
        $("#emailNote").removeClass("valid").addClass("error").html(messages.error.email);
    }
    if ($("#emailNote").hasClass("error") && $("#confirmNote").hasClass("valid")) {
        $("#confirmNote").html(messages.valid.confirmPending);
    }
}

function passwordChange() {
    if (isValidPassword($("#password").val())) {
        $("#passwordNote").removeClass("error").addClass("valid").html(messages.valid.password);
        $("#confirm").parent().show();
        $("#confirm").focus();
    } else {
        $("#passwordNote").removeClass("valid").addClass("error").html(messages.error.password);
    }
    if ($("#confirm").val() != "") {
        confirmChange();
    }
}

function confirmChange() {
    if (isValidConfirm($("#confirm").val())) {
        if (isValidPassword($("#password").val())) {
            if ($("#emailNote").hasClass("valid")) {
                $("#confirmNote").removeClass("error").addClass("valid").html(messages.valid.confirm);
                $("#passwordNote").hide();
                $("#name").parent().show();
                $("#alias").parent().show();
                $("#name").focus();
            } else {
                $("#confirmNote").removeClass("error").addClass("valid").html(messages.valid.confirmPending);
            }
        } else {
            $("#confirmNote").html("");
        }
    } else {
        $("#confirmNote").removeClass("valid").addClass("error").html(messages.error.confirm);
        $("#passwordNote").show();
    }
}

function canSubmit() {
    if ($(".error").size() > 0) {
        return false;
    } else if ($("#emailNote").hasClass("valid") && $("#confirmNote").hasClass("valid")) {
        return true;
    }
}

$("input").change( function() {
    if (canSubmit()) {
        $("#next").hide();
        $("#signup").show();
    } else {
        $("#signup").hide();
        $("#next").show();
    }
});

$(".signup").first().focus( function() {
    $("#signup").focus();
});



/**************************/
/*  VALIDATION FUNCTIONS  */
/**************************/
var emailRegex = /^([a-zA-Z0-9_\-\.])+\@([a-zA-Z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var passwordRegex = /^(?=.*\d+)(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%]{8,30}/;

function isValidEmail(email) {
    return emailRegex.test(email);
}

function isUniqueEmail(email) {
    // TODO
    return true;
}

function isUniqueAlias(alias) {
    // TODO
    return true;
}

function isValidPassword(password) {
    return passwordRegex.test(password);
}

function isValidConfirm(confirm) {
    return  $("#confirm").val() == $("#password").val();
}


function validateForm() {
    if (!canSubmit()) {
        return false;
    } else {
        if ($("#password").val() == "" && $("#name").parent().css("display") != "none") {
            $("#passwordNote").removeClass("valid").addClass("error").html(messages.error.password);
            return false;
        }
        return true;
    }
}