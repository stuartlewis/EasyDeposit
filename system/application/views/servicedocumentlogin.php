<p>
	Please login:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('servicedocumentlogin'); ?>

<div class="section">

    <div class="formtext">
        <label for="username">Username:</label><br />
        <input type="text" id="username" name="username" size="30" value="<?php echo set_value('username'); ?>" />
    </div>

    <div class="formtext">
        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="30" value="<?php echo set_value('password'); ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>