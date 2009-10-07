<p>
	Select a service document, or enter another URL:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('selectrepository'); ?>

<div class="section">

    <div class="formtext">
        <label for="url">URL:</label><br />
        <?php
            echo form_dropdown('url', $this->config->item('easydeposit_selectrepository_list'), set_value('url'), 'id="url"');
        ?>
    </div>

    <div class="formtext">
        <label for="otherurl">Other:</label><br />
        <input type="text" id="otherurl" name="otherurl" size="50" value="<?php echo set_value('otherurl'); ?>" />
    </div>

</div>

<div class="section">

    <div class="formtext">
        <label for="username">Username:</label><br />
        <input type="text" id="username" name="username" size="30" value="<?php echo set_value('username'); ?>" />
    </div>

    <div class="formtext">
        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="30" value="<?php echo set_value('password'); ?>" />
    </div>

    <div class="formtext">
        <label for="obo">On behalf of:</label><br />
        <input type="text" id="obo" name="obo" size="30" value="<?php echo set_value('obo'); ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>