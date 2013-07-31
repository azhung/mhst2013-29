<!-- BEGIN: main -->
<table class="tab1">
	<thead>
		<tr>			
            <td>{LANG.cd_name}</td>		            
            <td>{LANG.cd_lienchi}</td>            
            <td>{LANG.lc_action}</td>
		</tr>
	</thead>
    <tbody>
    <!-- BEGIN: loop -->							   				   					   	
	    <tr>	    	
            <td>{DATA.cd_name}</td>		            
            <td>{DATA.cd_lcid}</td>            
	        <td align="center">
	        	<span class="edit_icon">
	               <a class='editfile' href="{URL_EDIT}{DATA.cd_id}">{LANG.edit}</a>
	            </span>
	            <span class="delete_icon">
	               <a class='khdelfile' href="{URL_DEL}{DATA.cd_id}">{LANG.del}</a>
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
            	<td colspan="2">Thông tin chi đoàn mới</td>
         	</tr>
      	</thead>
      	<tbody>
        	<tr>
            	<td style="width: 150px">Tên chi đoàn</td>
            	<td style="background: #eee"><input name="cd_name" style="width: 470px" value="" type="text"></td>
         	</tr>
      	</tbody>
      	<tbody>
        	<tr>
            	<td>Liên chi đoàn</td>
            	<td>
            		<select name="cd_lcid">
            			 <!-- BEGIN: loop1 -->							   				   					   	
						    <option value="{DATA1.lc_name}">{DATA1.lc_name}</option>
						<!-- END: loop1 -->	
            		</select>
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
      $('a[class="khdelfile"]').click(function(event)
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
                  window.location = '{URL_DEL_BACK}';
               }
            });
         }
      });
   });
</script>
<!-- END: main -->