<p>
	Select which files to upload:
</p>

<?php if (!empty($error)): ?>
    <div class="error"><?php echo $error;?></div>
<?php endif; ?>

<?php echo  form_open_multipart('uploadfiles'); ?>

<div class="section">

    <div class="formtext">
        <?php for ($i = 1; $i <= $count; $i++): ?>
            <label for="file<?php echo $i; ?>">Select file <?php echo $i; ?>:</label>
            <input type="file" name="file<?php echo $i; ?>" id="file<?php echo $i; ?>" size="20" /><br />
        <?php endfor; ?>
    </div>

</div>

<div class="section">

    Please note: it may take a minute or two for the files to upload. Do not press the button more than once.<br />

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>