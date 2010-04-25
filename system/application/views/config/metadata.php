<p>
	Please edit the settings related to metadata item types and peer review status. Each line must contain the
    SWAP URL followed by a description. Each entry must be on a line.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-itemtypes" value="assocarray" />
<input type="hidden" name="description-itemtypes" value="Item type URLs" />

<input type="hidden" name="define-peerreviewstatus" value="assocarray" />
<input type="hidden" name="description-peerreviewstatus" value="Peer review status" />

<div class="section">

    <div class="formtextnext">

        <label for="itemtypes" class="fixedwidthlabel">Item type URLs:</label>
        <textarea id="itemtypes" name="itemtypes" cols="90" rows="12"><?php if (!empty($configoptions['itemtypes'])) {
            foreach ($configoptions['itemtypes'] as $key => $value)
            {
                echo $key . ' ' . $value . '
';   
            }
        } ?></textarea>
        <br />

        <label for="peerreviewstatus" class="fixedwidthlabel">Peer review status:</label>
        <textarea id="peerreviewstatus" name="peerreviewstatus" cols="90" rows="3"><?php if (!empty($configoptions['peerreviewstatus'])) {
            foreach ($configoptions['peerreviewstatus'] as $key => $value)
            {
                echo $key . ' ' . $value . '
';
            }
        } ?></textarea>
        <br />


    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>