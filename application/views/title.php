<p>
	What is the title of your item:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('title', $attributes);
?>

    <div class="control-group">
        <label for="title" class="control-label">Title:</label>
        <div class="controls">
            <input type="text" id="title" name="title" size="30"
                   value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['metadata-title'])) { echo $_SESSION['metadata-title']; } ?>" />
        </div>
    </div>

<div class="section">

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

</div>

<?php echo form_close(); ?>