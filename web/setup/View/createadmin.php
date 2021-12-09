<?php include "layout/header.php"; ?>
<div class="card border-0">
    <div class="card-body p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="mb-5">
                        <span class="badge bg-secondary">Step 7</span>
                        <h3 class="h4 font-weight-bold text-theme">Create Admin User</h3>
                    </div>

                    <?php if($error !== ''): ?>
                        <div class="alert alert-danger" role="alert">
                            <b>Error:</b> <?php echo $error; ?>
                        </div>

                    <?php endif; ?>

                    <?php if($created === true): ?>
                        <div class="alert alert-success" role="alert">
                            Admin created successfully.
                        </div>
                    <?php endif; ?>

                    <?php if($created === false): ?>
                        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="row mb-3">
                                <label for="admin_username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="admin_username" class="form-control" id="admin_username" autocomplete="admin_username">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="admin_email" class="col-sm-2 col-form-label">E-Mail Address</label>
                                <div class="col-sm-10">
                                    <input type="email" name="admin_email" class="form-control" id="admin_email" autocomplete="admin_email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="admin_password" class="col-sm-2 col-form-label">Admin Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="admin_password" class="form-control" id="admin_password" autocomplete="admin_password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="admin_password_again" class="col-sm-2 col-form-label">Password again</label>
                                <div class="col-sm-10">
                                    <input type="password" name="admin_password_again" class="form-control" id="admin_password_again" autocomplete="admin_password_again">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Create Admin User</button>
                        </form>
                    <?php endif; ?>

                    <div class="mt-5">

                        <a class="btn btn-outline-info" href="index.php?page=install">
                            <i class="bi bi-arrow-left-square"></i>
                            Install
                        </a>
                        <?php if($created === true): ?>
                            <a class="btn btn-primary" href="<?php echo $_SERVER['HTTP_ORIGIN']; ?>">
                                <i class="bi bi-arrow-right-square"></i>
                                Go to Your Chameleon Shop
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end card-body -->
</div>
<!-- end card -->

<?php include "layout/footer.php"; ?>
