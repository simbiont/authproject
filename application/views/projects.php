<!DOCTYPE html>
<html>
<head>
	<?php echo $this->load->view('head'); ?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.8.13/themes/base/jquery-ui.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/jqGrid/css/ui.jqgrid.css" />
    
    <script type="text/javascript" src="<?php echo base_url().RES_DIR; ?>/jqGrid/jquery.jqGrid.js"></script>


</head>
<body>

<?php echo $this->load->view('header'); ?>

<div class="container">
	<div class="row">
		<div class="span12">
			<table id="tblJQGrid"></table>
	        <div id="divPager"></div>
        </div>
	</div>

</div>
<script type="text/javascript">

	var page = '<?php echo $page ?>';

	$(document).ready(function() {

    	createUserGrid();

	});

	function createUserGrid() {

		var projectsDataProviderUrl = 'projects/ajax_json_provider_projects/' + page;
		var projectsDataEditUrl = 'projects/ajax_json_edit_projects/' + page;
		var lastsel;
	    xxx = $("#tblJQGrid").jqGrid({
	        url: projectsDataProviderUrl,
	        datatype: "json",
	        height: 231,
	        width: 1000,	        	
	        colNames:[ 'Date', 'Service', 'Initials','Description','Hours','Rate','Amount' ],
		   	colModel:[
		   		{name:'date',index:'date', width:55, editable:true},
		   		{name:'service',index:'service', width:90, editable:true},
		   		{name:'initials',index:'initials', width:100, editable:true},
		   		{name:'description',index:'description', width:80, editable:true, align:"right"},
		   		{name:'hours',index:'hours', width:80, editable:true, align:"right"},		
		   		{name:'rate',index:'rate', width:80, editable:true,align:"right"},		
		   		{name:'amount',index:'amount', width:150, editable:true}		
		   	],   
		   	onSelectRow: function(id) {
				if(id && id!==lastsel) {
					jQuery('#tblJQGrid').jqGrid('restoreRow',lastsel);
					jQuery('#tblJQGrid').jqGrid('editRow',id,true);
					lastsel=id;
				}
			},
			viewrecords: true,
    		sortorder: "desc",
	        rowNum:15,
	        rowList:[ 10,20,30 ],
	        loadonce: false,
	        pager: '#divPager',
	        editurl: projectsDataProviderUrl,
	        caption: "Projects List" 
	    });

		function pickdates(id){
			$("#"+id+"_sdate","#tblJQGrid").datepicker({dateFormat:"yy-mm-dd"});
		}
		jQuery("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:false});
		$("#bedata").click(function(){
			var gr = jQuery("#editgrid").jqGrid('getGridParam','selrow');
			if( gr != null ) jQuery("#editgrid").jqGrid('editGridRow',gr,{height:280,reloadAfterSubmit:false});
			else alert("Please Select Row");
		});
	 //    $('#tblJQGrid').jqGrid('inlineNav', '#divPager', { edit: true, add: true, editParams: {
		//    aftersavefunc: function(rowId, response) { jQuery('#tblJQGrid').trigger('reloadGrid'); }
		// }});
	}
</script>
<?php echo $this->load->view('footer'); ?>

</body>
</html>