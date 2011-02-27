<?php
    if (!empty($configwritewarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Unable to write to config file. Please ensure the web server can write to<br />
                <em>application/config/easydeposit.php</em> before proceeding.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Able to write to config file. The web server can write to<br />
                <em>application/config/easydeposit.php</em>
            </div>
        <?php
    }

    if (!empty($uploadwritewarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Unable to write to the file upload directory. Please ensure the web server can write to<br />
                <em><?php echo $uploadlocation; ?></em> before proceeding.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Able to write to the file upload directory. The web server can write to<br />
                <em><?php echo $uploadlocation; ?></em>
            </div>
        <?php
    }

    if (!empty($packagewritewarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Unable to write to the package creation directory. Please ensure the web server can write to<br />
                <em><?php echo $packagelocation; ?></em> before proceeding.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Able to write to the package creation directory. The web server can write to<br />
                <em><?php echo $packagelocation; ?></em>
            </div>
        <?php
    }

    if (!empty($defaultpasswordwarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                You are using the default EasyDeposit password. For security reasons you should change
                this using the menu option on the administrative home page.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                You are not using the default password.
            </div>
        <?php
    }

    if (!empty($curlfunctionwarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Your system does not have the PHP Curl functionality installed.
                Contact your system administrator about this. Without the PHP Curl
                functionality installed you will not be able to deposit SWORD packages.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Your system has the PHP Curl functionality installed.
            </div>
        <?php
    }

    if (!empty($sxmlfunctionwarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Your system does not have the PHP SimpleXML functionality installed.
                Contact your system administrator about this. Without the PHP SimpleXML
                functionality installed you will not be able to parse SWORD responses.
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Your system has the PHP SimpleXML functionality installed.
            </div>
        <?php
    }

    if (!empty($zipfunctionwarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Your system does not have the PHP Zip functionality installed.
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
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Your system has the PHP Zip functionality installed.
            </div>
        <?php
    }

    if (!empty($ldapfunctionwarning))
    {
        ?>
            <div class="error">
                <img src="<?php echo base_url(); ?>images/cross.png" />
                Your system does not have the PHP LDAP functionality installed.
                Contact your system administrator about this.<br />
                <strong>You only require the LDAP functionality if you are using the
                LDAP Login authentication step. If you are not using this authentication
                method, you can ignore this error.</strong>
            </div>
        <?php
    }
    else
    {
        ?>
            <div class="positive">
                <img src="<?php echo base_url(); ?>images/tick.png" />
                Your system has the PHP LDAP functionality installed.
            </div>
        <?php
    }
?>

<p>

    Go back to the <a href="./admin">administration home page</a>.

</p>