<p>
	Enter the URL for a GitHub repository: (https://github.com/{account}/{repository})
</p>

<?php echo validation_errors('<div class="alert">', '</div>'); ?>

<?php
    $attributes = array('class' => 'form-horizontal');
    echo form_open('github', $attributes);
?>

    <div class="control-group">
        <label class="control-label" for="githuburl">GitHub URL:</label>
        <div class="controls">
            <input type="text" id="githuburl" name="githuburl" style="width:40em;" value="<?php
            if (isset($_SESSION['external-referrer'])) {
                echo $_SESSION['external-referrer'];
            } else {
                echo set_value('githuburl');
            } ?>" />
        </div>
    </div>

    <input type="Submit" name="submit" id="submit" class="btn-primary" value="Next &gt;" />

<?php echo form_close(); ?>

<p>
    Install the GitHub deposit bookmarklet by dragging this to your bookmarks: <a class="btn-info" id="installBookmarklet"
    href="javascript:void(location.href='http://localhost/easydeposit/easydeposit?referrer='+location.href)" title="GitHub Deposit">GitHub Deposit</a>
</p>