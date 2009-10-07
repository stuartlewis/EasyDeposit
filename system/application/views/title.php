<p>
	What is the title of your item:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('metadata'); ?>

<div class="section">

    <div class="formtext">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" size="30"
               value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['metadata-title'])) { echo $_SESSION['metadata-title']; } ?>" />
    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>