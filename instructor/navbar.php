<?php
  $full = $_SESSION['fullname'];
  
  
?>
<div class="header navbar">
          <div class="header-container">
            <ul class="nav-left">
              <li>
                <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                  <i class="ti-menu"></i>
                </a>
              </li>
              <li class="search-box">
                <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                  <i class="search-icon ti-search pdd-right-10"></i>
                  <i class="search-icon-close ti-close pdd-right-10"></i>
                </a>
              </li>
              <li class="search-input">
                <input class="form-control" type="text" placeholder="Search...">
              </li>
            </ul>
            <ul class="nav-right">
              <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="peer mR-10">
                    <i class="c-blue-500 ti-user"></i>
                  </div>
                  <div class="peer">
                    <span class="fsz-sm c-grey-900"><?php echo $full; ?></span>
                  </div>
                </a>
                <ul class="dropdown-menu fsz-sm" aria-labelledby="dropdownMenuLink">
                  <li>
                    <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700" data-bs-toggle="modal" data-bs-target="#changePass">
                      <i class="ti-key mR-10"></i>
                      <span>Change Password</span>
                    </a>
                  </li>
                  <li role="separator" class="divider"></li>
                  <li>
                    <a href="../backend_scripts/logout.php" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                      <i class="ti-power-off mR-10"></i>
                      <span>Logout</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        
        <div class="modal fade" id="changePass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="change_password.php" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Type you new password below</label>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>" >
                    <input type="password" class="form-control" name="new_pass" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="New Password" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Confirm you new password below</label>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>" >
                    <input type="password" class="form-control" name="new_pass1" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Confirm Password" required>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm btn-color" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary btn-sm btn-color">Change Now</button>
                </div>
              </form>
            </div>
          </div>
        </div>