    <div class="row">

        <div class="span10 offset1">
            <table id="tblJQGrid"></table>
            <div id="divPager"></div>
        </div>
        <div class="span4 offset1 grid_buttons">            
            <input type="button" id="bedata" class="btn btn-success" value="Add New Field" />
            <input type="button" id="dedata" class="btn btn-danger" value="Delete Selected Field" />
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
			height: '100%',
			width: 1000,	        	
			colNames:[ 'Date', 'Service', 'Initials','Description','Hours','Rate','Amount' ],
			colModel:[
				{name:'date',index:'date', editable:true, width:100,editable:true, editoptions:{
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
				{name:'service',index:'service', editable:true, width:100, edittype:"select",editoptions:{value:"Test:Test;'Some Service':Some Service;Site:Site"}},
				{name:'initials',index:'initials', editable:true, width:100, editoptions:{size:"20"}},
				{name:'description',index:'description', editable:true, width:180, align:"right", edittype:"textarea", editoptions:{rows:"2",cols:"20"}},
				{name:'hours',index:'hours', width:80, editable:true, align:"right", editoptions:{size:"10",maxlength:"30"}},		
				{name:'rate',index:'rate', width:80, editable:true, align:"right", editoptions:{size:"10",maxlength:"30"}},		
				{name:'amount',index:'amount', width:80, editable:true, align:"right", editoptions:{size:"10",maxlength:"30"}}

			],

			onSelectRow: function(id){
				if(id && id!==lastsel){
					$('#tblJQGrid').jqGrid('restoreRow',lastsel);
					$('#tblJQGrid').jqGrid('editRow',id,true);
					lastsel=id;
				}
			},

			viewrecords: true,
			sortorder: "desc",
			rowNum:10,
			rowList:[ 10,20,30 ],
			loadonce: false,
			pager: '#divPager',
			gridview: true,
			editurl: projectsDataEditUrl,
			caption: "Projects List" 
		});

		$("#bedata").click(function(){
			jQuery("#tblJQGrid").jqGrid('editGridRow',"new",{height:'auto', width:'auto',reloadAfterSubmit:true});
		});
		$("#dedata").click(function(){
			var gr = jQuery("#tblJQGrid").jqGrid('getGridParam','selrow');
			if( gr != null ) jQuery("#tblJQGrid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
			else alert("Please Select Row to delete!");
		});
		$("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:false});

	}
</script>