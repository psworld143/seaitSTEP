<style>
    /* Add a red badge to show unread notifications */
    .c-blue-500 .badge {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 0.6em;
        padding: 3px 7px;
    }
</style>

<?php
// Fetch unread notifications
$notification_query = mysqli_query($conn, "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC LIMIT 5");
$unread_count = mysqli_num_rows($notification_query);
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
            <!-- Notification Bell -->
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="peer mR-10">
                        <i class="c-blue-500 ti-bell"></i>
                        <?php if ($unread_count > 0): ?>
                            <span class="badge bg-danger"><?php echo $unread_count; ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm" aria-labelledby="notificationDropdown">
                    <?php if ($unread_count > 0): ?>
                        <?php while ($notification = mysqli_fetch_assoc($notification_query)): ?>
                            <li class="pX-20 pY-10">
                                <?php echo $notification['message']; ?>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="pX-20 pY-10">No new notifications</li>
                    <?php endif; ?>
                    <li class="divider"></li>
                    <li>
                        <a href="backend_scripts/mark_notifications.php" class="pX-20 pY-10 d-block">Mark all as read</a>
                    </li>
                </ul>
            </li>
            <!-- User Profile Dropdown -->
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