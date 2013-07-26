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

			var usersDataProviderUrl = 'users/ajax_json_provider_users/' + page;
			var usersDataEditUrl = 'users/ajax_json_edit_users/' + page;
			var lastsel;
			xxx = $("#tblJQGrid").jqGrid({
				url: usersDataProviderUrl,
				datatype: "json",
				height: '100%',
				width: 1000,	        	
				colNames:[ 'Name', 'Email', 'Password', 'Id' ],
				colModel:[
					{name:'username',index:'username', align:"center", editable:true, editrules: {required:true}, width:100},
					{name:'email',index:'email', width:100, editable:true, align:"center", editrules: {email:true, required:true}, editoptions:{size:"10",maxlength:"30"}},
					{name:'password',index:'password', width:100, editable:true, align:"center", edittype:"password", hidden:true, editrules: {edithidden:true, required:true, custom:true, custom_func:myminlenght}, editoptions:{size:"10",minlength:"8"}},
	
					{name:'id',index:'id', hidden:true, editrules: {edithidden:false} },	
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
				editurl: usersDataEditUrl,
				caption: "Users List" 
		});
		function myminlenght (value, colname) {
			if (colname=='Password' && value.length < 8){

				return [false,"Password must have more than 8 chars",""];

			} else {
				return [true,"",""];

			}
		}
		$("#bedata").click(function(){
			$("#tblJQGrid").jqGrid('editGridRow',"new",{ height:'auto', width:'auto',reloadAfterSubmit:true, recreateForm:false, closeAfterAdd:false, afterSubmit : function(response) { if(response.responseText != "") alert(response.responseText); return false;}});
		});
		$("#dedata").click(function(){
			var gr = $("#tblJQGrid").jqGrid('getGridParam','selrow');
			if( gr != null ) $("#tblJQGrid").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
			else alert("Please Select Row to delete!");
		});
		$("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:false});

		}
	</script>