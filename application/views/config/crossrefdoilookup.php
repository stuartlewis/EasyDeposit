<p>
	Please enter your CrossRef API key. Keys can be obtained from
    <a href="http://www.crossref.org/requestaccount/">http://www.crossref.org/requestaccount/</a><br />
    Your API KEY is the email address that you used to register.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-apikey" value="string" />
<input type="hidden" name="required-apikey" value="true" />
<input type="hidden" name="description-apikey" value="API Key" />

<div class="section">

    <div class="formtextnext">

        <label for="apikey">CrossRef API Key:</label>
        <input type="text" id="apikey" name="apikey" size="60"
               value="<?php if (!empty($configoptions['apikey'])) { echo $configoptions['apikey']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>