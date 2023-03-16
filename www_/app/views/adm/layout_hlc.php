<?php $this->load->view( 'common/head', $this->data ); ?>

<body>
<!-- begin #page-container -->
<div id="page-container" class="page-header-fixed page-sidebar-fixed">

	<!-- begin #header -->
	<div id="header" class="header navbar navbar-default navbar-fixed-top">
        <?=modules::run( "Section_Top" )?>
    </div>
    <!-- end #header -->
    
    <!-- begin #sidebar -->
	<div id="sidebar" class="sidebar">
    	<?=modules::run( "Section_Left" )?>
    </div>
	<div class="sidebar-bg"></div>
	<!-- end #sidebar -->
	
	
	<!-- begin #content -->
	<div id="content" class="content">
		<?php            
           $this->load->view( $main_content, $this->data );
		?>
    </div>
	<!-- end #content -->
	
	
	<!-- begin scroll to top btn -->
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<!-- end scroll to top btn -->
</div>
<!-- end page container -->
</body>
<?='</html>'?>
