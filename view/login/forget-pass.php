<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- bootstrap 4.3.1 -->
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
    <!-- bootstrap icon 1.8 -->
    <link rel="stylesheet" href="include/library/bootstrap-icons/bootstrap-icons.css">
    <!-- styles -->
    <link rel="stylesheet" href="css/styles.min.css">
    <!-- favicon -->
    <link rel="icon" href="img/favicon.ico">
    <title>Vikinger | login </title>
</head>

<body>
    <!-- LANDING -->
    <div class="landing">
        <!-- LANDING DECORATION -->
        <div class="landing-decoration"></div>
        <!-- /LANDING DECORATION -->

        <!-- LANDING INFO -->
        <div class="landing-info">
            <!-- LOGO -->
            <div class="logo">
                <!-- ICON LOGO VIKINGER -->
                <svg class="icon-logo-vikinger">
                    <use xlink:href="#svg-logo-vikinger"></use>
                </svg>
                <!-- /ICON LOGO VIKINGER -->
            </div>
            <!-- /LOGO -->

            <!-- LANDING INFO PRETITLE -->
            <h2 class="landing-info-pretitle">Welcome to</h2>
            <!-- /LANDING INFO PRETITLE -->

            <!-- LANDING INFO TITLE -->
            <h1 class="landing-info-title">Vikinger</h1>
            <!-- /LANDING INFO TITLE -->

            <!-- LANDING INFO TEXT -->
            <p class="landing-info-text">The next generation social network &amp; community! Connect with your friends and play with our quests and badges gamification system!</p>
            <!-- /LANDING INFO TEXT -->
        </div>
        <!-- /LANDING INFO -->

        <!-- LANDING FORM -->
        <div class="landing-form" style="margin-top: 88px;">
            <!-- FORM BOX -->
            <div class="form-box login-register-form-element">
                <!-- FORM BOX DECORATION -->
                <img class="form-box-decoration overflowing" src="img/landing/rocket.png" alt="rocket">
                <!-- /FORM BOX DECORATION -->

                <!-- FORM BOX TITLE -->
                <h2 class="form-box-title">Restore Password</h2>
                <!-- /FORM BOX TITLE -->

                <!-- FORM -->
                <form class="form" id="login-form" method="post">
                    <div id="ajax"></div>
                    <!-- FORM ROW -->
                    <div class="form-row">
                        <!-- FORM ITEM -->
                        <div class="form-item">
                            <!-- FORM INPUT -->
                            <div class="form-input">
                                <label for="forget-email"> Email</label>
                                <input type="text" id="forget-email" name="forget_email">
                            </div>
                            <!-- /FORM INPUT -->
                            <div class="text-danger" style="display:none;" id="email-error"></div>
                        </div>
                        <!-- /FORM ITEM -->
                    </div>
                    <!-- /FORM ROW -->
                    <!-- FORM ROW -->
                    <div class="form-row">
                        <!-- FORM ITEM -->
                        <div class="form-item">
                            <!-- BUTTON -->
                            <button class="button medium secondary" type="submit">Send Code </button>
                            <!-- /BUTTON -->
                        </div>
                        <!-- /FORM ITEM -->
                    </div>
                    <!-- /FORM ROW -->
                </form>
                <!-- /FORM -->
            </div>
            <!-- /FORM BOX -->
        </div>
        <!-- /LANDING FORM -->
    </div>
    <!-- /LANDING -->
    <!-- JQuery -->
    <script src="js/jquery/jquery.min.js"></script>
    <!-- app -->
    <script src="js/utils/app.js"></script>
    <!-- XM_Plugins -->
    <script src="js/vendor/xm_plugins.min.js"></script>
    <!-- form.utils -->
    <script src="js/form/form.utils.js"></script>
    <!-- landing.tabs -->
    <script src="js/landing/landing.tabs.js"></script>
    <!-- SVG icons -->
    <script src="js/utils/svg-loader.js"></script>
    <script src="js/ajax/forget-pass.js"></script>
</body>

</html>