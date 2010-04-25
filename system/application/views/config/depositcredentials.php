<p>
	Please edit the deposit URL and credentials:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-depositurl" value="string" />
<input type="hidden" name="required-depositurl" value="true" />
<input type="hidden" name="description-depositurl" value="Deposit URL" />

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

        <label for="depositurl" class="fixedwidthlabel">Deposit URL:</label>
        <input type="text" id="depositurl" name="depositurl" size="60"
               value="<?php if (!empty($configoptions['depositurl'])) { echo $configoptions['depositurl']; } ?>" />
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