<?php include('amftp_header.php');?>
<script>
var amftp_am_ftp_pwd = <?php echo json_encode($amftp_am_ftp_pwd);?>;
</script>

<div id="content">
<?php 
$pwd_arr = explode('/', trim($amftp_am_ftp_pwd));
$back_amftp_am_ftp_pwd = array_slice($pwd_arr, 0, -2);
$back_amftp_am_ftp_pwd = implode('/', $back_amftp_am_ftp_pwd);

$pwd_str = array();
foreach($pwd_arr AS $key => $val)
{
	if(empty($val)) continue;
	foreach($pwd_arr AS $k=> $v)
	{
		if(empty($v)) continue;
		$pwd_str[$key]['url'] .= "/{$v}";
		$pwd_str[$key]['name'] = $v;
		if($v == $val)
			break;
	}
}
if (!empty($notice)) { ?>
	<div id="<?php echo $notice_status;?>"><?php echo $notice;?></div>
<?php } ?>
	<div style="border:1px solid #DBDEE1">
	<div class="title">
		<input type="button" value="根目录" onclick="window.location='./index.php'" class="input_button"/> 
		<input type="button" value="上级" onclick="window.location='./index.php?pwd=<?php echo $back_amftp_am_ftp_pwd;?>/'" class="input_button"/> 

		<form action="./index.php" method="GET" style="display:inline;position:relative;" id="go_pwd_form">
			<span id="pwd_str">/<?php foreach ($pwd_str AS $key => $val) { ?><a href="javascript:;" onclick="window.location='./index.php?pwd=<?php echo $val['url'];?>'"><?php echo $val['name'];?></a>/<?php }?></span>
			<input type="text" value="<?php echo $amftp_am_ftp_pwd;?>" name="pwd" id="pwd" class="input_text" style="width:65%"/> 
			<input type="submit" value="跳转"  class="input_button"/>
		</form>
		<input type="button" value="刷新" onclick="window.location='./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&reload=y'"  class="input_button"/> 
	</div>

	<form action="" id="submit_change_form" method="POST">
		<table id="rawlist">
		<tr><th width="25">选择</th>
		<?php 
			$order = ($_GET['order'] == 'asc') ? 'desc' : 'asc';	
			$order_img = isset($_GET['orderby']) ? " <img src='View/images/{$_GET['order']}.gif' style='margin-bottom:1px'/>" : '';
		
		?>
		<th width="25"><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=file_type&order=<?php echo $_GET['orderby'] == 'file_type' ? $order : 'asc';?>">类型
		<?php echo $_GET['orderby'] == 'file_type' ? $order_img : '' ?></a></th>
		<th width="345"><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=dirfilename&order=<?php echo $_GET['orderby'] == 'dirfilename' ? $order : 'asc';?>">文件名
		<?php echo $_GET['orderby'] == 'dirfilename' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=size&order=<?php echo $_GET['orderby'] == 'size' ? $order : 'asc';?>">大小
		<?php echo $_GET['orderby'] == 'size' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=owner&order=<?php echo $_GET['orderby'] == 'owner' ? $order : 'asc';?>">用户ID
		<?php echo $_GET['orderby'] == 'owner' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=group&order=<?php echo $_GET['orderby'] == 'group' ? $order : 'asc';?>">用户名
		<?php echo $_GET['orderby'] == 'group' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=permissions_number&order=<?php echo $_GET['orderby'] == 'permissions_number' ? $order : 'asc';?>">权限
		<?php echo $_GET['orderby'] == 'permissions_number' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=charset&order=<?php echo $_GET['orderby'] == 'charset' ? $order : 'asc';?>">名称编码
		<?php echo $_GET['orderby'] == 'charset' ? $order_img : '' ?></a></th>
		<th><a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?>&orderby=mtime&order=<?php echo $_GET['orderby'] == 'mtime' ? $order : 'asc';?>">修改时间 
		<?php echo $_GET['orderby'] == 'mtime' ? $order_img : '' ?></a></th></tr>
		<tr> <td> </td> <td>Dir </td> 
		<td><img src="View/images/u.gif" class="file_type"/> <a href="./index.php?pwd=<?php echo $back_amftp_am_ftp_pwd;?>/">上级目录</a> </td> 
		<td></td> <td></td> <td></td> <td></td> <td></td> </tr>
		<?php
			$_i=$tr_i=0;
			foreach ($am_ftp_rawlist as $key=>$val)
			{
		?>
				<tr class="<?php $tr_i++;echo ($tr_i % 2 == 0) ? 'tr' : 'tr row';?>">
				<td>
				<input type="checkbox"  class="select_item" name="select_item[<?php echo $val['dirorfile'];?>][<?php echo $_i;?>]" value="<?php echo $amftp_am_ftp_pwd;?><?php echo $val['dirfilename'];?>" />
				<input type="hidden" name="charset_item[<?php echo $val['dirorfile'];?>][<?php echo $_i;?>]" value="<?php echo $val['charset'];?>" />
				<input type="hidden" name="can_open[<?php echo $val['dirorfile'];?>][<?php echo $_i;?>]" value="<?php echo $val['can_open'];?>" />
				<input type="hidden" name="permissions_number[<?php echo $val['dirorfile'];?>][<?php echo $_i;?>]" value="<?php echo $val['permissions_number'];?>" />
				</td>
				<td>
				<?php echo ($val['dirorfile'] == 'd') ? 'Dir' : $val['file_type'];?>
				</td>
				<td>
				<?php if($val['dirorfile'] == 'd') { ?>
					
					<img src="View/images/ico/<?php echo $val['ico'];?>" class="file_type"/> 
					<font class="file_name">
						<a href="./index.php?pwd=<?php echo $amftp_am_ftp_pwd;?><?php echo $val['dirfilename'];?>/" name="<?php echo (htmlspecialchars_decode($val['dirfilename']));?>"><?php echo $val['dirfilename'];?></a>
					</font>
					<a href="" class="action action_ico delete" title="删除" name="delete"></a>
					<a href="" class="action action_ico rename" title="重命名" name="rename" ></a>
				<?php }else {?>
					
					<img src="View/images/ico/<?php echo $val['ico'];?>" class="file_type"/> 
					<font class="file_name">
						<a href="./index.php?a=file_edit&charset=<?php echo $val['charset'];?>&pwd=<?php echo $amftp_am_ftp_pwd;?>&file=<?php echo (htmlspecialchars_decode($val['dirfilename']));?>" name="<?php echo $val['dirfilename'];?>" class="file" ><?php echo $val['dirfilename'];?></a>
					</font>
					<a href="" class="action action action_ico delete" title="删除" name="delete" ></a>
					<a href="" class="action action_ico download" title="下载" name="download" ></a>
					<a href="" class="action action_ico rename" title="重命名" name="rename" ></a>
					<a href="" class="action action_ico edit" title="阅读/编辑" name="edit" ></a>
				<?php } ?>
				</td>
				<td><?php echo $val['size_text'];?></td>
				<td><?php echo $val['owner'];?></td>
				<td><?php echo $val['group'];?></td>
				<td><span style="color:#ADADAD"><?php echo $val['permissions_number'];?></span> &nbsp;<?php echo $val['permissions'];?></td>
				<td><?php echo $val['charset'];?></td>
				<td><?php echo $val['mtime'];?></td>
				</tr>
		<?php
			++$_i;
			}
		?>
		</table>
			<div class="title">
				<input type="checkbox" onclick="all_select(this);" id="all_select_dom"/>
				<label style="color:#3366CC" href="javascript:;" for="all_select_dom">总<?php echo is_array($am_ftp_rawlist) ? count($am_ftp_rawlist) : 0;?></label> &nbsp;&nbsp; 
				<input type="button" id="del_file_sub" name="delete" value="删除" onclick="submit_change_notice='确认删除选择项吗?';need_select_notice=1;"  class="input_button" onmouseover="change_submit(this.id);this.focus();"/>  ┊ 
				<input type="button"  value="移动" id="move_button" onclick="move_file(this);" class="input_button"/> ┊ 
				<input type="button"  value="复制" id="copy_button" onclick="copy_file(this);" class="input_button"/> ┊ 
				<input type="button" value="设置权限" id="permissions_button" onclick="permissions_file(this);" class="input_button"/>  ┊ 
				<input type="button" value="新建" id="new_button" onclick="new_file(this);" class="input_button"/>  ┊ 
				压缩类型: 
				<span class="select_text " style="width:60px;border-radius:3px;height:22px;margin: 0px 2px -8px 8px;margin-bottom: -8px;">
				<span class="hidden_border" style="">
				<select name="zip_type"style="width:50px;margin-top:3px;">
				<option value="zip">zip</option>
				<option value="tar">tar</option>
				<option value="tar.gz">tar.gz</option>
				</select>
				</span>
				</span>
				<input type="button" id="zip_file_sub" name="zip" value="压缩" onclick="submit_change_notice='';need_select_notice=1;"  class="input_button" onmouseover="change_submit(this.id);this.focus();" />  ┊ 
				<input type="button" id="unzip_file_sub" name="unzip" value="智能解压" onclick="submit_change_notice='';need_select_notice=1;"  class="input_button" onmouseover="change_submit(this.id);this.focus();" />  ┊ 
				<input type="button"  value="远程上传" id="remote_download_button" onclick="remote_download(this);" class="input_button"/>  ┊ 
				<input type="button" value="本地上传" onclick="upload_file(this);"  class="input_button"/>
			
				<span id="upload_block" >
					<div id="uploader" class="wu-example">
				    <div class="btns">
				    	请选择文件
				        <span id="picker">极速上传</span>  <input type="checkbox" checked="" id="continued_dom">  <label for="continued_dom">断点续传</label>  
				    </div>
					</div>
				</span>
			</div>
		<input type="hidden" name="" id="hidden_submit"/>
	</div>


		<div id="move_block" class="block" onmouseover="change_submit('move_file_sub')">
			<div>
			<p style="margin:5px 0px"> » 移动到 </p> 
			<input type="text" value="<?php echo $amftp_am_ftp_pwd;?>" name="move_pwd" id="move_pwd" class="input_text" style="width:355px"/>
			<input type="button" id="move_file_sub" name="move" value="确定" class="input_button" onclick="submit_change_notice='确认移动选择项吗?';need_select_notice=1;"/> <input type="button" value="取消" onclick="move_cancel();" class="input_button"/>
			</div>
			<div id="move_show_dir_dom" class="show_dir_dom">
			</div>
			<br />
			<br />
		</div>
		<div id="copy_block" class="block" style="display:none;margin:10px 0px;" onmouseover="change_submit('copy_file_sub')">
			<div>
			<p style="margin:5px 0px"> » 复制到</p> 
			<input type="text" value="<?php echo $amftp_am_ftp_pwd;?>" name="copy_pwd" id="copy_pwd" class="input_text" style="width:455px"/>
			<input type="button" id="copy_file_sub" name="copy" value="确定" class="input_button" onclick="submit_change_notice='确认复制选择项吗?';need_select_notice=1;"/> <input type="button" value="取消" onclick="copy_cancel();" class="input_button"/>
			</div>
			<div id="copy_show_dir_dom" class="show_dir_dom">
			</div>
			<br />
			<br />
		</div>
		<div id="permissions_block" class="block" onmouseover="change_submit('per_file_sub')">
			<p style="margin:13px 0px;"> » 更改文件权限 ( 普通权限 <a id="pv_all_select" href="">全选</a> / <a id="pv_all_unselect" href="">全不选</a> )</p>
			<table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#DFDFDF">
			<tr><th bgcolor="#F0F4F7">所有者</th>
			<th bgcolor="#F0F4F7">组</th>
			<th bgcolor="#F0F4F7">公共</th>
			</tr>
			<tr>
			  <td bgcolor="#F6F6F6"><input type="checkbox" id="sr" class="pv_item" value="4000" /> <label for="sr">设置UID</label></td>
				<td bgcolor="#F6F6F6"><input type="checkbox" id="sw" class="pv_item" value="2000"/> <label for="sw">设置GID</label></td>
				<td bgcolor="#F6F6F6"><input type="checkbox" id="sx" class="pv_item" value="1000"/> <label for="sx">粘性</label></td>
			</tr>
			<tr>
			  <td bgcolor="#FFFFFF"><input type="checkbox" id="ur" class="pv_item" value="400"/> <label for="ur">读取</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="gr" class="pv_item" value="40"/> <label for="gr">读取</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="pr" class="pv_item" value="4"/> <label for="pr">读取</label></td>
			</tr>
			<tr>
			  <td bgcolor="#FFFFFF"><input type="checkbox" id="uw" class="pv_item" value="200"/> <label for="uw">写入</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="gw" class="pv_item" value="20"/> <label for="gw">写入</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="pw" class="pv_item" value="2"/> <label for="pw">写入</label></td>
			</tr>
			<tr>
			  <td bgcolor="#FFFFFF"><input type="checkbox" id="ux" class="pv_item" value="100"/> <label for="ux">执行</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="gx" class="pv_item" value="10"/> <label for="gx">执行</label></td>
				<td bgcolor="#FFFFFF"><input type="checkbox" id="px" class="pv_item" value="1"/> <label for="px">执行</label></td>
			</tr>
			</table>
			<p><input type="checkbox" id="recursion" name="recursion" /> <label for="recursion">同时应用到所有子目录和文件</label></p>
			<p>权限值：<input type="txt" id="permissions_val" name="permissions_val" class="input_text" style="width:100px;" /> </label></p>
			<p><input type="button" id="per_file_sub" name="permissions" value="确定" class="input_button" onclick="submit_change_notice='确认改变选择项的权限吗?';need_select_notice=1;"/> 
			<input type="button" value="取消" onclick="permissions_cancel();" class="input_button"/>
			</p>
		</div>

		<div id="new_block" class="block" onmouseover="change_submit('new_file_sub')">
			<p style="margin:5px 0px"> » 新建类型 <input type="radio" name="new_type" checked="" value="file" id="new_type_file" /><label for="new_type_file">文件</label>
			<input type="radio" name="new_type" value="dir" id="new_type_dir"  /><label for="new_type_dir">目录</label>
			</p> 
			<br />
			名称: <input type="text" value="" name="new_name" id="new_name" class="input_text" style="width:155px"/>
			<input type="button" id="new_file_sub" name="new" value="确定" class="input_button" onclick="submit_change_notice='';need_select_notice=0;" /> <input type="button" value="取消" onclick="new_cancel();" class="input_button"/>
			<br />
			<br />
		</div>

		<div id="remote_download_block" class="block" onmouseover="change_submit('rd_file_sub')">
			<p style="margin:5px 0px"> » 请填写远程文件网址 ( 保存远程文件到当前目录 )</p> 
			<input type="text" value="" name="remote_file" id="remote_file" class="input_text" style="width:505px"/>
			<input type="button" id="rd_file_sub" name="remote_down" value="确定" class="input_button" onclick="submit_change_notice='确认下载保存到当前目录吗?';need_select_notice=0;"/> <input type="button" value="取消" onclick="remote_download_cancel();" class="input_button"/>
			<br />
			<br />
		</div>
		<div id="amfile_uplist" class="uploader-list"></div>
		<div id="amfile_upload_complete" class="uploader-list"></div>
	</form>

	
	<div id="_progressTarget" style=""></div>
	<div id="_progressGroupTarget" style="margin:5px 0px;"></div>
	<div id="_ReturnActionId"></div>
</div>


<?php include('amftp_footer.php');?>