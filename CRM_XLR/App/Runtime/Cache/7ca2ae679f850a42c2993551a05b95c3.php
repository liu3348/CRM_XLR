<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" src="__PUBLIC__/js/formValidator-4.0.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="__PUBLIC__/js/formValidatorRegex.js" charset="UTF-8"></script>
<form class="form-horizontal" action="<?php echo U('setting/fieldedit');?>" method="post" name="form1" id="form1">	
	<input type="hidden" name="field_id" value="<?php echo ($fields["field_id"]); ?>"/>
	<table class="table">
		<tr>
			<th colspan="2"><i class="icon-edit">&nbsp; <?php echo L('FIELDS_INFORMATION');?></i></th>
		</tr>
		<tr>
			<td width="30%" class="tdleft"><?php echo L('FIELDS_NAMES');?></td>
			<td><?php echo ($fields["name"]); ?></td>
		<tr>
        <tr>
			<td width="30%" class="tdleft"><?php echo L('FIELDS_TYPE');?>：</td>
			<td><?php echo ($fields["form_type_name"]); ?></td>
		<tr>
			<td width="30%" class="tdleft"><?php echo L('WEATHER_INFORMATION');?></td>
			<td class="span3"><?php if($fields["is_main"] == 1): echo L('MIAN_INFO'); else: echo L('EXTRA_INFO'); endif; ?></td>
		</tr>
		<?php if($fields['form_type'] == 'box'): ?><tr id="box_type_td" style="">
			<td class="tdleft" width="30%"><?php echo L('OPTION_TYPE');?></td>
			<td><?php if($fields['setting']['type'] == 'radio'): echo L('RADIO'); endif; ?>
			<?php if($fields['setting']['type'] == 'checkbox'): echo L('MULTISELECT'); endif; ?>
			<?php if($fields['setting']['type'] == 'select'): echo L('COMBOBOX'); endif; ?></td>
		</tr>
		<tr id="box_data_td">
			<td width="30%" class="tdleft"><?php echo L('LIST_OF_OPTIONS');?></td>
			<td>
				<textarea name="setting[options]"><?php echo ($fields["setting"]["options"]); ?></textarea>
				<br /><span style="color:red;">*</span><?php echo L('INPUT_OPTION_VALUE');?><br/><?php echo L('OPTION1');?><br/><?php echo L('OPTION2');?>
			</td>
		</tr><?php endif; ?>
		<tr id='field_td'>
			<td width="30%" class="tdleft"><?php echo L('FIELDS_NAME');?>：</td>
			<td><?php if($fields['operating'] == 0): ?><input type="text" id="field" name="field" class="span3" value="<?php echo ($fields["field"]); ?>"/><?php else: echo ($fields["field"]); endif; ?></td>
		</tr>
		<tr id="name_td">
			<td width="30%" class="tdleft"><?php echo L('ID_NAME');?></td>
			<td><input type="text" id="name" name="name" class="span3" value="<?php echo ($fields["name"]); ?>"/><br/><span style="color:red;">*</span><span id="nameTip"></span></td>
		</tr> 
		<tr id="max_length_td">
			<td width="30%" class="tdleft"><?php echo L('THE_LARGEST_FIELD_LENGTH');?></td>
			<td><input type="text" name="max_length" class="span3" id="max_length" value="<?php if($fields['max_length'] > 0): echo ($fields["max_length"]); endif; ?>"/>
			<br /><span style="color:red;">*</span><?php echo L('EDITING_THE_LENGTH_OF_THE_SMALLE');?><br /><span id="max_lengthTip"></span></td>
		</tr>
        <?php if($fields['form_type'] != 'box' && $fields['form_type'] != 'textarea'&& $fields['form_type'] != 'editor' && $fields['form_type'] != 'address' && $fields['form_type'] != 'datetime' ): ?><tr id="default_value_td">
			<td width="30%" class="tdleft"><?php echo L('DEFAULT_VALUE');?></td>
			<td><input type="text" name="default_value" id="default_value" class="span3" value="<?php echo ($fields["default_value"]); ?>"/><br /><span id="default_valueTip"></span></td>
		</tr><?php endif; ?>
		<tr id="color_td">
			<td width="30%" class="tdleft"><?php echo L('COLOR');?></td>
			<td><input class="color" name="color" value="<?php echo (($fields["color"])?($fields["color"]):"333333"); ?>" /></td>
		</tr>
        <tr id="is_validate_td">
			<td width="30%" class="tdleft"><?php echo L('WHETHER_THE_VALIDATION');?></td>
			<td>
				<input name="is_validate" onclick="validateSwitch(1)" <?php if($fields["is_validate"] == 1): ?>checked="checked"<?php endif; ?> type="radio" value="1"/> <?php echo L('IS');?> &nbsp; &nbsp; <input name="is_validate" onclick="validateSwitch(0)" <?php if($fields["is_validate"] != 1): ?>checked="checked"<?php endif; ?>  type="radio" value="0"/> <?php echo L('ISNOT');?>
			</td>
		</tr>
		<tr id="is_unique_td" <?php if(!$fields['is_validate']): ?>style="display:none;"<?php endif; ?>>
			<td width="30%" class="tdleft"><?php echo L('WHETHER_ONLY');?></td>
			<td>
				<input name="is_unique" <?php if($fields["is_unique"] == 1): ?>checked="checked"<?php endif; ?> type="radio" value="1"/> <?php echo L('IS');?> &nbsp; &nbsp; <input name="is_unique"  <?php if($fields["is_unique"] != 1): ?>checked="checked"<?php endif; ?> type="radio" value="0"/> <?php echo L('ISNOT');?>
			</td>
		</tr>
		<tr id="is_null_td" <?php if(!$fields['is_validate']): ?>style="display:none;"<?php endif; ?>>
			<td width="30%" class="tdleft"><?php echo L('WHETHER_ALLOW_NULL');?></td>
			<td>
				<input name="is_null" <?php if($fields["is_null"] != 1): ?>checked="checked"<?php endif; ?> type="radio" value="0"/> <?php echo L('IS');?> &nbsp; &nbsp; <input name="is_null" <?php if($fields["is_null"] == 1): ?>checked="checked"<?php endif; ?> type="radio" value="1"/> <?php echo L('ISNOT');?>
			</td>
		</tr>
		
		<tr id="in_index_td">
			<td width="30%" class="tdleft"><?php echo L('LIST_PAGE_DISPLAY');?></td>
			<td>
				<input name="in_index" <?php if($fields["in_index"] == 1): ?>checked="checked"<?php endif; ?> type="radio" value="1"/> <?php echo L('IS');?> &nbsp; &nbsp; <input name="in_index"  <?php if($fields["in_index"] != 1): ?>checked="checked"<?php endif; ?> type="radio" value="0"/> <?php echo L('ISNOT');?>
			</td>
		</tr>
		<tr id="in_index_td">
			<td width="30%" class="tdleft"><?php echo L('ADD_PAGE_DISPLAY');?></td>
			<td>
				<input name="in_add" <?php if($fields["in_add"] == 1): ?>checked="checked"<?php endif; ?> type="radio" value="1"/> <?php echo L('IS');?> &nbsp; &nbsp; <input name="in_add"  <?php if($fields["in_add"] != 1): ?>checked="checked"<?php endif; ?> type="radio" value="0"/> <?php echo L('ISNOT');?>
			</td>
		</tr>
		<tr id="tips_td">
			<td width="30%" class="tdleft"><?php echo L('INPUT_PROMPT');?></td>
			<td><input type="text" name="input_tips" class="span3" value="<?php echo ($fields["input_tips"]); ?>"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input class="btn btn-primary" type="submit" value="<?php echo L('SAVE');?>"/> &nbsp;
			<input class="btn" type="button" onclick="javascript:$('#dialog_field_edit').dialog('close');" value="<?php echo L('CANCEL');?>"/></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$(function(){
        jscolor.bind();
        $.formValidator.initConfig({formID:"form1",debug:false,submitOnce:true,
            onError:function(msg,obj,errorlist){
                $("#errorlist").empty();
                $.map(errorlist,function(msg){
                    $("#errorlist").append("<li>" + msg + "</li>")
                });
                alert(msg);
            },
            submitAfterAjaxPrompt : '<?php echo L('AJAX_VALIDATING_PLEASE_WAIT');?>'
        });
        $("#name").formValidator({
			tipID:"nameTip",
			empty:false,
			onShow:"<?php echo L('FOR_EXAMPLE_THE_ARTICLE_TITLE');?>",
			onFocus:"<?php echo L('PLEASE_ENTER_A_NAME');?>",
			onCorrect:"√"
		}).inputValidator({
			min:1,
			empty:{
				leftEmpty:false,
				rightEmpty:false,
				emptyError:"<?php echo L('BOTH_SIDES_ARE_NOT_FREE');?>"
			},
			onError:":<?php echo L('LABEL_NAME_CANNOT_BE_EMPTY');?>"
		});
        <?php if($fields['operating'] == 0): ?>$("#field").formValidator({
			tipID:"fieldTip",
			empty:false,
			onShow:"<?php echo L('CAN_ONLY_CONSIST_OF_LOWERCASE_ENGLISH');?>",
			onFocus:"<?php echo L('CAN_ONLY_CONSIST_OF_ENGLISH');?>",
			onCorrect:"√"
		}).inputValidator({
			min:1,
			empty:{
				leftEmpty:false,
				rightEmpty:false,
				emptyError:"<?php echo L('BOTH_SIDES_ARE_NOT_FREE');?>"
			},
			onError:"<?php echo L('LABEL_NAME_CANNOT_BE_EMPTY');?>"
		}).regexValidator({
			regExp:"field",param:'i',
			dataType:"enum",
			onError:"<?php echo L('ONLY_CONSIST_OF_LOWERCASE_ENGLISH');?>"});<?php endif; ?>
		type_id = '<?php echo ($fields["form_type"]); ?>';
		if(type_id == 'box'){
			$("#max_length").hide();
			$("#default_value").hide();
			$("#is_unique").hide();
		}else if(type_id == 'textarea'){
			$("#box_data").hide();
			$("#box_type").hide();
			$("#is_unique").hide();
		}else if(type_id == 'datetime'){
			$("#box_data").hide();
			$("#box_type").hide();
			$("#default_value").show();
			$("#is_unique").hide();
			$("#max_length").hide();
		}else if(type_id == 'editor'){
			$("#box_data").hide();
			$("#box_type").hide();
			$("#default_value").hide();
			$("#is_unique").hide();
			$("#max_length").hide();
		}else if(type_id == 'address'){
			$("#box_data").hide();
			$("#box_type").hide();
			$("#default_value").hide();
			$("#is_unique").hide();
			$("#max_length").hide();
			$("#max_length").hide();
		}else{
			$("#box_data").hide();
			$("#box_type").hide();
		}
        <?php if($fields['form_type'] == 'text' ): ?>$("#max_length").formValidator({tipID:"max_lengthTip",empty:true,onEmpty:'',onShow:" ",onFocus:" ",onCorrect:"√"}).regexValidator({regExp:"intege1",param:'i',dataType:"enum",onError:"{:L('ONLY_FILL_IN_POSITIVE_INTEGER')}"}).inputValidator({max:1000,type:"value",onError:"{:L('MUST_BE_BETWEEN_1_1000')}"});
        <?php elseif($fields['form_type'] == 'number' ): ?>
        $("#default_value").formValidator({tipID:"default_valueTip",empty:true,onEmpty:'',onShow:" ",onFocus:" ",onCorrect:"√"}).regexValidator({regExp:"intege1",param:'i',dataType:"enum",onError:"{:L('ONLY_FILL_IN_POSITIVE_INTEGER')}"}).inputValidator({min:-2147483647,max:2147483647,type:"value",onError:"{:L('MUST_BE_BETWEEN')}"});
        $("#max_length").formValidator({tipID:"max_lengthTip",empty:true,onEmpty:'',onShow:" ",onFocus:" ",onCorrect:"√"}).regexValidator({regExp:"intege1",param:'i',dataType:"enum",onError:"{:L('ONLY_FILL_IN_POSITIVE_INTEGER')}"}).inputValidator({max:11,type:"value",onError:"{:L('MUST_BE_BETWEEN_1_11')}"});<?php endif; ?>
	});
	
    function validateSwitch(set_val){
		//1为开启验证，0为关闭验证
		if(1 == set_val){
			$('#is_unique_td').show();
			$('#is_null_td').show();
			//开启后设置默值认为不验证‘是否唯一’和‘是否允许为空’
			$("input[name=is_unique]").last().prop('checked','true');
			$("input[name=is_null]").first().prop('checked','true');
		}else{
			//如果选择不验证，则设置‘是否唯一’和‘是否允许为空’的值为不验证
			$("input[name=is_validate]").last().prop('checked','true');
			$("input[name=is_unique]").last().prop('checked','true');
			$("input[name=is_null]").first().prop('checked','true');
			$('#is_unique_td').hide();
			$('#is_null_td').hide();
		}
	}
</script>