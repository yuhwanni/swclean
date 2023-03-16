<?php $this->load->view( 'common/head', $this->data ); ?>

<body>
<div id="wrap">
    <div id="page_header">
        <?=modules::run( "header" )?>
    </div>
    <div id="page_contents">
        <div class="leftmenu">
            <?=modules::run( "menuleft" )?>
        </div>
        <div class="midcontents">
            <?php
            /** @noinspection PhpUndefinedVariableInspection */
            $this->load->view( $main_content, $this->data );
            ?>
        </div>
        <div class="rightmenu">
            <?=modules::run( "menuright" )?>
        </div>
    </div>
    <div id="page_footer">
        <?=modules::run( "footer" )?>
    </div>
</div>

<?php
print(isset($ADD_SCRIPT) ? $ADD_SCRIPT : "");
print(isset($ADD_CSS) ? $ADD_CSS : "");
?>
</body>



<?='</html>'?>
