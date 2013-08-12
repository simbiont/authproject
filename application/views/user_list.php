    <div class="row">

        <div class="span10 offset1">
            <table id="tblJQGrid"></table>
            <div id="divPager"></div>
        </div>

    </div>

	<script type="text/javascript">

		var page = '<?php echo $page ?>';

		$(document).ready(function() {

			createUserGrid();
			$("#tblJQGrid").jqGrid('navGrid',"#divPager",{edit:false,add:false,del:true,deltext: 'Delete'});
			$("#tblJQGrid").jqGrid('inlineNav',"#divPager", {addtext: 'Add',edittext: 'Edit',savetext:'Save', canceltext:'Cancel'});

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
					{name:'password',index:'password', width:100, editable:true, align:"center", edittype:"password", hidden:false, editrules: {edithidden:true, required:true, custom:true, custom_func:myminlenght}, editoptions:{size:"10",minlength:"8"}},
	
					{name:'id',index:'id', hidden:true, editrules: {edithidden:false} },
				],				
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
		}

		function myminlenght (value, colname) {
			if (colname=='Password' && value.length < 8){

				return [false,"Password must have more than 8 chars",""];

			} else {
				return [true,"",""];

			}
		}
	</script>