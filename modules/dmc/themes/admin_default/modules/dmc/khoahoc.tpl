<!-- BEGIN: main -->
<table class="tab1">
	<thead>
		<tr>			
            <td>{LANG.kh_name}</td>		            
            <td>{LANG.kh_hdt}</td>
            <td>{LANG.kh_ngayvao}</td>
            <td>{LANG.kh_ngayra}</td>
            <td>{LANG.lc_action}</td>
		</tr>
	</thead>
    <tbody>
    <!-- BEGIN: loop -->							   				   					   	
	    <tr>	    	
            <td>{DATA.kh_name}</td>		            
            <td>{DATA.kh_hdt}</td>
            <td>{DATA.kh_ngayvao}</td>
            <td>{DATA.kh_ngayra}</td>
	        <td align="center">
	        	<span class="edit_icon">
	               <a class='editfile' href="{URL_EDIT}{DATA.kh_id}">{LANG.edit}</a>
	            </span>
	            <span class="delete_icon">
	               <a class='khdelfile' href="{URL_DEL}{DATA.kh_id}">{LANG.del}</a>
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
            	<td colspan="2">Thông tin khóa học mới</td>
         	</tr>
      	</thead>
      	<tbody>
        	<tr>
            	<td style="width: 150px">Tên khóa học</td>
            	<td style="background: #eee"><input name="kh_name" style="width: 470px" value="" type="text"></td>
         	</tr>
      	</tbody>
      	<tbody>
        	<tr>
            	<td>Hệ đào tạo</td>
            	<td>
            		<select name="kh_hdt">
            			<option value="daihoc">Đại học</option>
            			<option value="caodang">Cao đẳng</option>
            			<option value="trungcap">Trung cấp</option>
            		</select>
            	</td>
         	</tr>
      	</tbody>
      	<tbody>
        	<tr>
            	<td>Ngay bắt đầu</td>
            	<td>
					<input id="ngayvao" name="kh_ngayvao" style="width: 470px" value="" type="text" />
       				<img src="{LANG.url}images/calendar.jpg" style="cursor: pointer; vertical-align: middle;" onclick="popCalendar.show(this, 'ngayvao', 'dd.mm.yyyy', true);" alt="" height="17" />
				</td>
         	</tr>
      	</tbody>		    
      	<tbody>
        	<tr>
            	<td>Ngày kết thúc</td>
            	<td>
            		<input id="ngayra" name="kh_ngayra" style="width: 470px" value="" type="text" />
       				<img src="{LANG.url}images/calendar.jpg" style="cursor: pointer; vertical-align: middle" onclick="popCalendar.show(this, 'ngayra', 'dd.mm.yyyy', true);" alt="" height="17" />       				
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