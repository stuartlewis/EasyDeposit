<p>
	Please edit the deposit URLs and credentials. For each deposit location provide a separate value on a new line:
</p>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/editstepsettings/' . $stepname); ?>

<input type="hidden" name="define-depositurl" value="array" />
<input type="hidden" name="description-depositurl" value="Deposit URLs" />

<input type="hidden" name="define-username" value="array" />
<input type="hidden" name="description-username" value="Usernames" />

<input type="hidden" name="define-password" value="array" />
<input type="hidden" name="description-password" value="Passwords" />

<input type="hidden" name="define-obo" value="array" />
<input type="hidden" name="description-obo" value="On behalf ofs" />

<div class="section">

    <div class="formtextnext">

        <label for="depositurl" class="fixedwidthlabel">Deposit URL:</label>
        <textarea id="depositurl" name="depositurl" cols="90" rows="6"><?php
            if (!empty($configoptions['depositurl'])) { foreach ($configoptions['depositurl'] as $url) echo $url . "\n"; }
        ?></textarea>
        <br />

        <label for="username" class="fixedwidthlabel">Username:</label>
        <textarea id="username" name="username" cols="90" rows="6"><?php
            if (!empty($configoptions['username'])) { foreach ($configoptions['username'] as $u) echo $u . "\n"; }
        ?></textarea>
        <br />

        <label for="password" class="fixedwidthlabel">Password:</label>
        <textarea id="password" name="password" cols="90" rows="6"><?php
            if (!empty($configoptions['password'])) { foreach ($configoptions['password'] as $p) echo $p . "\n"; }
        ?></textarea>
        <br />

        <label for="obo" class="fixedwidthlabel">Ob behalf of:</label>
        <textarea id="obo" name="obo" cols="90" rows="6"><?php
            if (!empty($configoptions['obo'])) { foreach ($configoptions['obo'] as $o) echo $o . "\n"; } 
        ?></textarea>

    </div>

</div>

<div class="section">

    <input type="Submit" name="submit" id="submit" value="Update" />
    <input type="Submit" name="cancel" id="cancel" value="Cancel" />

</div>

<?php echo form_close(); ?>