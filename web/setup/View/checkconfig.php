



<?php include "layout/header.php"; ?>
<div class="card border-0">
    <div class="card-body p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="mb-5">
                        <span class="badge bg-secondary">Step 6</span>
                        <h3 class="h4 font-weight-bold text-theme">Configuration Validation</h3>
                    </div>

                    <?php if($checked === true): ?>
                        <div class="alert alert-success" role="alert">
                            Configuration check is successful.
                        </div>
                    <?php endif; ?>

                    <?php if($checked === false): ?>
                        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

                            <?php foreach ($configs as $configKey => $configValue): ?>

                                <div class="row mb-6">
                                     <div class="col-sm-6">
                                        <input type="text"
                                               name="<?php echo $configKey; ?>"
                                               value="<?php echo $configKey; ?>"
                                               <?php if($configKey === "parameters"): ?>
                                               readonly class="form-control"
                                               <?php else: ?>
                                               class="form-control"
                                               <?php endif; ?>
                                               id="<?php echo $configKey; ?>"
                                               autocomplete="<?php echo $configKey; ?>">

                                <?php foreach ($configValue as $valueKey => $value): ?>
                                <div class="row mb-8">
                                    <div class="offset-md-2 col-sm-5">
                                        <input type="text"
                                               name="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][key]"
                                               value="<?php echo $valueKey; ?>"
                                               class="form-control" id="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][key]"
                                               autocomplete="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][key]">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text"
                                               name="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][value]"
                                               value="<?php echo $value; ?>"
                                               class="form-control" id="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][value]"
                                               autocomplete="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][value]">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                     </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="row mb-8">
                                <div class="col-sm-12">
                            <button class="btn btn-primary" type="submit">Check</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>

                    <div class="mt-5">

                        <a class="btn btn-outline-info" href="setup?page=databaseinstall">
                            <i class="bi bi-arrow-left-square"></i>
                            Database Installation
                        </a>
                        <?php if($checked === true): ?>
                            <a class="btn btn-primary" href="setup?page=createadmin">
                                <i class="bi bi-arrow-right-square"></i>
                                Create Admin User
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

