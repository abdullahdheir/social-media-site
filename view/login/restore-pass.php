<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt1 = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt1->execute([$_SESSION['pass_id']]);
    $row1 = $stmt1->fetch();
    if ($stmt1->rowCount() > 0) {
        $old_pass = filter_var($_POST['oldPass'], FILTER_SANITIZE_STRING);
        $new_pass = filter_var($_POST['newPass'], FILTER_SANITIZE_STRING);
        $con_pass = filter_var($_POST['ConPass'], FILTER_SANITIZE_STRING);
        $hashPass = md5($new_pass);
        if (md5($old_pass) == $row1['password']) {
            $stmt2 = $conn->prepare("UPDATE users SET password = ? , updated_at = ? WHERE id = ?");
            $stmt2->execute([$hashPass, date("Y-m-d h:i:sa"), $_SESSION['pass_id']]);
            if ($stmt2->rowCount() > 0) {
                header('location:' . $route . 'login');
                exit();
            }
        }
    }
} else {
    $id = $_SESSION['pass_id'];
    if (!empty($get)) {
        $stmt = $conn->prepare("SELECT * FROM password_reset  WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            if ($get == $row['code_password']) {
?>
                <style>
                    .pass_show {
                        position: relative
                    }

                    .pass_show .ptxt {

                        position: absolute;

                        top: 50%;

                        right: 10px;

                        z-index: 1;

                        color: #f36c01;

                        margin-top: -10px;

                        cursor: pointer;

                        transition: .3s ease all;

                    }

                    .pass_show .ptxt:hover {
                        color: #333333;
                    }
                </style>
                <div class="container">
                    <div class="row">
                        <form action="<?= $route . 'forget-password/' . $get ?>" method="POST" class="col-sm-4">
                            <label>Current Password</label>
                            <div class="form-group pass_show">
                                <input type="password" name="oldPass" class="form-control" placeholder="Current Password">
                            </div>
                            <label>New Password</label>
                            <div class="form-group pass_show">
                                <input type="password" name="newPass" class="form-control" placeholder="New Password">
                            </div>
                            <label>Confirm Password</label>
                            <div class="form-group pass_show">
                                <input type="password" name="ConPass" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="form-group pass_show">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('.pass_show').append('<span class="ptxt">Show</span>');
                    });


                    $(document).on('click', '.pass_show .ptxt', function() {

                        $(this).text($(this).text() == "Show" ? "Hide" : "Show");

                        $(this).prev().attr('type', function(index, attr) {
                            return attr == 'password' ? 'text' : 'password';
                        });

                    });
                </script>
<?php
            }
        }
    }
}
