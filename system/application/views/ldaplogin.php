<p>
	Please enter your <?php echo $netidname; ?> and password:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('ldaplogin'); ?>

<div class="section">

    <div class="formtext">
        <label for="netid"><?php echo $netidname; ?>:</label>
        <input type="text" id="netid" name="netid" size="10" value="<?php echo set_value('netid'); ?>" />
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