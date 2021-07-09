<?php
require '../includes/conn.php';
include '../common/header.php';

if (!isset($_COOKIE['lecture-report-data'])) {
    header('../user_module/lecturers.php');
    exit();
}

$lectureId = $_COOKIE['lecture-report-data'];
$query = "SELECT * FROM users WHERE id=$lectureId ";
$result = mysqli_query($conn, $query);

$lecturer = [];
while ($row = mysqli_fetch_array($result)) {
    $lecturer = $row;
}


?>

<div class="wrapper">

    <?php include '../includes/navbar.php'; ?>
    <?php include '../includes/menubar.php'; ?>

    <div class="content-wrapper">

        <section class="content-header">
            <div class="col-xs-12">
                <h1> <?php echo  $lecturer['title'] . ' ' . $lecturer['firstname'] . ' ' . $lecturer['secondname'];  ?> </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users"></i> Lecturers</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </div>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <div class="box">


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include '../includes/scripts.php'; ?>
    <?php include '../includes/footer.php'; ?>
</div>

</html>