<div class="sidebar">
  <div class="sidebar-inner">
    <!-- ### $Sidebar Header ### -->
    <div class="sidebar-logo">
      <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
          <a class="sidebar-link td-n" href="index.html">
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
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <!-- ### $Sidebar Menu ### -->
    <ul class="sidebar-menu scrollable pos-r">
      <!-- <li class="nav-item mT-30 actived">
        <a class="sidebar-link" href="index.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Dashboard</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="sidebar-link" href="departments.php">
          <span class="icon-holder">
            <i class="c-orange-500 ti-layout-list-thumb"></i>
          </span>
          <span class="title">Departments</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="sidebar-link" href="employees.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-id-badge"></i>
          </span>
          <span class="title">Instructors</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="dropdown-toggle <?php echo ($current_page == 'categories.php' || $current_page == 'questionaires.php') ? 'active' : ''; ?>"
          href="javascript:void(0);" onclick="toggleDropdown(this)">
          <span class="icon-holder">
            <i class="c-red-500 ti-bar-chart"></i>
          </span>
          <span class="title" title="Employee Performance Appraisal Form">FM-HRD 11</span>
          <span class="arrow">
            <i class="ti-angle-right"></i>
          </span>
        </a>
        <ul class="dropdown-menu <?php echo ($current_page == 'categories.php' || $current_page == 'questionaires.php') ? 'show' : ''; ?>">
          <li>
            <a class="sidebar-link <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">Categories</a>
          </li>
          <li>
            <a class="sidebar-link <?php echo ($current_page == 'questionaires.php') ? 'active' : ''; ?>" href="questionaires.php">Questionnaires</a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="sidebar-link" href="academic_year.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-pencil-alt"></i>
          </span>
          <span class="title">Academic Year</span>
        </a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="dropdown-toggle" href="javascript:void(0);">
          <span class="icon-holder">
            <i class="c-green-500 ti-pie-chart"></i>
          </span>
          <span class="title">Peer Questionaires</span>
          <span class="arrow">
            <i class="ti-angle-right"></i>
          </span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a class="sidebar-link" href="p2p_categories.php">Categories</a>
          </li> 
          <li>
            <a class="sidebar-link" href="p2p_questionaires.php">Questionaires</a>
          </li> 
        </ul>
      </li> -->
      <!--      <li class="nav-item">
        <a class="sidebar-link" href="evaluation_sheet.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-share"></i>
          </span>
          <span class="title">Evaluation Sheet</span>
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="sidebar-link" href="manage_user.php">
          <span class="icon-holder">
            <i class="c-yellow-500 ti-user"></i>
          </span>
          <span class="title">User Management</span>
        </a>
      </li> -->

    </ul>


  </div>
</div>