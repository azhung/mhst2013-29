<!-- BEGIN: main -->
	<!-- BEGIN: loop -->
		<span class="quytac">{ERROR}</span>
	<!-- END: loop -->
	<form name="add_cbdoan" action="{ACTION}" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" value="{CBDOAN.id}">
		<table class="tab1">
		<tbody>
			<tr>
				<td style="width: 200px">{LANG.ten}</td>
				<td><input type="text" name="ten" value="{CBDOAN.ten}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.ngsinh}</td>
			<td><input type="text" name="ngsinh" value="{CBDOAN.ngsinh}">{LANG.ngsinh1}</td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.gtinh}</td>
				<td><input type="checkbox" name="gt" value="1" {CHECK_GT}/>{LANG.female}</td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.avt}</td>
			<td><input type="text" name="avt" id="pic_path" value="{CBDOAN.avt}">
			<input value="{LANG.select_pic}" name="selectimg" type="button"/></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.nvdoan}</td>
			<td><input type="text" name="nvdoan" value="{CBDOAN.nvdoan}">{LANG.ngsinh1}</td>
			</tr>
		</tbody>

		<tbody class="second">
			<tr>
				<td>{LANG.dang}</td>
				<td><input type="checkbox" name="dang" value="1" {CHECK_D} /></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.nvdang}</td>
				<td><input type="text" name="nvdang" value="{CBDOAN.nvdang}">{LANG.ngsinh1}</td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.que}</td>
			<td><input type="text" name="que" value="{CBDOAN.que}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td>{LANG.diachi}</td>
			<td><input type="text" name="diachi" value="{CBDOAN.diachi}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>

		<tbody class="second">
			<tr>
				<td>{LANG.donvi}</td>
			<td>
                    <select name="madvi">
						<option value="">{LANG.chon_dv}</option>
                        <!-- BEGIN: dv -->
							<option value="{LIST_DV.madvi}" {SELECT}>{LIST_DV.tendvi}</option>
                        <!-- END: dv -->
                    </select>
			</td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.chucvu}</td>
				<td>
                    <select name="macvu1">
						<option value="">{LANG.chon_cv1}</option>
                        <!-- BEGIN: cv1 -->
							<option value="{LIST_CV.macvu}" {SELECT1}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv1 -->
                    </select>
					
                    <select name="macvu2">
						<option value="">{LANG.chon_cv2}</option>
                        <!-- BEGIN: cv2 -->
							<option value="{LIST_CV.macvu}" {SELECT2}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv2 -->
                    </select>
					
                    <select name="macvu3">
						<option value="">{LANG.chon_cv3}</option>
                        <!-- BEGIN: cv3 -->
							<option value="{LIST_CV.macvu}" {SELECT3}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv3 -->
                    </select>
				</td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.email}</td>
			<td><input type="text" name="email" value="{CBDOAN.email}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.lienchi}</td>
			<td><input type="text" name="lienchi" value="{CBDOAN.lienchi}"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.kyluat}</td>
			<td><input type="text" name="kyluat" value="{CBDOAN.kyluat}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.doanphi}</td>
			<td><input type="text" name="phone" value="{CBDOAN.doanphi}"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.web}</td>
			<td><input type="text" name="web" value="{CBDOAN.web}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.nhanxet}</td>
			    <td>
                    <textarea name="nhanxet" cols="70" rows="5" style="width:300px">{CBDOAN.nhanxet}</textarea>
                </td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td><input type="submit" name="confirm" value="{LANG.rec}" onclick="return formtest()" />
				<td></td>
			</tr>
		</tbody>
		</table>
	</form>
	{CBDOAN_nvdoan}
<script type="text/javascript">
	$("input[name=selectimg]").click(function()
	{
		var area = "pic_path"; // return value area
		var type = "image";
		var path = "{PATH}";
		nv_open_browse_file("{BROWSER}");
		return false;
	});
</script>
<!-- END: main -->