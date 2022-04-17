<aside class="main-sidebar">
  <section class="sidebar">
    <br>
    <div class="user-panel">
      <div class="pull-left image">
        <img src='<?php echo $User['image_path'] ?  '../' . $User['image_path'] :  '../images/profile.jpg'; ?>' class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $loginUser; ?> </p>
        <a><i class="fa fa-circle text-success"></i> <?php echo $loginUserRole; ?></a>
      </div>
    </div>
    <div>
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <br>
        </li>
        <li class="header">Dashboard</li>
        <li class="">
          <a href="../user_dashboard_module/user_dashboard.php">
            <i class="fa fa-bar-chart"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="">
          <a href="../reservation_module/create_reservation.php">
            <i class="fa fa-edit"></i> <span>Make a Reservations</span>
          </a>
        </li>
        <?php if ($loginUserRole == "Lecturer") { ?>
          <li class="">
            <a href="../reservation_module/my_reservations.php">
              <i class="fa fa-calendar-o "></i> <span>My Reservations </span>
            </a>
          </li>
        <?php } ?>

        <?php if ($loginUserRole == "Admin") { ?>
          <li class="header">ADMIN</li>
          <!-- <li><a href="../reservation_module/manage_reservation.php"><i class="fa fa-calendar"></i> <span> Reservations </span></a></li> -->
          <li><a href="../resource_module/resources.php"><i class="fa fa-university"></i> <span> Manage Resources </span></a></li>
          <li><a href="../resource_module/departments.php"><i class="fa fa-university"></i> <span> Manage Departments </span></a></li>
          <li><a href="../resource_module/faculties.php"><i class="fa fa-university"></i> <span> Manage Faculties </span></a></li>
          <li><a href="../user_module/lecturers.php"><i class="fa fa-users"></i> <span> Lecturers </span></a></li>
          <li><a href="../user_module/users.php"><i class="fa fa-user"></i> <span> Manage Users </span></a></li>
        <?php } ?>
        <?php if ($loginUserRole != "Lecturer") { ?>
          <li class="header">REPORT</li>
          <li><a href="../report_module/lecturer-report.php"><i class="fa fa-area-chart"></i> <span> Overall Report </span></a></li>
          <!-- <li><a href="../report_module/resource-report.php"><i class="fa fa-area-chart"></i> <span> Report By Resouce </span></a></li> -->
        <?php } ?>
        <li class="header">MY PROFILE</li>
        <li><a href="../user_module/profile.php"><i class="fa fa-user-circle"></i> <span> My Profile </span></a></li>
      </ul>
    </div>
  </section>
  <!-- /.sidebar -->
</aside>