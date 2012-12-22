<p>
	Select a service document, or enter another URL:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('selectrepository', $attributes);
?>

    <div class="control-group">
        <label class="control-label" for="url">URL:</label>
        <div class="controls">
            <?php
                echo form_dropdown('url', $this->config->item('easydeposit_selectrepository_list'), set_value('url'), 'id="url"');
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="otherurl">Other:</label>
        <div class="controls">
            <input type="text" id="otherurl" name="otherurl" size="50" value="<?php echo set_value('otherurl'); ?>" />
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="username">Username:</label>
        <div class="controls">
            <input type="text" id="username" name="username" size="30" value="<?php echo set_value('username'); ?>" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="password">Password:</label>
        <div class="controls">
            <input type="password" id="password" name="password" size="30" value="<?php echo set_value('password'); ?>" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="obo">On behalf of:</label>
        <div class="controls">
            <input type="text" id="obo" name="obo" size="30" value="<?php echo set_value('obo'); ?>" />
        </div>
    </div>


    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />


<?php echo form_close(); ?>