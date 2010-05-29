<p>
	<?php if ($ok == TRUE)
    { ?>
        Thank you for depositing your item. The URLs of your item are: <ul>
        <?php
        foreach ($_SESSION['deposited-url'] as $url)
        {
        ?>
            <li><a href="<?php echo $url; ?>"><?php echo $url; ?></a></li>
        <?php
        }
        ?></ul><?php
    }
    else
    { ?>
        An error has occured with your deposit. Please contact
        <a href="mailto:<?php echo $supportemail; ?>"><?php echo $supportemail; ?></a>
        for assistance, quoting reference '<?php echo $id; ?>'.<?php
    }
    ?>
</p>