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
        </ul>
        <ul class="nav-right">
            <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="peer mR-10">
                        <i class="c-black-500 ti-user"></i>
                    </div>
                    <div class="peer">
                        <span class="fsz-sm c-grey-900"><?php echo $full; ?></span>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm" aria-labelledby="dropdownMenuLink">
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
