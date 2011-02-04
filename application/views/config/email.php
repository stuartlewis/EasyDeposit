<p>
	Please edit the settings related to sending emails:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-from" value="string" />
<input type="hidden" name="required-from" value="true" />
<input type="hidden" name="description-from" value="Email from address" />

<input type="hidden" name="define-fromname" value="string" />
<input type="hidden" name="required-fromname" value="true" />
<input type="hidden" name="description-fromname" value="Email from name" />

<input type="hidden" name="define-cc" value="string" />
<input type="hidden" name="description-cc" value="CC recipients" />

<input type="hidden" name="define-subject" value="string" />
<input type="hidden" name="description-subject" value="Email subject line" />

<input type="hidden" name="define-end" value="string" />
<input type="hidden" name="description-end" value="Email footer" />

<div class="section">

    <div class="formtextnext">

        <label for="from" class="fixedwidthlabel">Email from address:</label>
        <input type="text" id="from" name="from" size="60"
               value="<?php if (!empty($configoptions['from'])) { echo $configoptions['from']; } ?>" />
        <br />

        <label for="fromname" class="fixedwidthlabel">Email from name:</label>
        <input type="text" id="fromname" name="fromname" size="60"
               value="<?php if (!empty($configoptions['fromname'])) { echo $configoptions['fromname']; } ?>" />
        <br />

        <label for="cc" class="fixedwidthlabel">CC recipients:</label>
        <input type="text" id="cc" name="cc" size="60"
               value="<?php if (!empty($configoptions['cc'])) { echo $configoptions['cc']; } ?>" />
        <br />

        <label for="subject" class="fixedwidthlabel">Email subject line:</label>
        <input type="text" id="subject" name="subject" size="60"
               value="<?php if (!empty($configoptions['subject'])) { echo $configoptions['subject']; } ?>" />
        <br />

        <label for="end" class="fixedwidthlabel">Email footer:</label>
        <textarea id="end" name="end" cols="60" rows="8"><?php if (!empty($configoptions['end'])) { echo $configoptions['end']; } ?></textarea>

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>