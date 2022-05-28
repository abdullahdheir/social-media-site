<?php

if (!isset($_SESSION['v_email'])) {
    header('location:' . $route . 'login');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = (string)filter_var($_POST['one'], FILTER_SANITIZE_NUMBER_INT);
    $code .= (string)filter_var($_POST['two'], FILTER_SANITIZE_NUMBER_INT);
    $code .= (string)filter_var($_POST['three'], FILTER_SANITIZE_NUMBER_INT);
    $code .= (string)filter_var($_POST['four'], FILTER_SANITIZE_NUMBER_INT);
    $mail = filter_var($_SESSION['v_email'], FILTER_SANITIZE_EMAIL);
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$mail]);
    $row = $stmt->fetch();

    if ($stmt->rowCount() > 0) {
        if ($code == $row['v_code']) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['fname'];
            $stmt1 = $conn->prepare('UPDATE users SET is_active = 1 WHERE id = ?');
            $stmt1->execute([$row['id']]);
            if ($stmt1->rowCount() > 0) {
?>
                <script>
                    location.href = '<?= $route ?>'
                </script>
<?php
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
    <title>Verification</title>
    <style>
        #wrapper {
            font-family: Lato;
            font-size: 1.5rem;
            text-align: center;
            box-sizing: border-box;
            color: #333;
        }

        #wrapper #dialog {
            border: solid 1px #ccc;
            margin: 10px auto;
            padding: 20px 30px;
            display: inline-block;
            box-shadow: 0 0 4px #ccc;
            background-color: #faf8f8;
            overflow: hidden;
            position: relative;
            max-width: 450px;
        }

        #wrapper #dialog h3 {
            margin: 0 0 10px;
            padding: 0;
            line-height: 1.25;
        }

        #wrapper #dialog span {
            font-size: 90%;
        }

        #wrapper #dialog #form {
            max-width: 240px;
            margin: 25px auto 0;
        }

        #wrapper #dialog #form input {
            margin: 0 5px;
            text-align: center;
            line-height: 80px;
            font-size: 50px;
            border: solid 1px #ccc;
            box-shadow: 0 0 5px #ccc inset;
            outline: none;
            width: 20%;
            transition: all 0.2s ease-in-out;
            border-radius: 3px;
        }

        #wrapper #dialog #form input:focus {
            border-color: purple;
            box-shadow: 0 0 5px purple inset;
        }

        #wrapper #dialog #form input::-moz-selection {
            background: transparent;
        }

        #wrapper #dialog #form input::selection {
            background: transparent;
        }

        #wrapper #dialog #form button {
            margin: 30px 0 50px;
            width: 100%;
            padding: 6px;
            background-color: #b85fc6;
            border: none;
            text-transform: uppercase;
        }

        #wrapper #dialog button.close {
            border: solid 2px;
            border-radius: 30px;
            line-height: 19px;
            font-size: 120%;
            width: 22px;
            position: absolute;
            right: 5px;
            top: 5px;
        }

        #wrapper #dialog form {
            position: relative;
            z-index: 1;
        }

        #wrapper #dialog img {
            position: absolute;
            bottom: -70px;
            right: -63px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="dialog">
            <h3>Please enter the 4-digit verification code we sent via EMAIL:</h3>
            <span>(we want to make sure it's you before we contact our movers)</span>
            <form id="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="text" name="one" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input type="text" name="two" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input type="text" name="three" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <input type="text" name="four" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                <button type="submit" class="btn btn-primary ">Verify</button>
            </form>

            <div>
                Didn't receive the code?<br />
                <a href="#" id="resendVCode">Send code again</a><br />
                <a href="#" onclick="event.preventDefault(); history.back();">Change Email</a>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(function() {
        'use strict';

        var body = $('body');

        function goToNextInput(e) {
            var key = e.which,
                t = $(e.target),
                sib = t.next('input');

            if (key != 9 && (key < 48 || key > 57)) {
                e.preventDefault();
                return false;
            }

            if (key === 9) {
                return true;
            }

            if (!sib || !sib.length) {
                sib = body.find('input').eq(0);
            }
            sib.select().focus();
        }

        function onKeyDown(e) {
            var key = e.which;

            if (key === 9 || (key >= 48 && key <= 57)) {
                return true;
            }

            e.preventDefault();
            return false;
        }

        function onFocus(e) {
            $(e.target).select();
        }

        body.on('keyup', 'input', goToNextInput);
        body.on('keydown', 'input', onKeyDown);
        body.on('click', 'input', onFocus);

        function resendVCode() {
            $.ajax({
                type: 'GET',
                url: 'resndmail.php',
                success: function(data) {
                    console.log(data)
                }
            })
        }
        $('#resendVCode').on('click', function(e) {
            e.preventDefault()
            resendVCode()
            var time = 30
            let counter = setInterval(() => {
                time--
                $(this).html(`Send Code Again After ${time}s`)
                $(this).attr('style', 'cursor: not-allowed;user-select: none;pointer-events: none;color:gray;')
            }, 1000);
            setTimeout(() => {
                clearInterval(counter)
                $(this).removeAttr('style')
                $(this).html(`Send code again`)
            }, 30000);
        })
    })
</script>