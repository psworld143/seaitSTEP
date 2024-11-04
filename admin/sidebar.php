
<div class="sidebar">
    <!-- Set background color to transparent -->
    <div class="sidebar-inner">
        <!-- ### $Sidebar Header ### -->
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="#">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <center>
                                        <img src="../images/seait.png" alt=""
                                            style="width: 50px; height: 50px; padding: 4px; margin-top: 6%;">
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
                        <a href="" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php
$current_page = basename($_SERVER['PHP_SELF']);
echo "Current Page: " . $current_page; // Debugging line
?>

        
        <!-- ### $Sidebar Menu ### -->
        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'departments.php') ? 'active' : ''; ?>"
                    href="departments.php">
                    <span class="icon-holder">
                        <i class="c-orange-500 ti-layout-list-thumb"></i>
                    </span>
                    <span class="title">Departments</span>
                </a>
            </li>
            <hr>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle <?php echo ($current_page == 'categories.php' || $current_page == 'questionaires.php') ? 'active' : ''; ?>"
                    href="javascript:void(0);" onclick="toggleDropdown(this)">
                    <span class="icon-holder">
                        <i class="c-red-500 ti-bar-chart"></i>
                    </span>
                    <span class="title">Student Questionnaires</span>
                    <span class="arrows">
                        <i class="ti-angle-right"></i> <!-- This will change to ti-angle-down when active -->
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="sidebar-link <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>"
                            href="categories.php">Categories</a>
                    </li>
                    <li>
                        <a class="sidebar-link <?php echo ($current_page == 'questionaires.php') ? 'active' : ''; ?>"
                            href="questionaires.php">Questionnaires</a>
                    </li>
                </ul>
            </li>
            <hr>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle <?php echo ($current_page == 'p2p_categories.php' || $current_page == 'p2p_questionaires.php') ? 'active' : ''; ?>"
                    href="javascript:void(0);" onclick="toggleDropdown(this)">
                    <span class="icon-holder">
                        <i class="c-green-500 ti-pie-chart"></i>
                    </span>
                    <span class="title">Peer Questionnaires</span>
                    <span class="arrows">
                        <i class="ti-angle-right"></i> <!-- This will change to ti-angle-down when active -->
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="sidebar-link <?php echo ($current_page == 'p2p_categories.php') ? 'active' : ''; ?>"
                            href="p2p_categories.php">Categories</a>
                    </li>
                    <li>
                        <a class="sidebar-link <?php echo ($current_page == 'p2p_questionaires.php') ? 'active' : ''; ?>"
                            href="p2p_questionaires.php">Questionnaires</a>
                    </li>
                </ul>
            </li>

            <hr>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'manage_user.php') ? 'active' : ''; ?>"
                    href="manage_user.php">
                    <span class="icon-holder">
                        <i class="c-yellow-500 ti-user"></i>
                    </span>
                    <span class="title">User Management</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'manage_student.php') ? 'active' : ''; ?>"
                    href="manage_student.php">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-user"></i>
                    </span>
                    <span class="title">Students</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'academic_year.php') ? 'active' : ''; ?>"
                    href="academic_year.php">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-pencil-alt"></i>
                    </span>
                    <span class="title">Academic Year</span>
                </a>
            </li>
        </ul>

    </div>
</div>

<script>
function toggleDropdown(element) {
    const arrowIcon = element.querySelector('.arrows i');
    if (arrowIcon.classList.contains('ti-angle-right')) {
        arrowIcon.classList.remove('ti-angle-right');
        arrowIcon.classList.add('ti-angle-down');
    } else {
        arrowIcon.classList.remove('ti-angle-down');
        arrowIcon.classList.add('ti-angle-right');
    }
}
</script>