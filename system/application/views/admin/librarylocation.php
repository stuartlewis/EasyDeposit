<p>
	Please complete the following form to edit the location of the SWORDAPP PHP Library
    (you do not normally need to edit this setting):
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/librarylocation'); ?>

<div class="section">

    <div class="formtext">
        <label for="librarylocation" class="fixedwidthlabel">Library location:</label>
        <input type="text" id="librarylocation" name="librarylocation" size="60" value="<?php echo $librarylocation; ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>