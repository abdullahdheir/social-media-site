$(function () {
    let arr = []
    $('#forget-email').blur(function () {
        let value = $(this).val()
        if (value.length > 1) {
            var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
            if (!pattern.test(value)) {
                $('#email-error').html('Invalid Email Format !!')
                $('#email-error').show(300)
                arr[0] = 'email';
            } else {
                arr.pop()
            }
        } else {

        }
    })
    $('#forget-email').keyup(function () {
        $('#email-error').hide(300)
    })

    $(document).on('submit', '#login-form', function (e) {
        e.preventDefault()
        let time = 30
        let Form = $(this)
        let email = $('#forget-email').val()
        if (email == '') {
            $('#email-error').html('Invalid Email Format !!')
            $('#email-error').show(300)
            arr[0] = 'email'
        }
        if (arr.length == 0) {
            $.ajax({
                type: 'POST',
                url: 'include/ajax/main.php?do=forget-password',
                beforeSend: function () {
                    Form.find("button[type='submit']").append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
                    Form.find("button[type='submit']").attr('disabled', 'true')
                },
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 'success') {
                        $('#ajax').html(`<div class="alert alert-success">Send Code Into <strong>${email}</strong> Successfully !!</div>`)
                        Form.find("button[type='submit']").attr('disabled', 'true')
                        let counter = setInterval(() => {
                            time--
                            Form.find("button[type='submit']").attr('disabled', 'true')
                            Form.find("button[type='submit']").attr('style', 'cursor: not-allowed;user-select: none;')
                            Form.find("button[type='submit']").removeClass('secondary')
                            Form.find("button[type='submit']").html(`Send Code Again After ${time}s`)
                            Form.find("button[type='submit']").addClass('btn-secondary')
                        }, 1000);
                        setTimeout(() => {
                            clearInterval(counter)
                            Form.find("button[type='submit']").removeAttr('disabled')
                            Form.find("button[type='submit']").removeAttr('style')
                            Form.find("button[type='submit']").removeClass('btn-secondary')
                            Form.find("button[type='submit']").addClass('secondary')
                            Form.find("button[type='submit']").html(`Send Code`)
                        }, 30000);
                    } else {
                        $('#ajax').html(`<div class="alert alert-danger">${data}</div>`)
                    }
                },
                complete: function (data) {
                    setTimeout(() => {
                        $('.spinner-border').remove()
                        Form.find("button[type='submit']").removeAttr('disabled')
                    }, 2000);
                }
            })
        }

    })
})