<?php
$db_dbtype		= 'database type';
$db_dbhost		= 'database server address';
$db_dbname		= 'database name';
$db_username	= 'database username';
$db_password	= 'database password';

$as_server		= 'Asterisk server address';
$as_port		= 'Asterisk AMI port, it\'s 5038 by default';
$as_username	= 'AMI username';
$as_secret		= 'AMI password';
$as_monitorpath		= 'the path recording file will store, the fils will store on Asterisk server not asterCRM server';
$as_monitorformat	= 'format of the record file';

$sys_log_enabled	= 'if enable astercrm log';
$sys_log_file_path	= 'file path of the log file';
$sys_outcontext		= 'when agent dial external number in asterCRM, which context in Asterisk it would use';
$sys_incontext		= 'when agent dial internal number in asterCRM, which context in Asterisk it would use';
$sys_predialer_context		= 'when using predictive dialer, if connected use which context to handel the call';
$sys_predialer_extension	= 'when using predictive dialer, if connected use which extension in the context to handel the call';
$sys_phone_number_length	= 'asterCRM wouldnot pop-up unless the length of callerid is greater than this number';
$sys_trim_prefix			= 'if asterCRM trim will remove prefix, use gamma to sperate,leave it blank if no prefix need to be removed';
$sys_allow_dropcall			= 'if asterCRM will generate a .call file to originate a call, select 0 if your asterCRM is not on the same machine with Asterisk then asterCRM will originate a call via AMI';
$sys_portal_display_type	= 'which information will be displayed in agent\'s inteface, if "customer", it would display all customer information the agent added, if "note" it would only display the customer who has a note record added by this agent';
$sys_enable_contact			= 'if asterCRM enable contact in agent interface';
$sys_pop_up_when_dial_out	= 'if asterCRM pop up when agent dial out';
$sys_pop_up_when_dial_in	= 'if asterCRM pop up when there\'s incoming call';
$sys_allow_same_data		= 'if allow same customer name';
$sys_browser_maximize_when_pop_up	= 'if browser will maximize when pop up';
$sys_firstring				= 'caller ring first or callee ring first';
$sys_enable_external_crm	= 'if asterCRM use external CRM software';
$sys_open_new_window		= 'if asterCRM open a new browser window when popup';
$sys_external_crm_default_url = 'when using external CRM, the default page to be displayed';
$sys_external_crm_url		= 'when asterCRM need to pop up, which url would recevie the event,  %callerid: %calleeid:  %method	dialout or dialin';
$sys_upload_file_path		= 'the upload directory, such as "./upload/", it need a writable permission, ';
$save_success				= 'Save success';
$db_connect_failed			= 'database connection test failed, please check the parameters';
$db_connect_success			= 'database connection test passed';
$AMI_connect_failed			= 'AMI connection test failed, please check the parameters';
$AMI_connect_success		= 'AMI connection test passed';
$permission_error			= 'directory permission error';
$sys_check_success			= 'parameters check pass';
?>