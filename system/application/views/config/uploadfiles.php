<p>
	Please enter the location where files are stored when they are uploaded by the user.
    The web server needs to be able to read and write to the location.
</p>

<p>
    You can test if the web server is able to write to this location by visiting the
    <a href="admin/systemcheck">system check</a> page.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-savedir" value="string" />
<input type="hidden" name="required-savedir" value="true" />
<input type="hidden" name="description-savedir" value="Uploaded file save location" />

<input type="hidden" name="define-number" value="string" />
<input type="hidden" name="required-number" value="true" />
<input type="hidden" name="description-number" value="Max number of files allowed" />

<div class="section">

    <div class="formtextnext">

        <label for="savedir" class="fixedwidthlabel">Uploaded file save location:</label>
        <input type="text" id="savedir" name="savedir" size="60"
               value="<?php if (!empty($configoptions['savedir'])) { echo $configoptions['savedir']; } ?>" />
        <br />

        <label for="number" class="fixedwidthlabel">Max number of files allowed:</label>
        <select id = "number" name="number">
        <?php
            for ($i = 1; $i <= 10; $i++) {
                echo '<option value="' . $i . '"';
                if (!empty($configoptions['number']) && ($configoptions['number'] == $i)) { echo ' selected="selected"'; }
                echo '>' . $i . '</option>';
            }
        ?>
        </select>

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>