<p>
	Please enter a DOI:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('crossrefdoilookup'); ?>

<?php if ($_SESSION['crossrefdoilookup_ok'] == false) { ?>
<div class="section">

    <div class="formtextnext">
        <label for="doi">DOI:</label>
        <input type="text" id="doi" name="doi" size="60"
               value="<?php if (!empty($_SESSION['crossref-doi'])) { echo $_SESSION['crossref-doi']; } ?>" />
    </div>

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>
<?php } else { ?>
    <div class="section">

    <div class="formtextnext">
        <label for="doi">DOI:</label>
        <input type="text" id="doi" name="doi" size="60"
               value="<?php if (!empty($_SESSION['crossref-doi'])) { echo $_SESSION['crossref-doi']; } ?>" />
    </div>

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>
<?php } ?>

<?php echo form_close(); ?>