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

        // Delete particular question
        $("a.question").click(function(event) {
            var qid = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: 'question_delete.php',
                data: { 'qid': qid },
                dataType: 'JSON',
                success: function(result) {

                    if (result[0].success == "yes") {
                        $.redirect("./question.php", { 'sessionid': result[0].sessionid }, "POST", "_self");
                    } else {
                        $('#my_popup span').text("Fail to delete question");
                        $('#my_popup').popup('show')
                    }
                },
                error: function(result) {
                    $('#my_popup span').text("An error occurred with your question deletion");
                    $('#my_popup').popup('show');
                },
            }); // End of ajax


        }); // End of click on particular question

        // Submit on create question form
        var frm = $("form[name='question_form']");
        $("form[name='question_form']").submit(function(event) {

            event.preventDefault();

            if ($("#sName").val().trim() == "" ||
                $("#loc").val().trim() == "" ||
                $("#question").val().trim() == "") {
                $('#my_popup span').text('All fields are required.');
                $('#my_popup').popup('show');

            } else {

                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(), // serializes the form's elements.
                    dataType: 'JSON',
                    success: function(result) {
                        if (result[0].success == "yes") {
                            //window.location.reload();
                            $.redirect("./question.php", { 'sessionid': result[0].sessionid }, "POST", "_self");


                        } else {

                            $('#my_popup span').text("Your question submission is unsuccessful.");
                            $('#my_popup').popup('show');

                        }
                        $('.modal').removeClass("is-active");
                        $('.html').removeClass("is-clipped");
                    },
                    error: function(result) {
                        $('#my_popup span').text("An error occurred with your question submission.");
                        $('#my_popup').popup('show');
                    },
                }); // End of ajax

            } // End of else if

        }); // End of create question form

    });