<p>
	Please describe your item:
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('metadata', $attributes);
?>

    <div class="control-group">
        <label for="title" class="control-label">Title:</label>
        <div class="controls">
            <input type="text" id="title" name="title" size="60"
                   value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['metadata-title'])) { echo $_SESSION['metadata-title']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="author1" class="control-label">Author 1:</label>
        <div class="controls">
            <input type="text" id="author1" name="author1" size="40"
                   value="<?php echo set_value('author1'); ?><?php if (!empty($_SESSION['metadata-author1'])) { echo $_SESSION['metadata-author1']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="author2" class="control-label">Author 2 <em>(optional)</em>:</label>
        <div class="controls">
            <input type="text" id="author2" name="author2" size="40"
                   value="<?php echo set_value('author2'); ?><?php if (!empty($_SESSION['metadata-author2'])) { echo $_SESSION['metadata-author2']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="author3" class="control-label">Author 3 <em>(optional)</em>:</label>
        <div class="controls">
            <input type="text" id="author3" name="author3" size="40"
                   value="<?php echo set_value('author3'); ?><?php if (!empty($_SESSION['metadata-author3'])) { echo $_SESSION['metadata-author3']; } ?>" />
        </div>
    </div>

    <div class="control-group">
        <label for="abstract" class="control-label">Abstract <em>(optional)</em>:</label>
        <div class="controls">
            <textarea id="abstract" name="abstract" rows="6" cols="50"
            ><?php echo set_value('abstract'); ?><?php if (!empty($_SESSION['metadata-abstract'])) { echo $_SESSION['metadata-abstract']; } ?></textarea>
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

    <div class="control-group">
        <label for="citation" class="control-label">Bibliographic citation <em>(optional)</em>:</label>
        <div class="controls">
            <textarea id="citation" name="citation" rows="3" cols="50"
            ><?php echo set_value('citation'); ?><?php if (!empty($_SESSION['metadata-citation'])) { echo $_SESSION['metadata-citation']; } ?></textarea>
        </div>
    </div>

    <div class="control-group">
        <label for="link" class="control-label">Existing URL for item <em>(optional)</em>:</label>
        <div class="controls">
            <input type="text" id="link" name="link" size="40"
                   value="<?php echo set_value('link'); ?><?php if (!empty($_SESSION['metadata-link'])) { echo $_SESSION['metadata-link']; } ?>" />
        </div>
    </div>

    <input type="Submit" name="submit" id="submit" class="btn-primary value="Next &gt;" />

<?php echo form_close(); ?>