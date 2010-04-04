<?php
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
    You can perform the following tasks from the administrative interface:

    <div class="section">
        <ul>
            <li><a href="./admin/steps">Edit the deposit steps</a></li>
            <li><a href="./admin/credentials">Change admin username or password</a></li>
            <li><a href="./admin/coresettings">Edit the core configuration settings</a></li>
            <li><a href="./admin/systemcheck">Perform a system check</a></li>
            <li>More to follow...</li>
        </ul>
    </div>

    Go back to the <a href="./">homepage</a> or
    <a href="./admin/logout">logout</a> of the administrative interface.

</p>