<p>
	Please select which version of SWORD your repository uses:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/swordversion'); ?>

<div class="section">

    <div class="formtext">
        <label for="swordversion" class="fixedwidthlabel">SWORD Version:</label>
        <select name="swordversion" id="swordversion">
            <option value="1" <?php if ($swordversion == '1') echo 'selected=true'; ?>>SWORD v1</option>
            <option value="2" <?php if ($swordversion == '2') echo 'selected=true'; ?>>SWORD v2</option>
        </select>
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>