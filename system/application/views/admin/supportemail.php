<p>
	Please complete the following form to edit the support email address:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/supportemail'); ?>

<div class="section">

    <div class="formtext">
        <label for="supportemail" class="fixedwidthlabel">Support email address:</label>
        <input type="text" id="supportemail" name="supportemail" size="30" value="<?php echo $supportemail; ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>