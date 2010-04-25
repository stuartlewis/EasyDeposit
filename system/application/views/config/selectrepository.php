<p>
	Please enter a list of service documents for the user to choose from, one per line:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-list" value="array" />
<input type="hidden" name="description-list" value="List of service document URLs" />

<div class="section">

    <div class="formtextnext">

        <label for="list">List of service document URLs:</label>
        <textarea id="list" name="list" cols="100" rows="8"><?php if (!empty($configoptions['list'])) {
            foreach ($configoptions['list'] as $url) { echo $url . "\n"; } } ?></textarea>

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>