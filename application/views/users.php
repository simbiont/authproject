    <div class="row">

        <div class="span10 offset1">
            <table id="tblJQGrid"></table>
            <div id="divPager"></div>
        </div>
        <div class="span4 offset1 grid_buttons">            
            <input type="button" id="bedata" class="btn btn-success" value="Add New User" />
            <input type="button" id="dedata" class="btn btn-danger" value="Delete Selected User" />
        </div>

    </div>

	<script type="text/javascript">

		var page = '<?php echo $page ?>';

		$(document).ready(function() {

			createUserGrid();

		});

		function createUserGrid() {

			var projectsDataProviderUrl = 'projects/ajax_json_provider_users/' + page;
			var projectsDataEditUrl = 'projects/ajax_json_edit_users/' + page;
			var lastsel;
			xxx = $("#tblJQGrid").jqGrid({
				url: projectsDataProviderUrl,
				datatype: "json",
				height: '100%',
				width: 1000,	        	
				colNames:[ 'Name', 'Role', 'Email' ],
				colModel:[
					{name:'name',index:'name', editable:true, width:100},

					{name:'role',index:'role', editable:true, width:100, editoptions:{size:"20"}},

					{name:'email',index:'amount', width:80, editable:true, align:"right", editoptions:{size:"10",maxlength:"30"}}

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
				rowNum: 5,
				rowList:[ 10,20,30 ],
				loadonce: false,
				pager: '#divPager',
				gridview: true,
				editurl: projectsDataEditUrl,
				caption: "Projects List" 
			});
			// function pickdates(id){
			// 	$("#"+id+"_date","#tblJQGrid").datepicker({dateFormat:"yy-mm-dd"});

			// 	$("#date").datepicker({dateFormat:"yy-mm-dd", showOn:'button'});

			// }
			$("#bedata").click(function(){
				$("#tblJQGrid").jqGrid('editGridRow',"new",{height:'auto', width:'auto',reloadAfterSubmit:true, closeAfterAdd:true});
			});
			$("#dedata").click(function(){
				var gr = $("#tblJQGrid").jqGrid('getGridParam','selrow');
				if( gr != null ) $("#tblJQGrid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
				else alert("Please Select Row to delete!");
			});
			$("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:false});

		}
	</script>