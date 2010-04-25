<p>
	Please edit the URL and credentials for the service document:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-url" value="string" />
<input type="hidden" name="required-url" value="true" />
<input type="hidden" name="description-url" value="Service document URL" />

<input type="hidden" name="define-username" value="string" />
<input type="hidden" name="required-username" value="true" />
<input type="hidden" name="description-username" value="Username" />

<input type="hidden" name="define-password" value="string" />
<input type="hidden" name="required-password" value="true" />
<input type="hidden" name="description-password" value="Password" />

<input type="hidden" name="define-obo" value="string" />
<input type="hidden" name="description-obo" value="On behalf of" />

<div class="section">

    <div class="formtextnext">

        <label for="url" class="fixedwidthlabel">Service document URL:</label>
        <input type="text" id="url" name="url" size="60"
               value="<?php if (!empty($configoptions['url'])) { echo $configoptions['url']; } ?>" />
        <br />

        <label for="username" class="fixedwidthlabel">Username:</label>
        <input type="text" id="username" name="username" size="60"
               value="<?php if (!empty($configoptions['username'])) { echo $configoptions['username']; } ?>" />
        <br />

        <label for="password" class="fixedwidthlabel">Password:</label>
        <input type="text" id="password" name="password" size="60"
               value="<?php if (!empty($configoptions['password'])) { echo $configoptions['password']; } ?>" />
        <br />

        <label for="obo" class="fixedwidthlabel">On behalf of:</label>
        <input type="text" id="obo" name="obo" size="60"
               value="<?php if (!empty($configoptions['obo'])) { echo $configoptions['obo']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>