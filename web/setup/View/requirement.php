<?php include "layout/header.php"; ?>
    <div class="card border-0">
        <div class="card-body p-0">
            <div class="row no-gutters">
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="mb-5">
                            <span class="badge bg-secondary">Step 2</span>
                            <h3 class="h4 font-weight-bold text-theme">System Requirements</h3>
                        </div>
                        <p>Requirements List</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Installed PHP Version: <?php echo $phpVersionRequirements['installed_version']; ?>">
                                Required PHP Version: <?php echo $phpVersionRequirements['required']; ?>

                                <?php if ($phpVersionRequirements['passed']): ?>
                                    <span class="badge bg-primary rounded-pill"><i class="bi bi-check-all"></i></span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-exclamation-diamond"></i></span>
                                <?php endif; ?>
                            </li>

                            <?php foreach ($system_requirements as $requirement): ?>

                                <li class="list-group-item d-flex justify-content-between align-items-center"">
                                PHP Extension: <?php echo $requirement['name']; ?>
                                <?php if ($requirement['passed']): ?>
                                    <span class="badge bg-primary rounded-pill"><i class="bi bi-check-all"></i></span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-exclamation-diamond"></i></span>
                                <?php endif; ?>
                                </li>
                            <?php endforeach; ?>


                        </ul>
                        <?php if ($installable): ?>
                            <p class="text-success mt-2 mb-5">Congratulations! Everything looks good, you can now
                                install the software. </p>
                        <?php else: ?>
                            <p class="text-danger mt-2 mb-5">Ups, the system requirements are not met, please try again
                                after completing the required items from the list.</p>
                        <?php endif; ?>

                        <a class="btn btn-outline-info" href="index.php?page=install">
                            <i class="bi bi-arrow-left-square"></i>
                            Home</a>
                        <?php if ($installable): ?>
                            <a class="btn btn-primary" href="index.php?page=install">
                                <i class="bi bi-arrow-right-square"></i>
                                Install</a>
                        <?php endif; ?>


                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-inline-block">
                    <div class="account-block rounded-right">
                        <div class="overlay rounded-right"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card-body -->
    </div>
    <!-- end card -->

<?php include "layout/footer.php"; ?>
