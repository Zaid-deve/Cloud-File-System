<?php


require_once "config/autoload.php";
require_once "includes/layout/head.php";
?>

<link rel="stylesheet" href="/cfs/app/styles/error404.css">
</head>

<body class="d-flex flex-center pt-0">

    <div class="container">
        <div class="row xcenter">
            <div class="col-md-8 col-xl-6">
                <div class="text-center text-light">
                    <div class="text-404" style="font-size: clamp(6rem, 40vw, 8rem);">404</div>
                    <h1>Oops! Something wrong…</h1>
                    <p class="mt-4">Curabitur blandit tempus porttitor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas faucibus mollis interdum.</p>
                    <div class="d-flex gap-3 flex-center flex-wrap mt-3">
                        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?? '/cfs/app'; ?>" class="btn py-3 px-5 bg-prime-color rounded-5 has-icon"><i class="fa-solid fa-arrow-left"></i><span>Go back</span></a>
                        <a href="/cfs/app" class="btn py-3 px-5 bg-white rounded-5 has-icon"><i class="fa-solid fa-home text-dark"></i><span class="text-dark">Go Home</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>