<p>
	Please describe your item:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('metadata'); ?>

<div class="section">

    <div class="formtextnext">
        <label for="title" class="fixedwidthlabel">Title:</label>
        <input type="text" id="title" name="title" size="60"
               value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['metadata-title'])) { echo $_SESSION['metadata-title']; } ?>" />
    </div>

</div>

<div class="section">

    <div class="formtextnext">

        <label for="author1" class="fixedwidthlabel">Author 1:</label>
        <input type="text" id="author1" name="author1" size="40"
               value="<?php echo set_value('author1'); ?><?php if (!empty($_SESSION['metadata-author1'])) { echo $_SESSION['metadata-author1']; } ?>" />
        <br />

        <label for="author2" class="fixedwidthlabel">Author 2 <em>(optional)</em>:</label>
        <input type="text" id="author2" name="author2" size="40"
               value="<?php echo set_value('author2'); ?><?php if (!empty($_SESSION['metadata-author2'])) { echo $_SESSION['metadata-author2']; } ?>" />
        <br />

        <label for="author3" class="fixedwidthlabel">Author 3 <em>(optional)</em>:</label>
        <input type="text" id="author3" name="author3" size="40"
               value="<?php echo set_value('author3'); ?><?php if (!empty($_SESSION['metadata-author3'])) { echo $_SESSION['metadata-author3']; } ?>" />
    </div>

</div>

<div class="section">

    <div class="formtextnext">
        <label for="abstract" class="fixedwidthlabel">Abstract <em>(optional)</em>:</label>
        <textarea id="abstract" name="abstract" rows="6" cols="50"
        ><?php echo set_value('abstract'); ?><?php if (!empty($_SESSION['metadata-abstract'])) { echo $_SESSION['metadata-abstract']; } ?></textarea>
    </div>

</div>

<div class="section">

    <div class="formtextnext">

        <label for="type" class="fixedwidthlabel">Type of item:</label>
        <?php
            echo form_dropdown('type', $this->config->item('easydeposit_metadata_itemtypes'), set_value('type'), 'id="type"');
        ?>
        <br />

        <label for="peerreviewed" class="fixedwidthlabel">Has the item been peer reviewed?:</label>
        <?php
            echo form_dropdown('peerreviewed', $this->config->item('easydeposit_metadata_peerreviewstatus'), set_value('peerreviewed'), 'id="peerreviewed"');
        ?>
        <br />

        <label for="citation" class="fixedwidthlabel">Bibliographic citation <em>(optional)</em>:</label>
        <textarea id="citation" name="citation" rows="3" cols="50"
        ><?php echo set_value('citation'); ?><?php if (!empty($_SESSION['metadata-citation'])) { echo $_SESSION['metadata-citation']; } ?></textarea>
        <br />

        <label for="link" class="fixedwidthlabel">Existing URL for item <em>(optional)</em>:</label>
        <input type="text" id="link" name="link" size="40"
               value="<?php echo set_value('link'); ?><?php if (!empty($_SESSION['metadata-link'])) { echo $_SESSION['metadata-link']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>