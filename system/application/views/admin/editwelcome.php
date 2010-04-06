<p>
	Use the HTML editor to edit the welcome screen:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editwelcome'); ?>

<?php if (empty($canwrite)) { ?>
    <div class="error">
        WARNING: Unable to write to file. Please ensure the web server can write to<br />
        <em>system/application/views/welcome_message.php</em> before proceeding.
    </div>
<?php } ?>

<div class="section">

    <textarea id="content" name="content" rows="20" cols="100"><?php echo $html; ?></textarea><br />   
    <a href="javascript:toggleEditor('content');">Add/Remove editor</a>
</div>

<div class="section">

    <?php if (!empty($canwrite)) { ?>
        <input type="Submit" name="submit" id="submit" value="Update" />
        <input type="Submit" name="revert" id="revert" value="Revert to original" />
    <?php } ?>
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>