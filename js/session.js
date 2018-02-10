 $(document).ready(function() {
        $('#my_popup').popup({});

        // Check for click events on the navbar burger icon
        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").click(function() {
            $(".navbar-menu").toggleClass("is-active");
            $(".navbar-burger").toggleClass("is-active");
        });

        // Check for click events on the drowpdown
        // is-hidden is required to hide the dropdown items on hamburger
        // is-active is required to hide the dropdown items on big-screen
        $(".navbar-item.has-dropdown").click(function() {
            $(".navbar-item.has-dropdown").toggleClass("is-active");
            $(".navbar-dropdown").toggleClass("gen-is-hidden");
        });

        $("#sess a").click(function() {
            var currentId = $(this).attr('id');
            $.redirect("./question.php", { 'sessionid': currentId }, "POST", "_self");

        });

        // Submit of create session form
        var frm = $("form[name='session_form']");
        $("form[name='session_form']").submit(function(event) {
            event.preventDefault();

            if ($("#subject").val().trim() == "" ||
                $("#courseN").val().trim() == "" ||
                $('#room').val().trim() == "") {

                $("#my_popup span").text('All fields are required.');
                $('#my_popup').popup('show');
            } else {

                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(), // serializes the form's elements
                    success: function(result) {

                        if (result == "success") {
                            window.location.reload();
                        } else {

                            $('#my_popup span').text("Fail to create session");
                            $('#my_popup').popup('show')
                        }
                    },
                    error: function(result) {
                        $('#my_popup span').text("An error occurred with your session creation");
                        $('#my_popup').popup('show');
                    },
                }); // End of ajax 

            } // End of else 

        }); // End of crate session form
        
        // Remove corresponding session
        $('input:radio[name="answer"]').change(function() {

            var sessionid = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'session_delete.php',
                data: { 'sessionid': sessionid },
                success: function(result) {

                    if (result == "success") {
                        window.location.reload();
                    } else {
                        $('#my_popup span').text("Fail to delete session");
                        $('#my_popup').popup('show')
                    }
                },
                error: function(result) {
                    $('#my_popup span').text("An error occurred with your session deletion");
                    $('#my_popup').popup('show');
                },
            }); // End of ajax

        }); // End of remove corresponding session

    });
