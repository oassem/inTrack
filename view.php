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

        <?php
        $sql = "SELECT * FROM lineshistory where id='" . $_POST['view-image'] . "'";
        $row = $conn->query($sql)->fetch_assoc();
        $conn->close();

        if (isset($_POST['logout'])) {
            header("Location: ./index.php");
            session_destroy();
        }
        ?>

        <div class="card mx-5 mb-5" style="width:40%; margin-top:8%" id="view-card">
            <img src="data:image/jpg;charset-utf8;base64,<?php echo base64_encode($row['image']); ?>" class="card-img-top" height="400px">
            <div class="card-body">
                <div class="d-flex justify-content-between mt-4" id="view-buttons">
                    <button onclick="window.location.href='./history.php'" name="line-details" id="line-details" type="submit" class="btn" style="background:#8AC640; color:white; font-weight:700; font-size:meduim">العودة للخلف <i class="bi bi-arrow-return-left px-1"></i></button>
                    <button onclick="window.location.href='./home.php'" name="line-home" id="add-home" type="submit" class="btn" style="background:#666; color:white; font-weight:700; font-size:meduim">الرئيسية <i class="bi bi-house-fill px-1"></i></button>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <b><i class="bi bi-exclude px-1"></i> Developed by nWeave Development Team</b>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>