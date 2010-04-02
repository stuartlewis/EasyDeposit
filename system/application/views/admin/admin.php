<?php
    if (!empty($configwritewarning))
    {
        ?>
            <div class="error">
                WARNING: Unable to write to config file. Please ensure the web server can write to<br />
                <em>system/application/config/easydeposit.php</em> before proceeding.
            </div>
        <?php
    }

    if (!empty($packagewritewarning))
    {
        ?>
            <div class="error">
                WARNING: Unable to write to the package creation directory. Please ensure the web server can write to<br />
                <em><?php echo $packagelocation; ?></em> before proceeding.
            </div>
        <?php
    }

    if (!empty($defaultpasswordwarning))
    {
        ?>
            <div class="error">
                WARNING: You are using the default EasyDeposit password. For
                security reasons should change this using the menu option below.
            </div>
        <?php
    }
?>

<p>
<?php if (empty($configwritewarning)) { ?>
    You can perform the following tasks from the administrative interface:

    <div class="section">
        <ul>
            <li><a href="./admin/credentials">Change admin username or password</a></li>
            <li><a href="./admin/coresettings">Edit the core configuration settings</a></li>
            <li>More to follow...</li>
        </ul>
    </div>
<?php } ?>

    Go back to the <a href="./">homepage</a> or
    <a href="./admin/logout">logout</a> of the administrative interface.

</p>