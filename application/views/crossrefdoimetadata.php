<p>
	Please check the item description and edit if incorrect:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('crossrefdoimetadata', $attributes);
?>

    <div class="control-group">
        <label for="title" class="control-label">Title:</label>
        <div class="controls">
            <input type="text" id="title" name="title" size="80"
                   value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['crossrefdoi-title'])) { echo $_SESSION['crossrefdoi-title']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="journaltitle" class="control-label">Journal title:</label>
        <div class="controls">
            <input type="text" id="journaltitle" name="journaltitle" size="60"
                   value="<?php echo set_value('journaltitle'); ?><?php if (!empty($_SESSION['crossrefdoi-journaltitle'])) { echo $_SESSION['crossrefdoi-journaltitle']; } ?>" />
        </div>
    </div>


    <?php for ($authorpointer = 1; $authorpointer <= $_SESSION['crossrefdoi-authorcount']; $authorpointer++) { ?>
        <div class="control-group">
            <label for="author1" class="control-label">Author <?php echo $authorpointer; ?>:</label>
            <div class="controls">
                <input type="text" id="author1" name="author<?php echo $authorpointer; ?>" size="40"
                       value="<?php echo set_value('author<?php echo $authorpointer; ?>'); ?><?php if (!empty($_SESSION['crossrefdoi-author' . $authorpointer])) { echo $_SESSION['crossrefdoi-author' . $authorpointer]; } ?>" />
            </div>
        </div>
    <?php } ?>

    <div class="control-group">
        <label for="year" class="control-label">Year:</label>
        <div class="controls">
            <input type="text" id="year" name="year" size="10"
                   value="<?php echo set_value('year'); ?><?php if (!empty($_SESSION['crossrefdoi-year'])) { echo $_SESSION['crossrefdoi-year']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="volume" class="control-label">Volume:</label>
        <div class="controls">
            <input type="text" id="volume" name="volume" size="10"
                   value="<?php echo set_value('volume'); ?><?php if (!empty($_SESSION['crossrefdoi-volume'])) { echo $_SESSION['crossrefdoi-volume']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="issue" class="control-label">Issue:</label>
        <div class="controls">
            <input type="text" id="issue" name="issue" size="10"
                   value="<?php echo set_value('issue'); ?><?php if (!empty($_SESSION['crossrefdoi-issue'])) { echo $_SESSION['crossrefdoi-issue']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="type" class="control-label">Type of item:</label>
        <div class="controls">
            <?php
                echo form_dropdown('type', $this->config->item('easydeposit_metadata_itemtypes'), set_value('type'), 'id="type"');
            ?>
        </div>
    </div>

    <div class="control-group">
        <label for="peerreviewed" class="control-label">Has the item been peer reviewed?:</label>
        <div class="controls">
            <?php
                echo form_dropdown('peerreviewed', $this->config->item('easydeposit_metadata_peerreviewstatus'), set_value('peerreviewed'), 'id="peerreviewed"');
            ?>
        </div>
    </div>

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

<?php echo form_close(); ?>