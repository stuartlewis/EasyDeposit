<p>
	Please enter the location where files are stored once they are uploaded by the user
    and the packages are made, before the are deposited using SWORD. The web server needs
    to be able to read and write to the location.
</p>

<p>
    You can test if the web server is able to write to this location by visiting the
    <a href="admin/systemcheck">system check</a> page.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-packages" value="string" />
<input type="hidden" name="required-packages" value="true" />
<input type="hidden" name="description-packages" value="Package save location" />

<div class="section">

    <div class="formtextnext">

        <label for="packages">Package save location:</label>
        <input type="text" id="packages" name="packages" size="60"
               value="<?php if (!empty($configoptions['packages'])) { echo $configoptions['packages']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>