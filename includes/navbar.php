<header class="main-header">

  <a href="../user_dashboard_module/user_dashboard.php" class="logo">
    <span class="logo-mini"><b>G</b>10</span>
    <span class="logo-lg"><b>G</b>10</span>
  </a>


  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src='../images/profile.jpg' class="user-image" alt="User Image">
            <span class="hidden-xs"> --Login User name-- </span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src='../images/profile.jpg' class="img-circle" alt="User Image">
              <p>
                Login Username
                <small>Member since </small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Update</a>
              </div>
              <div class="pull-right">
                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- Add -->
<div class="modal fade" id="profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Admin Profile</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="#" enctype="multipart/form-data">
          <div class="form-group">
            <label for="username" class="col-sm-3 control-label">Username</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="username" name="username" value="Username">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-9">
              <input type="password" class="form-control" id="password" name="password" value="password">
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">Firstname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname" value="First Name">
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Lastname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname" value="Last Name">
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Photo:</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo">
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="curr_password" class="col-sm-3 control-label">Current Password:</label>

            <div class="col-sm-9">
              <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="input current password to save changes" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="save"><i class="fa fa-check-square-o"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>