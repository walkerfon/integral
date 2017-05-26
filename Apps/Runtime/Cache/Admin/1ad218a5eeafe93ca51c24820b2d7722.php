<?php if (!defined('THINK_PATH')) exit();?><meta charset="utf-8">
   <script>
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			}});
	   $("#loginPwd").formValidator({
			onShow:"登录密码长度应该为6-20位之间",onFocus:"登录密码长度应该为6-20位之间"
			}).inputValidator({
				min:6,max:20,onError:"登录密码长度应该为6-20位之间"
			}).unFormValidator(true);
		$("#loginPwd").blur(function(){
			  if($("#loginPwd").val()==''){
				  $("#loginPwd").unFormValidator(true);
			  }else{
				  $("#loginPwd").unFormValidator(false);
			  }
		});
   });
   function edit(){
	   var params = {};
	   params.loginPwd = $.trim($('#loginPwd').val());
	   params.userStatus = $('input[name="userStatus"]:checked').val();
	   params.id = $('#id').val();
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
		$.post("<?php echo U('Admin/Users/editAccount');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				    location.href='<?php echo U("Admin/Users/queryAccountByPage");?>';
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
   }
   </script>
       <form name="myform" method="post" id="myform" autocomplete="off">
        <input type='hidden' id='id' value='<?php echo ($object["userId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='100' align='right'>账号：</th>
             <td><?php echo ($object["loginName"]); ?></td>
           </tr>
           <tr>
             <th width='120' align='right'>密码<font color='red'>*</font>：</th>
             <td>
             <input type='password' id='loginPwd' class="form-control wst-ipt-10" value='<?php echo ($object["loginPwd"]); ?>' maxLength='20'/>
             <?php if($object['userId'] !=0 ): ?>(为空则说明不修改密码)<?php endif; ?></td>
           </tr>  
            <tr>
             <th align='right'>会员状态<font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='userStatus1' value='1' name='userStatus' <?php if($object['userStatus']==1): ?>checked<?php endif; ?>/>启用
             </label>
             <label>
             <input type='radio' id='userStatus0' value='0' name='userStatus' <?php if($object['userStatus']==0): ?>checked<?php endif; ?>/>停用
             </label>
             </td>
           </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" data-dismiss="modal">返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>