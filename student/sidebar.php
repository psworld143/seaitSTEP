<?php
$current_page = basename($_SERVER['PHP_SELF']);
$evaluation_pages = ['index.php', 'student_evaluation.php'];
?>
<div class="sidebar">
  <div class="sidebar-inner">
    <!-- ### $Sidebar Header ### -->
    <div class="sidebar-logo">
      <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
          <a class="sidebar-link td-n" href="#">
            <div class="peers ai-c fxw-nw">
              <div class="peer">
                <div class="logo">
                  <center><img src="../images/seait.png" alt="" style="width: 50px; height: 50px; padding: 4px; margin-top: 6%;"></center>
                </div>
              </div>
              <div class="peer peer-greed">
                <h5 class="lh-1 mB-0 logo-text">SEAIT-STEP</h5>
              </div>
            </div>
          </a>
        </div>
        <div class="peer">
          <div class="mobile-toggle sidebar-toggle">
            <a href="" class="td-n">
              <i class="ti-arrow-circle-left"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- ### $Sidebar Menu ### -->
    <ul class="sidebar-menu scrollable pos-r">
      <li class="nav-item">
        <a class="sidebar-link <?php echo ($current_page == 'index.php' || $current_page == 'student_evaluation.php') ? 'actived' : ''; ?>" href="index.php">
          <span class="icon-holder">
            <i class="c-brown-500 ti-files"></i>
          </span>
          <span class="title">Evaluation</span>
        </a>
      </li>
      <!--<li class="nav-item">
        <a class="sidebar-link <?php echo ($current_page == 'complaints.php') ? 'active' : ''; ?>" href="complaints.php">
          <span class="icon-holder">
            <i class="c-brown-500 ti-agenda"></i>
          </span>
          <span class="title">Complaints</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="sidebar-link <?php echo ($current_page == 'account_management.php') ? 'active' : ''; ?>" href="account_management.php">
          <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
          </span>
          <span class="title">Account Management</span>
        </a>
      </li> -->
    </ul>
  </div>
</div>