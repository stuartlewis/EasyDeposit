<p>
	<?php if ($ok == TRUE) { ?>
	        Thank you for depositing your item. The URL of your item is:
	        <a href="<?php echo $_SESSION['deposited-url']; ?>"><?php echo $_SESSION['deposited-url']; ?></a><?php
          }
          else
          { ?>
            An error has occurred with your deposit. Please contact
            <a href="mailto:<?php echo $supportemail; ?>"><?php echo $supportemail; ?></a>
            for assistance, quoting reference '<?php echo $id; ?>'.<?php
          }
    ?>
</p>