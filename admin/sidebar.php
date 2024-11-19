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

        <!-- ### $Sidebar Menu ### -->
        <ul class="sidebar-menu scrollable pos-r">
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            $department_pages = ['departments.php', 'view_instructors.php', 'subject_evaluations.php', 'profile.php', 'p2p_evaluation_result.php', 'add_employee.php', 'employees.php'];
            ?>
            <li class="nav-item">
                <a class="sidebar-link <?php echo in_array($current_page, $department_pages) ? 'actived' : ''; ?>"
                    href="departments.php">
                    <span class="icon-holder">
                        <i class="c-orange-500 ti-layout-list-thumb"></i>
                    </span>
                    <span class="title">Departments</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle <?php
                                            $student_pages = ['categories.php', 'questionaires.php'];
                                            echo (in_array(basename($_SERVER['PHP_SELF']), $student_pages)) ? 'active' : '';
                                            ?>" href="javascript:void(0);" onclick="toggleDropdown(this)">
                    <span class="icon-holder">
                        <i class="c-red-500 ti-bar-chart"></i>
                    </span>
                    <span class="title">Student Questionnaires</span>
                    <span class="arrows">
                        <i class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), $student_pages)) ? 'ti-angle-down' : 'ti-angle-right'; ?>"></i>
                    </span>
                </a>
                <ul class="dropdown-menu" <?php echo (in_array(basename($_SERVER['PHP_SELF']), $student_pages)) ? 'style="display: block;"' : ''; ?>>
                    <li>
                        <a class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'categories.php') ? 'active' : ''; ?>"
                            href="categories.php">Categories</a>
                    </li>
                    <li>
                        <a class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'questionaires.php') ? 'active' : ''; ?>"
                            href="questionaires.php">Questionnaires</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle <?php
                                            $peer_pages = ['p2p_categories.php', 'p2p_questionaires.php'];
                                            echo (in_array(basename($_SERVER['PHP_SELF']), $peer_pages)) ? 'active' : '';
                                            ?>" href="javascript:void(0);" onclick="toggleDropdown(this)">
                    <span class="icon-holder">
                        <i class="c-green-500 ti-pie-chart"></i>
                    </span>
                    <span class="title">Peer Questionnaires</span>
                    <span class="arrows">
                        <i class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), $peer_pages)) ? 'ti-angle-down' : 'ti-angle-right'; ?>"></i>
                    </span>
                </a>
                <ul class="dropdown-menu" <?php echo (in_array(basename($_SERVER['PHP_SELF']), $peer_pages)) ? 'style="display: block;"' : ''; ?>>
                    <li>
                        <a class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'p2p_categories.php') ? 'active' : ''; ?>"
                            href="p2p_categories.php">Categories</a>
                    </li>
                    <li>
                        <a class="sidebar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'p2p_questionaires.php') ? 'active' : ''; ?>"
                            href="p2p_questionaires.php">Questionnaires</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'manage_user.php') ? 'actived' : ''; ?>"
                    href="manage_user.php">
                    <span class="icon-holder">
                        <i class="c-yellow-500 ti-user"></i>
                    </span>
                    <span class="title">User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'manage_student.php') ? 'actived' : ''; ?>"
                    href="manage_student.php">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-user"></i>
                    </span>
                    <span class="title">Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="sidebar-link <?php echo ($current_page == 'academic_year.php') ? 'actived' : ''; ?>"
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
        // Toggle the dropdown menu visibility
        const dropdownMenu = element.nextElementSibling;
        const arrowIcon = element.querySelector('.arrows i');
        const isOpen = dropdownMenu.style.display === 'block';

        // Close all other dropdowns first
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdownMenu) {
                menu.style.display = 'none';
                const icon = menu.previousElementSibling.querySelector('.arrows i');
                icon.classList.remove('ti-angle-down');
                icon.classList.add('ti-angle-right');
            }
        });

        // Toggle current dropdown
        dropdownMenu.style.display = isOpen ? 'none' : 'block';

        // Toggle arrow icon
        if (isOpen) {
            arrowIcon.classList.remove('ti-angle-down');
            arrowIcon.classList.add('ti-angle-right');
        } else {
            arrowIcon.classList.remove('ti-angle-right');
            arrowIcon.classList.add('ti-angle-down');
        }
    }

    // Ensure dropdowns are properly initialized on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();

        // Auto-expand dropdown if current page is in it
        document.querySelectorAll('.nav-item.dropdown').forEach(dropdown => {
            const dropdownLinks = dropdown.querySelectorAll('.dropdown-menu a');
            dropdownLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.style.display = 'block';
                        const arrowIcon = dropdown.querySelector('.arrows i');
                        arrowIcon.classList.remove('ti-angle-right');
                        arrowIcon.classList.add('ti-angle-down');
                    }
                }
            });
        });
    });
</script>