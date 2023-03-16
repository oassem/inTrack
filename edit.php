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

<?php
include 'database_conf.php';
ob_start();
session_start();
if ($_SESSION['email'] == null) {
    header("Location: ./index.php");
}
?>

<body>
    <div class="pt-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:white !important">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto justify-content-between mx-auto" style="width:95%">
                    <li class="nav-item" style="margin-right:-2%" id="nav-logo">
                        <a class="navbar-brand" href="./home.php">
                            <img src="./pics/nweave-logo.jpg" width="100" height="100">
                        </a>
                    </li>
                    <li class="nav-item" style="text-align: center;">
                        <h2><span style="color:#8AC640">in</span>Track</h2>
                        <h2>تتبع إستهلاك الإنترنت</h2>
                    </li>
                    <li class="nav-item">
                        <div class="d-flex justify-content-around" id="nav-logout">
                            <h4 class="px-1">تسجيل خروج</h4>
                            <form method="post">
                                <button name="logout" class="bi bi-box-arrow-in-left" style="font-size:30px; color:#8AC640; background-color:white; border: none"></button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="edit-form" style="width:90%; margin-top:8%" class="mx-auto mb-5">
            <div class="mb-4">
                <h3>تعديل بيانات الخط</h3>
            </div>

            <?php
            $sql = "select * from linesinfo where phoneNumber=" . $_SESSION['id'] . "";
            $row = $conn->query($sql)->fetch_assoc();
            $left = $row['dataLeft'];
            ?>

            <form style="width:40%" method="post">
                <div class="form-group mb-4">
                    <input value="<?php echo $row['phoneNumber'] ?>" name="phone" type="text" class="form-control" placeholder="رقم الخط" style="background-color:rgba(102, 111, 125, 0.1);" disabled>
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group mb-4">
                    <input value="<?php echo $row['capacity'] ?>" name="data" type="number" class="form-control" placeholder="سعة الإستخدام (جيجا بايت)">
                </div>
                <div class="form-group mb-5">
                    <input value="<?php echo $row['renew'] ?>" name="date" type="date" class="form-control" style="text-align:right">
                    <small class="form-text text-muted">*تغيير ميعاد التجديد</small>
                </div>
                <div id="edit-buttons" class="d-flex justify-content-between">
                    <button name="edit-line" id="add-btn2" type="submit" class="btn" style="background:#8AC640; color:white; font-weight:700; font-size:large">تعديل الخط <i class="bi bi-pencil-fill px-1"></i></button>
                    <button name="add-home" id="add-home" type="submit" class="btn" style="background:#666; color:white; font-weight:700; font-size:large">الصفحة الرئيسية <i class="bi bi-house-fill px-1"></i></button>
                </div>
            </form>
        </div>

        <?php
        if (isset($_POST['edit-line'])) {
            $sql = "update linesinfo set phoneNumber = '" . $_SESSION['id'] . "', capacity = " . $_POST['data'] . ", dataLeft = " . $left . ", renew = '" . $_POST['date'] . "' where phoneNumber='" . $_SESSION['id'] . "'";
            $conn->query($sql);
            header("Location: ./home.php");
        } else if (isset($_POST['add-home'])) {
            header("Location: ./home.php");
        } else if (isset($_POST['logout'])) {
            header("Location: ./index.php");
            session_destroy();
        }
        $conn->close();
        ?>
    </div>

    <footer class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <b><i class="bi bi-exclude px-1"></i> Developed by nWeave Development Team</b>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>