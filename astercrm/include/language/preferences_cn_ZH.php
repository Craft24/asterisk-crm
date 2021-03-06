<?php
$database		= '数据库';
$db_dbtype		= '数据库类型';
$db_dbhost		= '数据库主机地址';
$db_dbname		= '数据库名称';
$db_username	= '数据库用户名';
$db_password	= '数据库密码';

$as_server		= '默认Asterisk服务器地址';
$as_port		= '默认Asterisk服务器AMI端口号, 默认情况下是5038';
$as_username	= '默认AMI用户名';
$as_secret		= '默认AMI密码';
$as_monitorpath		= '录音文件保存的路径, 录音文件将会保存在Asterisk服务器上而不是asterCRM服务器';
$as_monitorformat	= '录音文件的文件格式';

$system	= '系统';
$sys_log_enabled	= '是否启动日志';
$sys_log_file_path	= '日志文件的路径';
$sys_outcontext		= '座席通过asterCRM拨外线号码时使用的asterisk context';
$sys_incontext		= '座席通过asterCRM拨内线号码时使用的asterisk context';
$sys_predialer_context		= '使用预拨号时, 当目标号码被接通后, 连接到哪个context';
$sys_predialer_extension	= '使用预拨号时, 当目标号码被接通后, 连接到context的哪个extension';
$sys_phone_number_length	= '只有当拨入/拨出号码大于此数时, asterCRM才会弹屏';
$sys_trim_prefix			= '需要从拨入/拨出号码中去除的前缀, 使用逗号分隔, 如果没有前缀需要去除, 可以什么都不填写';
$sys_allow_dropcall			= '是否通过生成.call文件的方法发起呼叫, 如果asterCRM和Asterisk不在否则请选择0';
$sys_portal_display_type	= '座席界面显示的客户信息类型, 选择customer将会显示该座席添加过的所有客户, 选择note将只显示添加过备注信息的客户';
$sys_enable_contact			= '是否在坐席界面启用联系人';
$sys_pop_up_when_dial_out	= '座席电话拨出时asterCRM是否弹屏';
$sys_pop_up_when_dial_in	= '座席电话有拨入时asterCRM是否弹屏';
$sys_allow_same_data		= '是否允许重复的客户名称';
$sys_browser_maximize_when_pop_up	= '弹屏时是否浏览器最大化';
$sys_firstring				= '呼叫时先呼叫主叫号码还是先呼叫被叫号码';
$sys_enable_external_crm	= '是否使用第三方CRM';
$sys_open_new_window		= '如果使用第三方CRM,怎样显示弹屏.internal 表示在内部iframe弹出屏,external 表示新弹出一个窗口显示弹屏,both 表示在内部iframe里显示,同时也新弹出一个窗口显示弹屏';

$sys_external_crm_default_url = '当使用第三方CRM时, 默认启动的页面';
$sys_external_crm_url		= '当有弹屏事件发生时, 要调用的外部CRM页面, %callerid: 主叫号码, %calleeid: 被叫号码, %method	拨出(dialout)或者拨入(dialin)';
$sys_upload_file_path		= '上传文件的路径, 如 ./upload/ , 此目录需要有写权限';

$external_crm = '外部CRM';
$others = '其他';

$save_success				= '保存成功';
$save_failed				= '保存失败, 请检查配置文件权限';
$db_connect_failed			= '数据库连接失败, 请检查系统配置';
$db_connect_success			= '数据库连接成功';
$AMI_connect_failed			= 'AMI连接失败, 请检查系统配置';
$AMI_connect_success		= 'AMI连接成功';
$permission_error			= '目录权限错误';
$upload_folder_writable			= '上传路径可写';
$sys_eventtype				= '设置使用astercc或是eventdaemon模式捕获呼叫事件';
$sys_stop_work_verify		= '设置坐席停止工作时是否需要输入密码(组管理员或高级管理员帐号/密码)';
$astercc_path			= 'astercc 后台程序路径';
$update_licence_success	= '许可已更新,必须重新启动服务器,新的许可才会生效';
$astercc_conf_non		= 'astercc.conf 不存在于指定的目录中:';
$astercc_non		= 'astercc 程序不存在于指定的目录中:';
$click_ok_to_update_your_astercc_license = "点击确定以更新您的使用许可";
$update_licence = "更新使用许可";
$licence = "使用许可";
$save = "保存";
$read_group_database_or_system_database = "读取本组信息或是所有信息";
$status_check_interval	= '页面更新事件的间隔时间(秒)';
$smart_match_remove	= '来电号码智能匹配时,去除号码未尾数字的位数';
$check = "测试";
$set_multi_servers = "设置多服务器";
$are_you_sure_to = "您确定要";
$reload = "重载asterisk";
$restart = "重启asterisk";
$reboot = "重启astercc box";
$shutdown = "关闭astercc box";
$asterisk_have_been_reloaded = "重载asterisk完毕";
$asterisk_have_been_restart = "重启asterisk完毕";
$server_is_rebooting = "服务器正在重启";
$server_is_shuting_down = "服务器正在关机";
$sys_agent_pannel_setting = "控制座席页各面板默认是否显示";
$survey = '问卷';
$enable_surveynote = '启用问卷备注';
$close_popup_after_survey = '问卷添加后,关闭弹出信息';
$popup_diallist = '弹出拨号列表相关信息';
$diallist = '拨号列表';
$if_auto_popup_note_info = '控制弹屏时是否自动弹出note信息';
$if_share_note_default = '控制添加note信息时，默认是否为共享';
$if_enable_code = '是否启用code';
$the_smaller_the_value_the_more_accurate = "数值越小越精准";
$require_reason_when_pause = '如果设置成yes,当坐席点击暂停的时候会弹出一个弹屏要求输入暂停原因,如果设置成no,就不会弹出这个弹屏';
$create_ticket = '如果设置成default,系统管理员可以给所有人增加ticket,组管理员只能给本组人添加ticket,坐席只能给自己添加ticket.如果设置成system,可以给任意人添加ticket.如果设置成group,只能给本组人添加ticket';
$enable_socket = "如果启用socket,当来电时就会通过socket通知坐席";
$fix_port = "固定端口";
$socket_url = "socket字符串";
$export_customer_fields_in_dialedlist = "导出已拨列表数据的时候关联导出客户相关字段";
$allow_popup_when_already_popup = "客户弹屏存在是否重新弹出客户窗口";
$enable_formadd_popup = "是否启用添加记录弹屏";
$if_popup_the_highest_priority_note_info = "是否弹出最高级别note";
$if_popup_the_lastest_priority_note_info = "是否弹出最新note";
?>
