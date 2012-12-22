<p>
    You have the current steps selected:

    <div class="section">
        <table>
            <tr><th>#</th><th>Name</th><th>Description</th><th colspan="3">Re-order / Delete</th><th>Settings</th></tr>
            <?php
                $counter = 1;
                foreach ($currentsteps as $step)
                {
                    ?><tr>
                        <td><?php echo $counter; ?></td>
                        <td><strong><? if (!empty($allsteps[$step]['name'])) { echo $allsteps[$step]['name']; } else { echo $step; } ?></strong></td>
                        <td><? if (!empty($allsteps[$step]['description'])) { echo $allsteps[$step]['description']; }?></td>
                        <td><?php if ($counter != 1) { ?><a href="./admin/arrangesteps/up/<?php echo $step; ?>/<?php echo ($counter - 1); ?>"><img src="<?php echo base_url(); ?>img/arrow_up.png" alt="Move step down"/></a><?php } ?></td>
                        <td><?php if ($counter != count($currentsteps)) { ?><a href="./admin/arrangesteps/down/<?php echo $step; ?>/<?php echo ($counter - 1); ?>"><img src="<?php echo base_url(); ?>img/arrow_down.png" alt="Move step down"/></a><?php } ?></td>
                        <td><?php if (count($currentsteps) > 1) { ?><a href="./admin/arrangesteps/delete/<?php echo $step; ?>/<?php echo ($counter - 1); ?>"><img src="<?php echo base_url(); ?>img/cross.png" alt="Delete step"/></a><?php } ?></td>
                        <td><a href="./admin/editstepsettings/<?php echo $step; ?>">Edit settings</a></td>
                    </tr><?php
                    $counter++;
                }
            ?>
        </table>
    </div>

    Steps you can add:

    <div class="section">
        <table>
            <tr><th>Name</th><th>Description</th><th>Notes</th><th>Add</th></tr>
            <?php
                foreach ($allsteps as $step)
                {
                    ?><tr>
                        <td><strong><? echo $step['name']; ?></strong></td>
                        <td><? if (!empty($step['description'])) { echo $step['description']; }?></td>
                        <td><small><? if (!empty($step['notes'])) { echo $step['notes']; }?></small></td>
                        <td><a href="./admin/arrangesteps/add/<?php echo $step['name']; ?>"><img src="<?php echo base_url(); ?>img/add.png"></a></td>
                    </tr><?php
                }
            ?>
        </table>
    </div>

    Go back to the <a href="./admin">administration home page</a>.

</p>