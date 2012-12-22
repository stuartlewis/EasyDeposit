<p>
	Please enter a DOI:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('crossrefdoilookup', $attributes);
?>

<?php if ($_SESSION['crossrefdoilookup_ok'] == false) { ?>

    <div class="control-group">
        <label for="doi" class="control-label">DOI:</label>
        <div class="controls">
            <input type="text" id="doi" name="doi" size="60"
                   value="<?php if (!empty($_SESSION['crossref-doi'])) { echo $_SESSION['crossref-doi']; } ?>" />
        </div>
    </div>

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

<?php } else { ?>

    <div class="control-group">
        <label for="doi" class="control-label">DOI:</label>
        <div class="controls">
            <input type="text" id="doi" name="doi" size="60"
                   value="<?php if (!empty($_SESSION['crossref-doi'])) { echo $_SESSION['crossref-doi']; } ?>" />
        </div>
    </div>

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

<?php } ?>

<?php echo form_close(); ?>