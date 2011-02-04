<p>
	Please edit the settings for your LDAP server. The 'NetID name' is the name you use locally
    to describe the login that your users use. Examples include: 'login', 'netid', username', 'id' etc.
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-netidname" value="string" />
<input type="hidden" name="required-netidname" value="true" />
<input type="hidden" name="description-netidname" value="NetID name" />

<input type="hidden" name="define-server" value="string" />
<input type="hidden" name="required-server" value="true" />
<input type="hidden" name="description-server" value="LDAP server" />

<input type="hidden" name="define-context" value="string" />
<input type="hidden" name="required-context" value="true" />
<input type="hidden" name="description-context" value="Search context" />


<div class="section">

    <div class="formtextnext">

        <label for="netidname" class="fixedwidthlabel">NetID name:</label>
        <input type="text" id="netidname" name="netidname" size="60"
               value="<?php if (!empty($configoptions['netidname'])) { echo $configoptions['netidname']; } ?>" />
        <br />

        <label for="server" class="fixedwidthlabel">LDAP server:</label>
        <input type="text" id="server" name="server" size="60"
               value="<?php if (!empty($configoptions['server'])) { echo $configoptions['server']; } ?>" />
        <br />

        <label for="context" class="fixedwidthlabel">Search context:</label>
        <input type="text" id="context" name="context" size="60"
               value="<?php if (!empty($configoptions['context'])) { echo $configoptions['context']; } ?>" />

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>