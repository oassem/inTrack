<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./pics/icons8-system-task-64.png">
</head>

<body>
    <div class="pt-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:white !important">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto justify-content-between mx-auto" style="width:95%">
                    <li class="nav-item" style="margin-right:-2%" id="nav-logo">
                        <a class="navbar-brand">
                            <img src="./pics/nweave-logo.jpg" width="100" height="100">
                        </a>
                    </li>
                    <li class="nav-item" style="text-align: center;">
                        <h2><span style="color:#8AC640">in</span>Track</h2>
                        <h2>تتبع إستهلاك الإنترنت</h2>
                    </li>
                    <li class="nav-item" id="nav-date">
                        <div class="d-flex justify-content-center">
                            <i class="bi bi-calendar2 px-3" style="font-size:27px; color:#8AC640"></i>
                            <h5 class="pt-1">
                                <?php
                                $d = new DateTime();
                                echo $d->format('Y-m-d');
                                ?>
                            </h5>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="login-div" style="width:40%; margin-top:8%" class="mx-auto">
            <div style="text-align:center">
                <form method="post">
                    <div class="mb-4 d-flex">
                        <i class="bi bi-person-fill px-2" style="font-size:30px; color:#59595B"></i>
                        <input name="username" type="text" class="form-control border border-secondary" placeholder="اسم المستخدم">
                    </div>
                    <div class="mb-4 d-flex">
                        <i class="bi bi-lock-fill px-2" style="font-size:30px; color:#59595B"></i>
                        <input name="password" type="password" class="form-control border border-secondary" placeholder="كلمة المرور">
                    </div>
                    <?php
                    if (isset($_POST['username']) || isset($_POST['password'])) {
                        echo '<span class="text-danger">
                        خطأ في بيانات المستخدم، الرجاء المحاولة مرة أخرى!
                        </span><br>';
                    }
                    ?>
                    <button name="login" id="login" type="submit" class="btn text-white my-5" style="background-color:#8AC640; font-weight:600; font-size:larger">تسجيل الدخول <i class="bi bi-door-open px-1"></i></button>
                </form>
            </div>

            <?php
            include 'database_conf.php';
            ob_start();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $sql = "SELECT * FROM users where username='admin'";
            $row = $conn->query($sql)->fetch_assoc();

            if (isset($_POST['login'])) {
                if ($_POST['username'] == 'admin' && $_POST['password'] == $row['PASSWORD']) {
                    $_SESSION['email'] = $row['email'];
                    header("Location: ./home.php");
                }
            }
            $conn->close();
            ?>
        </div>
    </div>

    <footer id="login-footer" class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <b><i class="bi bi-exclude px-1"></i> Developed by nWeave Development Team</b>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>