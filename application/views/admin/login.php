<p>
	Please enter your EasyDeposit administrative username and password:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('adminlogin'); ?>

<div class="section">

    <div class="formtext">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" size="30" value="<?php echo set_value('username'); ?>" />
    </div>

    <div class="formtext">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" size="30" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>