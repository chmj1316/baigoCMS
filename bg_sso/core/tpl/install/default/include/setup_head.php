<?php $cfg["title"] = $this->lang["page"]["upgrade"];
include($cfg["pathInclude"] . "html_head.php"); ?>

    <div class="container">
        <div class="bg-panel">
            <h3><?php echo $this->lang["page"]["setup"]; ?></h3>
            <div class="panel panel-success">
                <div class="panel-heading bg-panel-heading">
                    <img class="img-responsive center-block" src="<?php echo BG_URL_STATIC; ?>console/<?php echo BG_DEFAULT_UI; ?>/image/logo.png">
                </div>

                <div class="panel-body">
                    <h4><?php echo $cfg["sub_title"]; ?></h4>

                    <hr>
