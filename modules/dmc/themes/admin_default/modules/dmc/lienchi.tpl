<!-- BEGIN: main -->
<table class="tab1">
	<thead>
		<tr>			
            <td>{LANG.lc_name}</td>		            
            <td>{LANG.lc_mota}</td>
            <td>{LANG.lc_action}</td>
		</tr>
	</thead>
    <tbody>
    <!-- BEGIN: loop -->							   				   					   	
	    <tr>	    	
	        <td>{DATA.lc_name}</td>
	        <td>{DATA.lc_mota}</td>
	        <td align="center">
	        	<span class="edit_icon">
	               <a class='editfile' href="{URL_EDIT}{DATA.lc_id}">{LANG.edit}</a>
	            </span>
	            <span class="delete_icon">
	               <a class='delfile' href="{URL_DEL}{DATA.lc_id}">{LANG.del}</a>
	            </span>
	         </td>		            
	  	</tr>
	<!-- END: loop -->									
	</tbody>
</table>	
	
<form method="post">
	<table class="tab1">
		<thead>
        	<tr>
            	<td colspan="2">{LANG.lc_them}</td>
         	</tr>
		</thead>
      	<tbody>
        	<tr>
            	<td style="width: 150px">{LANG.lc_them_tenlc}</td>
            	<td style="background: #eee">
            		<input name="lc_name" style="width: 470px" value="" type="text">
            	</td>
         	</tr>
         	<tr>
            	<td style="width: 150px">{LANG.lc_them_mota}</td>
            	<td style="background: #eee">
            		<input name="lc_mota" style="width: 470px" value="" type="text">		            		
            	</td>
         	</tr>
      	</tbody>		      			    
	        <tr>
				<td colspan="2" align="center" style="background: #eee">
	               	<input name="confirm" value="Lưu" type="submit">
	               	<input type="hidden" name="add" value="1">
	            </td>
	      	</tr>
   	</table>
</form>	

<script type='text/javascript'>
   $(function()
   {
      $('a[class="delfile"]').click(function(event)
      {
         event.preventDefault();
         if (confirm("{LANG.del_cofirm}"))
         {
            var href = $(this).attr('href');
            $.ajax(
            {
               type: 'POST',
               url: href,
               data: '',
               success: function(data)
               {
                  alert(data);
                  alert({DATA.lc_id});
                  window.location = '{URL_DEL_BACK}';
               }
            });
         }
      });
   });
</script>

<!-- END: main -->