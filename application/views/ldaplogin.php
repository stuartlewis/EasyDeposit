<p>
	Please enter your <?php echo $netidname; ?> and password:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('ldaplogin', $attributes);
?>

<div class="control-group">
    <label for="netid" class="control-label"><?php echo $netidname; ?>:</label>
    <div class="controls">
        <input type="text" id="netid" name="netid" size="10" value="<?php echo set_value('netid'); ?>" />
    </div>
</div>

<div class="control-group">
    <label for="password" class="control-label">Password:</label>
    <div class="controls">
        <input type="password" id="password" name="password" size="30" />
    </div>
</div>

<input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

<?php echo form_close(); ?>