<p>
	Please check the following details are correct:
</p>

<?php
    $counter = 0;
    $section = '';
    $part3 = 'false';

    foreach ($verify as $part)
    {
        if ($part[2] != $section)
        {
            if ($counter != 0)
            { ?>
                </div>
            <?php } ?>
            <div class="well">
            <?php if ($part[3] == 'true')
            { ?>
                <?php echo form_open('verify'); ?>
                <div class="pull-right">
                    <input type="submit" name="submit" class="btn-info" value="Edit" />
                    <input type="hidden" name="modify" value="<?php echo $part[2]; ?>" />
                </div>
                <?php echo form_close();
            } ?>
            <?php
        }

        $section = $part[2];
        $counter++;
        ?>
        <strong><?php echo $part[0]; ?>:</strong> <?php echo $part[1]; ?> <br />
        <?php
    } ?>
    </div>

<div class="well">

    Please note: it may take a minute or two for the deposit to complete. Do not press the button more than once.
    If you have any problems please email <a href='mailto:<?php echo $supportemail; ?>'><?php echo $supportemail; ?></a>
    quoting reference '<?php echo $id; ?>'.

    <?php echo form_open('verify'); ?>
        <input type="Submit" name="submit" id="submit" class="btn-primary" value="I understand and agree: Deposit my item" />
        <input type="hidden" name="ok" value="ok" />
    <?php echo form_close(); ?>

</div>