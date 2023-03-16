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
        $sql = "select * from lineshistory where phoneNumber=" . $_SESSION['id'] . " order by dateIn, reading";
        $result = $conn->query($sql);
        ?>

        <div style="width:95%; margin-top:10%" class="mx-auto">
            <div class="table-responsive">
                <table class="table mb-5" style="width:1000px" id="history-table">
                    <thead style="font-size:1.1rem">
                        <tr>
                            <th scope="col">التاريخ</th>
                            <th scope="col">القراءة</th>
                            <th scope="col">إثبات القراءة</th>
                            <th scope="col">رفع الإثبات (أو تعديله)</th>
                            <th scope="col">مراجعة الإثبات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $temp = '<span class="text-danger" style="font-weight:700">برجاء الرفع</span>';
                                if ($row['image'] != null) {
                                    $temp = 'تم الرفع';
                                }
                                echo '<tr>
                            <th>' . $row['dateIn'] . '</th>
                            <td>' . $row['reading'] . ' جيجا بايت</td>
                            <td>' . $temp . '</td>
                            <td>
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                                    <button style="width:30%" id="add-image" name="add-image" value="' . $row['id'] . '" class="btn btn-primary mt-3">رفع <i class="bi bi-cloud-arrow-up-fill px-1"></i></button>
                                </form>
                            </td>
                            <td>
                                <form action="view.php" method="post">
                                    <button id="view-image" name="view-image" value="' . $row['id'] . '" class="btn btn-secondary">مراجعة <i class="bi bi-eye-fill px-1"></i></button>
                                </form>
                            </td>
                            </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <form method="post" class="mb-5">
                <div id="history-home-btn" class="w-25 mx-auto">
                    <button name="history-home" id="add-home-2" type="submit" class="btn btn-light" style="color:#666; font-weight:700; font-size:large">الصفحة الرئيسية <i class="bi bi-house-fill px-1"></i></button>
                </div>
            </form>
        </div>

        <?php
        if (isset($_POST['history-home'])) {
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