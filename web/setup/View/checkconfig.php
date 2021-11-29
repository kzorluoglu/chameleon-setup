<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php foreach ($configs as $configKey => $configValue): ?>
 <input type="text" name="<?php echo $configKey; ?>" value="<?php echo $configKey; ?>"><br>
    <?php foreach ($configValue as $valueKey => $value): ?>
        <input type="text" name="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][key]" value="<?php echo $valueKey; ?>">:
        <input type="text" name="<?php echo $configKey; ?>[<?php echo $valueKey; ?>][value]" value="<?php echo $value; ?>"><br>
    <?php endforeach; ?>
<?php endforeach; ?>
    <button type="submit">Save Config</button>
</form>


    <hr>

<a href="setup?page=databaseinstall">< Database Install</a> |
<?php if($checked): ?>
        <p>Config is valid ! </p>
<a href="setup?page=createadmin">Create now Admin Login</a>
<?php endif; ?>