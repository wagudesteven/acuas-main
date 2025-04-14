
<header class="d-flex justify-content-between align-items-center py-3 px-4 bg-primary text-white">
    <h1>Kwa Vonza Water Supply - Admin Panel</h1>
    <div class="d-flex align-items-center">
    <span id="admin-name" class="me-3"></span>
    <button id="logout-btn" class="btn btn-danger btn-sm">Logout</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logout-btn');

    logoutBtn.addEventListener('click', function() {
        // Perform logout actions here

        // Ask for confirmation
        if (confirm("Are you sure you want to logout?")) {
            // Redirect to admin.php if confirmed
            window.location.href = 'login.php';
        } else {
            // Do nothing if cancelled.
        }
    });
});
</script>
</header>