$(document).ready(function() {

    //Require to keep popup hidden in the beginning
    $('#my_popup').popup({});


    $("a#helpbox").bind("click", function(event) {
        event.preventDefault();
        $('#my_popup span').text('Please email the admin using the address: thisismingwebatgmail.com');
        $('#my_popup').popup('show');

    });

    $("a#open-modal").bind("click", function(event) {
        event.preventDefault();
        $('.modal').addClass("is-active");
        $('.html').addClass("is-clipped");
    });

    $(".modal-close").click(function(event) {
        event.preventDefault();
        $('.modal').removeClass("is-active");
        $('.html').removeClass("is-clipped");
    });

    //Login Form after submission
    var logfrm = $("form[name='login_form']");
    $("form[name='login_form']").submit(function(event) {
        event.preventDefault();

        if ($("#l_uname").val().trim() == "" ||
            $("#l_password").val().trim() == "") {
            $('#my_popup span').text('All fields are required.');
            $('#my_popup').popup('show');
        } else {

            $.ajax({
                type: logfrm.attr('method'),
                url: logfrm.attr('action'),
                data: logfrm.serialize(), // serializes the form's elements
                dataType: 'JSON',
                success: function(result) {

                    if (result[0].success == "yes") {

                        $.redirect("./session.php", { 'userid': result[0].userid, 'user': result[0].uname }, "POST", "_self");


                    } else {
                        $('#my_popup span').text("The username " + result[0].uname + " and password " + result[0].password + " does not match!");
                        $('#my_popup').popup('show');
                    }

                },
                error: function(result) {
                    $('#my_popup span').text("An error occurred with your login");
                    $('#my_popup').popup('show');
                },
            }); // End of ajax 

        } // End of else 

    }); // End of login form 

    //Signup Form after submission
    var frm = $("form[name='signup_form']");
    $("form[name='signup_form']").submit(function(event) {
        event.preventDefault();

        if ($("#uname").val().trim() == "" ||
            $("#password").val().trim() == "" ||
            $("#confirm_password").val().trim() == "") {
            $('#my_popup span').text('All fields are required.');
            $('#my_popup').popup('show');

        } else if ($("#password").val() != $("#confirm_password").val()) {
            $('#my_popup span').text('Passwords should be same');
            $('#my_popup').popup('show');

        } else if ($("#uname").val().trim() != "" &&
            $("#password").val().trim() != "" &&
            $("#confirm_password").val().trim() != "" &&
            $("#password").val() == $("#confirm_password").val()) {

            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(), // serializes the form's elements.
                dataType: 'JSON',
                success: function(result) {
                    if (result[0].success == "yes") {
                        $('#my_popup span').text("Your registration " + result[0].uname + " is successful.");
                        $('#my_popup').popup('show');
                    } else {
                        $('#my_popup span').text("The username " + result[0].uname + " is found. Please choose a different username.");
                        $('#my_popup').popup('show');
                    }
                    $('.modal').removeClass("is-active");
                    $('.html').removeClass("is-clipped");
                },
                error: function(result) {
                    $('#my_popup span').text("An error occurred with your registration.");
                    $('#my_popup').popup('show');
                },
            }); // End of ajax 

        } // End of else if 

    }); // End of Signup form

});
