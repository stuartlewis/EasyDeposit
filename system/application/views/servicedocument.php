<p>
	Select a collection into which you wish to deposit an item.
</p>

<div class="section">

    Server details:
    <ul>
        <li><label>Service document:</label> <?php echo $servicedocument->sac_url; ?></li>
        <li><label>SWORD version:</label> <?php echo $servicedocument->sac_version; ?></li>
        <li><label>Supports verbose output:</label> <?php echo $servicedocument->sac_verbose; ?></li>
        <li><label>Supports NoOp:</label> <?php echo $servicedocument->sac_noop; ?></li>
    </ul>

</div>


<div class="section">

    Service document:

    <ul>
        <?php
            // Iterate through each workspace
            $counter = 0;
            foreach ($servicedocument->sac_workspaces as $workspace)
            {
                $counter++;
                ?>
                    <li><label>Workspace:</label> <?php echo $workspace->sac_workspacetitle; ?><ul>
                <?php
                if ($workspace->sac_collections == null)
                {
                    $workspace->sac_collections = array();
                    ?><li>There are no collections that you are able to deposit into</li><?php
                }   
                foreach ($workspace->sac_collections as $collection)
                {
                    $counter++;                    
                    ?>
                        <?php echo form_open('servicedocument'); ?>
                        <li><label>Collection:</label> <?php echo $collection->sac_colltitle; ?>
                            <input type="Submit" name="submit" id="submit" value="Deposit" />
                            <input type="hidden" name="depositurl" value="<?php echo $collection->sac_href; ?>" />
                        <ul>
                        <li class="showmore"><span class="t<?php echo $counter; ?>_toggle">Show more information...</span></li>
                        <?php echo form_close(); ?>
                        <span class="t<?php echo $counter; ?>_slide">
                                <?php
                                    if (!empty($collection->sac_abstract)) {
                                        ?><label>Abstract:</label> <?php echo $collection->sac_abstract; ?><br /><?php
                                    }
                                ?>
                                <?php
                                    if (!empty($collection->sac_collpolicy)) {
                                        ?><label>Collection Policy:</label> <?php echo $collection->sac_collpolicy; ?><br /><?php
                                    }
                                ?><?php
                                    if (count($collection->sac_accept) > 0)
                                    {
                                        ?><label>Accepts:</label> <?php
                                        foreach ($collection->sac_accept as $accept)
                                        {
                                            echo $accept . ' ';
                                        }
                                    }
                                ?><br />
                                <?php
                                    if (count($collection->sac_acceptpackaging) > 0)
                                    {
                                        ?><label>Accepted packaging formats:</label> <?php
                                        foreach ($collection->sac_acceptpackaging as $acceptpackaging => $q)
                                        {
                                            echo '<a href="' . $acceptpackaging . '">' . $acceptpackaging . '</a> (q=' . $q . ') ';
                                        }
                                    }
                                ?><br />
                                <?php
                                    $mediation = "false";
                                    if ($collection->sac_mediation == true) { $mediation = "true"; }
                                ?>
                                <label>Mediation:</label> <?php echo $mediation ?><br />
                            </span>
                            <?php
                                if (!empty($collection->sac_service))
                                {
                                    echo form_open('servicedocument');
                                    ?><label>Nested service document:</label>
                                    <input type="Submit" name="submit" id="submit" value="More &gt;" class="smallbutton" />
                                    <input type="hidden" name="url" value="<?php echo $collection->sac_service; ?>" />
                                    <input type="hidden" name="username" value="<?php echo $username ?>" />
                                    <input type="hidden" name="password" value="<?php echo $password ?>" />
                                    <input type="hidden" name="obo" value="<?php echo $obo ?>" /><?php                                    
                                    echo form_close();
                                }
                            ?>
                    </ul></li><?php
                }
                ?></ul></li><?php
            }
        ?>
    </ul>

</div>