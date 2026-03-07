<?php include '../includes/header.php'; ?>

<div class="register-wrapper">
    <div class="register-card shadow p-4 rounded bg-white">
        <h2 class="mb-4 text-center">Register</h2>

        <form action="../actions/register_action.php" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted fw-semibold">Name</label>
                <input type="text" name="name" class="form-control register-input" placeholder="Enter your name" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control register-input" placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-semibold">Password</label>
                <input type="password" name="password" class="form-control register-input" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 register-btn fw-bold">Register</button>
        </form>
        <div class="text-center mt-3">
            <span class="text-muted">Already have an account? <a href="login.php" class="text-decoration-none border-bottom border-primary">Login</a></span>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
