Last Step:<br>

 <?php if($error !== ''): ?>
 Error: Please check the error information<br>
 <p class="error">Detail: <?php echo $error; ?></p>
 <?php endif; ?>

 <?php if($created === true): ?>
     Admin User created<br>
 <?php endif; ?>

 <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
     <input type="text" name="admin_username" placeholder="admin username" autocomplete="admin.username"><br>
     <input type="text" name="admin_email" placeholder="admin email"  autocomplete="admin.email"><br>
     <input type="text" name="admin_password" placeholder="admin password"  autocomplete="admin.password"><br>
     <button type="submit">Create</button>
 </form>

 <a href="setup?page=checkconfig">< Modify/Check Config</a>


 <?php if($created): ?>
<a href="<?php echo $_SERVER['HTTP_ORIGIN']; ?>">Enjoy</a>
<?php endif; ?>