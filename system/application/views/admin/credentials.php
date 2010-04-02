<p>
	Please complete the following form to edit the administrative username and password:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/credentials'); ?>

<div class="section">

    <div class="formtextnext">
        <label for="username" class="fixedwidthlabel">Username:</label>
        <input type="text" id="username" name="username" size="30" value="<?php echo $username; ?>" />
        <br />

        <label for="oldpassword" class="fixedwidthlabel">Old password:</label>
        <input type="password" id="oldpassword" name="oldpassword" size="30" />
        <br />

        <label for="newpassword" class="fixedwidthlabel">New password:</label>
        <input type="password" id="newpassword" name="newpassword" size="30" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>