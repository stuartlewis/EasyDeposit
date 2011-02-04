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
            <li>Edit the <a href="./admin/steps">deposit steps</a></li>
            <li>Edit the <a href="./admin/editwelcome">welcome screen content</a>,
                         <a href="./admin/editheader">header</a>,
                         <a href="./admin/editfooter">footer</a> or
                         <a href="./admin/editcss">CSS</a></li>
            <li>Change the <a href="./admin/credentials">admin username or password</a></li>
            <li>Edit the <a href="./admin/coresettings">core configuration settings</a></li>
            <li><a href="./admin/systemcheck">Perform a system check</a></li>
        </ul>
    </div>

    Go back to the <a href="./">homepage</a> or
    <a href="./admin/logout">logout</a> of the administrative interface.

</p>