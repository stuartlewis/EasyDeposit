<p>
	Please edit the settings for your SSO server.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-username" value="string" />
<input type="hidden" name="required-username" value="true" />
<input type="hidden" name="description-username" value="Header containing username" />

<input type="hidden" name="define-firstname" value="string" />
<input type="hidden" name="required-firstname" value="true" />
<input type="hidden" name="description-firstname" value="Header containing first name" />

<input type="hidden" name="define-surname" value="string" />
<input type="hidden" name="required-surname" value="true" />
<input type="hidden" name="description-surname" value="Header containing surname" />

<input type="hidden" name="define-email" value="string" />
<input type="hidden" name="required-email" value="true" />
<input type="hidden" name="description-email" value="Header containing email" />


<div class="section">

    <div class="formtextnext">

        <label for="username" class="fixedwidthlabel">Username header:</label>
        <input type="text" id="username" name="username" size="60"
               value="<?php if (!empty($configoptions['username'])) { echo $configoptions['username']; } ?>" />
        <br />

        <label for="firstname" class="fixedwidthlabel">First name header:</label>
        <input type="text" id="firstname" name="firstname" size="60"
               value="<?php if (!empty($configoptions['firstname'])) { echo $configoptions['firstname']; } ?>" />
        <br />

         <label for="surname" class="fixedwidthlabel">Surname header:</label>
         <input type="text" id="surname" name="surname" size="60"
                value="<?php if (!empty($configoptions['surname'])) { echo $configoptions['surname']; } ?>" />

        <br />

         <label for="email" class="fixedwidthlabel">Email header:</label>
         <input type="text" id="email" name="email" size="60"
                value="<?php if (!empty($configoptions['email'])) { echo $configoptions['email']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>