<p>
	Please enter the URL of the service document for which the
    username password will be tested against.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-url" value="string" />
<input type="hidden" name="required-url" value="true" />
<input type="hidden" name="description-url" value="Service document URL" />

<div class="section">

    <div class="formtextnext">

        <label for="url">Service document URL:</label>
        <input type="text" id="url" name="url" size="60"
               value="<?php if (!empty($configoptions['url'])) { echo $configoptions['url']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>