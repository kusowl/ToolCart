<?php
session_start();
include "../config/site_config.php";
$pageTitle = "Dashboard of $siteName Admin";
include "../partials/header.php";
?>
  <div class="flex h-screen">
    <!-- Sidebar on the left -->
    <div class="w-64 bg-gray-800 text-white">
      <?php include 'admin_partials/sidebar.php'; ?>
    </div>

    <!-- Main content area (navbar + content) -->
    <div class="flex-1 flex flex-col">
      <!-- Navbar at the top -->
      <div class="bg-white shadow">
        <?php include 'admin_partials/navbar.php'; ?>
      </div>

      <!-- Page content (e.g. tables, dashboard content, etc.) -->
      <?=$output?>
    </div>
  </div>
  <script src="<?= $baseUrl ?>client/assets/js/popup.js"></script>
<?php
include "../partials/footer.php";
?>