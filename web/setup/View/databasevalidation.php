 <?php echo $title; ?>

 <?php if($error !== ''): ?>
 Error: Please check your database connection Information<br>
 <p class="error">Detail: <?php echo $error; ?></p>
 <?php endif; ?>

 <?php if($connected === true): ?>
     Database connection successful!<br>
 <?php endif; ?>

 <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
     <input type="text" name="mysql_host" placeholder="host" autocomplete="mysql.host"><br>
     <input type="text" name="mysql_port" placeholder="port" autocomplete="mysql.port"><br>
     <input type="text" name="mysql_databaseName" placeholder="db name" autocomplete="mysql.databaseName"><br>
     <input type="text" name="mysql_username" placeholder="db username" autocomplete="mysql.username"><br>
     <input type="text" name="mysql_password" placeholder="db password"  autocomplete="mysql.password"><br>
     <button type="submit">Check</button>
 </form>

<a href="setup">< Installation</a>

<?php if($connected): ?>
<a href="setup?page=databaseinstall">Go to Database Install</a>
<?php endif; ?>