<p>
	Select which files to upload:
</p>

<?php if (!empty($error)): ?>
    <div class="alert"><?php echo $error;?></div>
<?php endif; ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open_multipart('uploadfiles', $attributes);
?>

<div class="formtext">
    <?php for ($i = 1; $i <= $count; $i++): ?>
        <label for="file<?php echo $i; ?>">Select file <?php echo $i; ?>:</label>
        <input type="file" name="file<?php echo $i; ?>" id="file<?php echo $i; ?>" class="btn btn-success" size="20" /><br />
    <?php endfor; ?>
</div>

<div class="section">

    Please note: it may take a minute or two for the files to upload. Do not press the button more than once.<br />

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

</div>

<?php echo form_close(); ?>