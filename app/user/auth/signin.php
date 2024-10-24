<?php

$isAuthNotRequired = true;
require_once "../../config/autoload.php";

if ($uid) {
    header("Location:../../");
    die();
}

// get auth urls
require_once "../../../clients/google.php";
$google_auth = $googleClient->getAuthorizationUrl();

// facebook auth
require_once "../../../clients/facebook.php";
$facebook_auth = $fbHelper->getLoginUrl("$baseurl/app/user/auth/signin-facebook.php", ['email']);

// github auth url
require_once "../../../clients/github.php";
$github_auth = $github_client->getAuthorizationUrl();
$_SESSION['oauth2state'] = $github_client->getState();

require_once "../../includes/layout/head.php";
?>

<body class="bg-white d-flex flex-center pt-0">

    <!-- BODY -->
    <?php require_once "../../includes/alert.php" ?>

    <!-- LOGIN CONTAINER WITH SOCIAL LOGIN BUTTONS -->
    <div class="container">
        <div class="row flex-center">
            <div class="col-md-6 col-xl-5">
                <div class="d-flex flex-center gap-3">
                    <img src="../../images/brand_logo.webp" alt="#" class="img-contain" height="40">
                    <h3 class="m-0 fw-bold">Cloud Storage</h3>
                </div>
                <div class="signin-form rounded-4 mt-3 bg-light p-4">
                    <i class="fa-solid fa-lock icon-lg"></i>
                    <h3 class="mt-2 mb-0 fw-bolder text-muted">Signin</h3>
                    <small>We concern your privacy,<br> your data is <i class="text-success fw-bold">end-to-end encrypted</i></small>

                    <?php

                    $err = $_GET['err'] ?? null;
                    if ($err) {
                        if ($err == "auth0") {
                            $err_msg = "Invalid account, the account you are trying is not verified or is not associated with s valid email address !";
                        } else {
                            $err_msg = "Something went wrong !";
                        }

                        echo "<div class='mt-3'>
                                <div class='alert alert-warning border-0'>
                                    <div class='d-flex ycenter gap-3'>
                                        <i class='fa-solid fa-circle-exclamation'></i>
                                        <span class='fw-light'>$err_msg</span>
                                    </div>
                                </div>
                            </div>";
                    }

                    ?>

                    <div class="signin-btns mt-3">
                        <a href="<?php echo $google_auth ?>" class="btn bg-white has-icon justify-content-start rounded-5 py-3 px-4 auth-red-btn">
                            <i class="fa-brands fa-google icon-md text-dark"></i>
                            <span class="text-dark">Continue with google</span>
                        </a>
                        <a href="<?php echo $facebook_auth ?>" class="btn bg-prime-color has-icon justify-content-start rounded-5 py-3 px-4 mt-3 auth-red-btn">
                            <i class="fa-brands fa-facebook icon-md"></i>
                            <span>Continue with Facebook</span>
                        </a>
                        <a href="<?php echo $github_auth ?>" class="btn bg-dark-color has-icon justify-content-start rounded-5 py-3 px-4 mt-3 auth-red-btn">
                            <i class="fa-brands fa-github icon-md"></i>
                            <span>Continue with Github</span>
                        </a>
                    </div>
                    <small class="d-block mt-3 text-center">By Continue, You Agreed To Our <a href="#">Terms</a> And <a href="#">Services</a></small>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/user/signin.js"></script>
</body>

</html>