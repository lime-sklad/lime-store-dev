<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/function/user.function.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/function/db.dump.php';

$db_dump_config = db_dump_config();
    make_db_dump();


ls_add_zip_archive($path_to_dir = $db_dump_config['get_db_backup_dir'], $file_name = $db_dump_config['get_db_auto_name'].'.sql');

$backup_file = $db_dump_config['get_db_backup_dir'].$db_dump_config['get_db_auto_name'].'.sql.zip';

$token = '323030333639363632373a414148557a67433454476b4b4b783267753076347159594f63785955467134525f534d';

$date = date("d.m.Y");

$arrayQuery = array(
    'chat_id' => -1001986338105,
    'caption' => getUser('get_name') . "\n$date",
    'document' => curl_file_create($backup_file, 'text/plain' , basename($backup_file))
);		

$ch = curl_init('https://api.telegram.org/bot'. hex2bin($token) .'/sendDocument');


curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
