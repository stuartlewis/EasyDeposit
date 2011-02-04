<p>
	Please check the item description and edit if incorrect:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('crossrefdoimetadata'); ?>

<div class="section">

    <div class="formtextnext">
        <label for="title" class="fixedwidthlabel">Title:</label>
        <input type="text" id="title" name="title" size="80"
               value="<?php echo set_value('title'); ?><?php if (!empty($_SESSION['crossrefdoi-title'])) { echo $_SESSION['crossrefdoi-title']; } ?>" />
        <br />

        <label for="journaltitle" class="fixedwidthlabel">Journal title:</label>
        <input type="text" id="journaltitle" name="journaltitle" size="60"
               value="<?php echo set_value('journaltitle'); ?><?php if (!empty($_SESSION['crossrefdoi-journaltitle'])) { echo $_SESSION['crossrefdoi-journaltitle']; } ?>" />
    </div>

</div>

<div class="section">

    <div class="formtextnext">

        <?php for ($authorpointer = 1; $authorpointer <= $_SESSION['crossrefdoi-authorcount']; $authorpointer++) { ?>
            <label for="author1" class="fixedwidthlabel">Author <?php echo $authorpointer; ?>:</label>
            <input type="text" id="author1" name="author<?php echo $authorpointer; ?>" size="40"
                   value="<?php echo set_value('author<?php echo $authorpointer; ?>'); ?><?php if (!empty($_SESSION['crossrefdoi-author' . $authorpointer])) { echo $_SESSION['crossrefdoi-author' . $authorpointer]; } ?>" />
            <br />
        <?php } ?>

    </div>

</div>

<div class="section">

    <div class="formtextnext">
        <label for="year" class="fixedwidthlabel">Year:</label>
        <input type="text" id="year" name="year" size="10"
               value="<?php echo set_value('year'); ?><?php if (!empty($_SESSION['crossrefdoi-year'])) { echo $_SESSION['crossrefdoi-year']; } ?>" />
        <br />

        <label for="volume" class="fixedwidthlabel">Volume:</label>
        <input type="text" id="volume" name="volume" size="10"
               value="<?php echo set_value('volume'); ?><?php if (!empty($_SESSION['crossrefdoi-volume'])) { echo $_SESSION['crossrefdoi-volume']; } ?>" />
        <br />

        <label for="issue" class="fixedwidthlabel">Issue:</label>
        <input type="text" id="issue" name="issue" size="10"
               value="<?php echo set_value('issue'); ?><?php if (!empty($_SESSION['crossrefdoi-issue'])) { echo $_SESSION['crossrefdoi-issue']; } ?>" />
        <br />

        <label for="type" class="fixedwidthlabel">Type of item:</label>
        <?php
            echo form_dropdown('type', $this->config->item('easydeposit_metadata_itemtypes'), set_value('type'), 'id="type"');
        ?>
        <br />

        <label for="peerreviewed" class="fixedwidthlabel">Has the item been peer reviewed?:</label>
        <?php
            echo form_dropdown('peerreviewed', $this->config->item('easydeposit_metadata_peerreviewstatus'), set_value('peerreviewed'), 'id="peerreviewed"');
        ?>        

    </div>
    
</div>


<div class="section">

    <input type="Submit" name="submit" id="submit" value="Next &gt;" />

</div>

<?php echo form_close(); ?>