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
    else
    {
        ?>
            <div class="positive">
                OK: Able to write to config file. The web server can write to<br />
                <em>system/application/config/easydeposit.php</em>
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
    else
    {
        ?>
            <div class="positive">
                OK: Able to write to the package creation directory. The web server can write to<br />
                <em><?php echo $packagelocation; ?></em>
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
    else
    {
        ?>
            <div class="positive">
                OK: You are not using the default password.
            </div>
        <?php
    }

    if (!empty($zipfunctionwarning))
    {
        ?>
            <div class="error">
                WARNING: Your system does not have the PHP Zip functionality installed.
                Contact your system administrator about this. Without the PHP Zip
                functionality installed you will not be able to create SWORD deposit
                packages.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                OK: Your system has the PHP Zip functionality installed.
            </div>
        <?php
    }

    if (!empty($ldapfunctionwarning))
    {
        ?>
            <div class="error">
                WARNING: Your system does not have the PHP LDAP functionality installed.
                Contact your system administrator about this.<br />
                <strong>You only require the LDAP fnctionality if you are using the
                LDAP Login authentication step. If you are not using this authentication
                method, you can ignore this error.</strong>
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                OK: Your system has the PHP LDAP functionality installed.
            </div>
        <?php
    }
?>

<p>

    Go back to the <a href="./admin">administration home page</a>.

</p>