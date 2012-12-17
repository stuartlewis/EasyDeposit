<p>
	Please complete the following form to edit the location of the SWORD v2 PHP Library
    (you do not normally need to edit this setting):
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/v2librarylocation'); ?>

<div class="section">

    <div class="formtext">
        <label for="v2librarylocation" class="fixedwidthlabel">Library location:</label>
        <input type="text" id="v2librarylocation" name="v2librarylocation" size="60" value="<?php echo $v2librarylocation; ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>