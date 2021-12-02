



 <?php include "layout/header.php"; ?>
 <div class="card border-0">
     <div class="card-body p-0">
         <div class="row no-gutters">
             <div class="col-lg-12">
                 <div class="p-5">
                     <div class="mb-5">
                         <span class="badge bg-secondary">Step 4</span>
                         <h3 class="h4 font-weight-bold text-theme">Database Validation</h3>
                     </div>

                     <?php if($error !== ''): ?>
                         <div class="alert alert-danger" role="alert">
                             Error: Please check your database connection Information<br>
                             <p class="error">Detail: <?php echo $error; ?></p>
                         </div>

                     <?php endif; ?>

                     <?php if($connected === true): ?>
                         <div class="alert alert-success" role="alert">
                             Database connection successful!
                         </div>
                     <?php endif; ?>

                     <?php if($connected === false): ?>
                     <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                         <div class="row mb-3">
                             <label for="mysql_host" class="col-sm-2 col-form-label">Database Hostname</label>
                             <div class="col-sm-10">
                                 <input type="text" name="mysql_host" class="form-control" id="mysql_host" autocomplete="mysql.host">
                             </div>
                         </div>
                         <div class="row mb-3">
                             <label for="mysql_port" class="col-sm-2 col-form-label">Database Port</label>
                             <div class="col-sm-10">
                                 <input type="text" name="mysql_port" class="form-control" id="mysql_port" autocomplete="mysql_port">
                             </div>
                         </div>
                         <div class="row mb-3">
                             <label for="mysql_database_name" class="col-sm-2 col-form-label">Database Name</label>
                             <div class="col-sm-10">
                                 <input type="text" name="mysql_database_name" class="form-control" id="mysql_database_name" autocomplete="mysql_database_name">
                             </div>
                         </div>
                         <div class="row mb-3">
                             <label for="mysql_username" class="col-sm-2 col-form-label">Database Username</label>
                             <div class="col-sm-10">
                                 <input type="text" name="mysql_username" class="form-control" id="mysql_username" autocomplete="mysql_username">
                             </div>
                         </div>
                         <div class="row mb-3">
                             <label for="mysql_password" class="col-sm-2 col-form-label">Database Password</label>
                             <div class="col-sm-10">
                                 <input type="text" name="mysql_password" class="form-control" id="mysql_password" autocomplete="mysql_password">
                             </div>
                         </div>
                         <button class="btn btn-primary" type="submit">Validate</button>
                     </form>
                     <?php endif; ?>

                     <div class="mt-5">

                         <a class="btn btn-outline-info" href="setup?page=install">
                             <i class="bi bi-arrow-left-square"></i>
                             Install
                         </a>
                         <?php if($connected === true): ?>
                             <a class="btn btn-primary" href="setup?page=databaseinstall">
                             <i class="bi bi-arrow-right-square"></i>
                             Database Installation
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