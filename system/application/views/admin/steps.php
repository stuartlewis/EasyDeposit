<p>
    You have the current steps selected:

    <div class="section">
        <ul>
            <?php
                foreach ($currentsteps as $step)
                {
                    ?><li><strong><? if (!empty($allsteps[$step]['name'])) { echo $allsteps[$step]['name']; } else { echo $step; } ?>: </strong>
                    <? if (!empty($allsteps[$step]['description'])) { echo $allsteps[$step]['description']; }?><?php
                }
            ?>
        </ul>
    </div>

    Steps you can add:

    <div class="section">
        <ul>
            <?php
                foreach ($allsteps as $step)
                {
                    ?><li><strong><? if (!empty($step['name'])) { echo $step['name']; } else { echo $step; } ?>: </strong>
                    <? if (!empty($step['description'])) { echo $step['description']; }?>
                    <em><? if (!empty($step['notes'])) { echo '('.$step['notes'].')'; }?></em></li><?php
                }
            ?>
        </ul>
    </div>

    Go back to the <a href="./admin">administration home page</a>.

</p>