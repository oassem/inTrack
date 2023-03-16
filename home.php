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

        <div style="width:95%; margin-top:8%" class="mx-auto">
            <div id="add-line-btn">
                <button id="add-btn" type="button" onclick="window.location.href='./add.php'" class="btn" style="width:13%; background:#8AC640; color: white">
                    <div style="font-size:1.1rem; font-weight:700" class="pb-0">
                        إضافة خط
                        <i id="add-btn-icon" class="bi bi-plus-square-dotted" style="font-size: 30px; padding-right:8%"></i>
                    </div>
                </button>
            </div>

            <?php
            $sql = "SELECT * FROM linesinfo order by renew";
            $result = $conn->query($sql);
            ?>

            <div class="table-responsive mb-5">
                <table class="table mt-4" style="text-align:center; width: 1200px" id="main-table">
                    <thead>
                        <tr>
                            <th scope="col">رقم الخط</th>
                            <th scope="col">السعة الإجمالية</th>
                            <th scope="col">المتبقي</th>
                            <th scope="col">تاريخ التجديد</th>
                            <th scope="col">قراءة جديدة</th>
                            <th>إعدادات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                <th scope="row">' . $row['phoneNumber'] . '</th>
                                <td>' . $row['capacity'] . ' جيجا بايت</td>
                                <td>' . $row['dataLeft'] . ' جيجا بايت</td>
                                <td>' . $row['renew'] . '</td>
                                <td>
                                <div id="reading-div" class="form-group d-flex justify-content-center">
                                    <div id="reading-div-input" style="margin-left:2.5%" class="w-25">
                                        <input name="' . $row['phoneNumber'] . '" style="text-align:center" class="form-control form-control-sm w-100 mx-auto rounded" type="number" placeholder="0 جيجا">
                                    </div>
                                    <div id="add-reading" style="font-size:larger">
                                        <button name="add-reading" value="' . $row['phoneNumber'] . '" class="bi bi-plus-circle-dotted"></button>
                                    </div>
                                </div>
                                </td>
                                <td class="p-0">
                                <div id="icons" class="d-flex justify-content-around w-100 mx-auto py-2">
                                    <button name="edit-line" value="' . $row['phoneNumber'] . '" class="bi bi-pencil-fill" style="color:#8AC640"></button>
                                    <button name="history-line" value="' . $row['phoneNumber'] . '" class="bi bi-clock-history text-primary-emphasis"></button>
                                    <button onclick="return confirm(`هل حقاً تريد حذف هذا الخط؟`)" name="delete-line" value="' . $row['phoneNumber'] . '" class="bi bi-trash3-fill text-danger"></button>
                                </div>
                                </td>
                                </tr>';
                                }
                            }

                            if (isset($_POST['add-reading'])) {
                                $temp = $_POST['add-reading'];
                                $sql = "select * from linesinfo WHERE phoneNumber = '" . $_POST['add-reading'] . "';";
                                $row = $conn->query($sql)->fetch_assoc();
                                if ($_POST[$temp] != null && ($_POST[$temp] <= $row['capacity']) && $_POST[$temp] >= 0) {
                                    $sql = "UPDATE linesinfo SET dataLeft = " . $_POST[$temp] . " WHERE phoneNumber = '" . $_POST['add-reading'] . "';";
                                    $conn->query($sql);
                                    $sql = "INSERT INTO lineshistory(phoneNumber, reading, dateIn) VALUES('" . $temp . "', $_POST[$temp], CURRENT_DATE);";
                                    $conn->query($sql);
                                    $sql = "select * from linesinfo where phoneNumber=" . $temp . "";
                                    $row = $conn->query($sql)->fetch_assoc();
                                    if ($_POST[$temp] <= ($row['capacity'] * 0.3)) {
                                        //Email address of the receiver
                                        $to = "" . $_SESSION['email'] . "";
                                        //Email subject
                                        $subject = "Bundle Deadline";
                                        //Email message
                                        $message = "Bundle has 30% or less remaining, please be aware to bundle renew!";
                                        //Header information
                                        $headers = "From: Admin <admin@intracker.com>\r\n";
                                        //Send email
                                        mail($to, $subject, $message, $headers);
                                    }
                                    header("Refresh:1");
                                    echo '<div style="width:35%" id="alert" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    <div>تم إضافة قراءة جديدة للخط بنجاح <i class="bi bi-check-circle-fill px-2"></i></div>
                                    </div>';
                                }
                            } else if (isset($_POST['edit-line'])) {
                                $_SESSION['id'] = $_POST['edit-line'];
                                header("Location: ./edit.php");
                            } else if (isset($_POST['history-line'])) {
                                $_SESSION['id'] = $_POST['history-line'];
                                header("Location: ./history.php");
                            } else if (isset($_POST['delete-line'])) {
                                $sql = "delete from lineshistory where phoneNumber = '" . $_POST['delete-line'] . "'";
                                $conn->query($sql);
                                $sql = "delete from linesinfo where phoneNumber = '" . $_POST['delete-line'] . "'";
                                $conn->query($sql);
                                header("Refresh:0");
                            } else if (isset($_POST['logout'])) {
                                header("Location: ./index.php");
                                session_destroy();
                            }
                            $conn->close();
                            ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start bg-light text-muted">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <b><i class="bi bi-exclude px-1"></i> Developed by nWeave Development Team</b>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>