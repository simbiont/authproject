<div class="row">

	<div class="span10 offset1">
		<h2><?= $title ?></h2>
		<div id="project_grid" class="clearfix">

			<table id="tblJQGrid"></table>
			<div id="divPager"></div>

		</div>

	</div>

	<?php echo $this->load->view('upload-form', $this->data); ?>

</div>

<script type="text/javascript">

	var page = '<?php echo $page ?>';
	var dropdown = '<?php echo $dropdown ?>';
	var fields_num = '<?php echo $fields_num ?>';

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
			height: '100%',
			width: 970,	        	
			colNames:[ 'Initials', 'Date', 'Service','Description','Hours','Rate','Amount' ],
			colModel:[
				{name:'initials',index:'initials', editable:true, width:100, editoptions:{size:"20"}},

				{name:'date',index:'date', sorttype:'date', formatter: 'date', formatoptions: { 'srcformat' : 'Y-m-d H:i:s', 'newformat' : 'Y-m-d' }, editable:true, width:60, editoptions:{
					dataInit:function(el){ 
						$(el).datepicker({dateFormat:'yy-mm-dd'}); 
					},
					defaultValue: function(){ 
						var currentTime = new Date(); 
						var month = parseInt(currentTime.getMonth() + 1); 
						month = month <= 9 ? "0"+month : month; 
						var day = currentTime.getDate(); 
						day = day <= 9 ? "0"+day : day; 
						var year = currentTime.getFullYear(); 
						return year+"-"+month + "-"+day; 
					}
				}},
				{name:'service',index:'service', editable:true, width:100, edittype:"select",editoptions:{value:dropdown}},
				
				{name:'description',index:'description', editable:true, width:180, align:"right", edittype:"textarea", editoptions:{rows:"2",cols:"30"}},
				{name:'hours',index:'hours', width:80, editable:true, align:"right", editoptions:{size:"10"}},		
				{name:'rate',index:'rate', width:80, editable:true, align:"right", editoptions:{size:"10"}},		
				{name:'amount',index:'amount', width:80, editable:true, align:"right", editoptions:{size:"10"}}

			],
			viewrecords: true,
			sortorder: "desc",
			rowNum: fields_num,
			rowList:[ fields_num,fields_num*2,fields_num*3 ],
			loadonce: false,
			pager: '#divPager',
			gridview: true,
			editurl: projectsDataEditUrl,
			caption: "Projects List" 
		});
		$("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:true, deltext: 'Delete'});
		$("#tblJQGrid").jqGrid('inlineNav',"#divPager", {add:true,edittext: 'Edit', addtext: 'Add', savetext:'Save', canceltext:'Cancel'});
	}
</script>