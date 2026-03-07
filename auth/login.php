<?php include '../includes/header.php'; ?>

<div class="login-wrapper">
    <div class="login-card shadow p-4 rounded bg-white">
        <h2 class="mb-4 text-center">Welcome Back</h2>

        <form action="../actions/login_action.php" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control login-input" placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-semibold">Password</label>
                <input type="password" name="password" class="form-control login-input" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 login-btn fw-bold">Login</button>
        </form>
        <div class="text-center mt-3">
            <span class="text-muted">Don't have an account? <a href="register.php" class="text-decoration-none border-bottom border-primary">Sign up</a></span>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
