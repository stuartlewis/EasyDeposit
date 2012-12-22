<p>
	Please login:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('servicedocumentlogin', $attributes);
?>

    <div class="control-group">
        <label for="username" class="control-label">Username:</label>
        <div class="controls">
            <input type="text" id="username" name="username" size="30" value="<?php echo set_value('username'); ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Password:</label>
        <div class="controls">
            <input type="password" id="password" name="password" size="30" value="<?php echo set_value('password'); ?>" />
        </div>
    </div>


<div class="section">

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

</div>

<?php echo form_close(); ?>