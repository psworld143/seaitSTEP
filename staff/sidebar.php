<div class="sidebar">
  <div class="sidebar-inner">
    <!-- Sidebar Header -->
    <div class="sidebar-logo">
      <div class="peers ai-c fxw-nw">
        <div class="peer peer-greed">
          <a class="sidebar-link td-n" href="index.html">
            <div class="peers ai-c fxw-nw">
              <div class="peer">
                <div class="logo">
                  <center>
                    <img src="../images/seait.png" alt="SEAIT Logo" style="width: 50px; height: 50px; padding: 4px; margin-top: 6%;">
                  </center>
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
            <a href="#" class="td-n">
              <i class="ti-arrow-circle-left"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $department_pages = ['departments.php', 'view_instructors.php', 'profile.php'];
    $employees_page = ['employees.php', 'subject_evaluations.php', 'p2p_evaluation_result.php', 'h2f_evaluation_result.php'];
    ?>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu scrollable pos-r">
      <!-- Departments -->
      <li class="nav-item">
        <a class="sidebar-link <?php echo in_array($current_page, $department_pages) ? 'actived' : ''; ?>" href="departments.php">
          <span class="icon-holder">
            <i class="c-orange-500 ti-layout-list-thumb"></i>
          </span>
          <span class="title">Departments</span>
        </a>
      </li>

      <!-- Instructors -->
      <li class="nav-item">
        <a class="sidebar-link <?php echo in_array($current_page, $employees_page) ? 'actived' : ''; ?>" href="employees.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-id-badge"></i>
          </span>
          <span class="title">Instructors</span>
        </a>
      </li>

      <!-- FM-HRD 11 Dropdown -->
      <li class="nav-item dropdown">
        <a class="dropdown-toggle <?= in_array($current_page, ['categories.php', 'questionaires.php']) ? 'active' : ''; ?>" href="javascript:void(0);" onclick="toggleDropdown(this)">
          <span class="icon-holder">
            <i class="c-red-500 ti-bar-chart"></i>
          </span>
          <span class="title">FM-HRD 11</span>
          <span class="arrow">
            <i class="ti-angle-right"></i>
          </span>
        </a>
        <ul class="dropdown-menu <?= in_array($current_page, ['categories.php', 'questionaires.php']) ? 'show' : ''; ?>">
          <li>
            <a class="sidebar-link <?= ($current_page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">Categories</a>
          </li>
          <li>
            <a class="sidebar-link <?= ($current_page == 'questionaires.php') ? 'active' : ''; ?>" href="questionaires.php">Questionnaires</a>
          </li>
        </ul>
      </li>

      <!-- Academic Year -->
      <li class="nav-item">
        <a class="sidebar-link <?= ($current_page == 'academic_year.php') ? 'actived' : ''; ?>" href="academic_year.php">
          <span class="icon-holder">
            <i class="c-blue-500 ti-pencil-alt"></i>
          </span>
          <span class="title">Academic Year</span>
        </a>
      </li>
    </ul>
  </div>
</div>