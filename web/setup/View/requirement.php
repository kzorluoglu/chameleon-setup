composer install<br>
<?php echo $title; ?>

<h3>PHP Requirement</h3>

    Installed Version: <?php echo $phpVersionRequirements['installed_version']; ?><br>
    Required Version: <?php echo $phpVersionRequirements['required']; ?><br>
    <?php if($phpVersionRequirements['passed']): ?>
        <span style="color:green;">Passed</span>
    <?php else: ?>
        <span style="color:red;">Failed</span>
<?php endif; ?>
<hr>
<h3>PHP Extension Requirements</h3>
<?php foreach ($system_requirements as $requirement): ?>
Extension <?php echo $requirement['name']; ?>, <?php if($requirement['passed']): ?> <span style="color:green;">Passed</span><?php else: ?><span style="color:red;">not installed</span><?php endif; ?><br>
<?php endforeach; ?>
<hr>

<?php if($installable): ?>
<a href="setup?page=install">Go to Install</a>
<?php endif; ?>