<?php
/**
 * 下载 电子书
 */

require_once 'class.BookDown.php';

test();

$bookdown = new BookDown();
$books    = [
//	[
//		'book_name' => '',
//		'url_format' => '',
//		'token' => '',
//		'total' => 0,
//	],
//	[
//		'book_name' => 'Linux_C编成从基础到实践',
//		'url_format' => 'http://sxsjs.cahd.chineseall.cn/book/ossPageUrl/WIPLg/IMG/%d?token=%s',
//		'token' => '622s6HTZ40p8qFvs98aYIsZ6167Wm134',
//		'total' => 0,
//	],
//	[ // html
//		'book_name' => 'UNIX环境高级编程',
//		'url_format' => 'http://sxsjs.cahd.chineseall.cn/book/ossPageUrl/DVLlg/HTML/%d?token=%s',
//		'token' => '6lr16lC3d7Zw78o6vd4u2KH3N071jw0L',
//		'total' => 330,
//	],
	[
		'book_name' => 'Linux服务器配置与管理',
		'url_format' => 'http://sxsjs.cahd.chineseall.cn/book/ossPageUrl/9Igdg/IMG/%d?token=%s',
		'token' => 'W1YBTX6L2m05XZs98N38x7F8Zz0y5X8W',
		'total' => 344, // 138,338
		'pages' => [138,338]
	],
//	[
//		'book_name' => 'Linux操作系统',
//		'url_format' => 'http://sxsjs.cahd.chineseall.cn/book/ossPageUrl/JwRtg/IMG/%d?token=%s',
//		'token' => 'W1YBTX6L2m05XZs98N38x7F8Zz0y5X8W ',
//		'total' => 253,
//	],


];

foreach ($books as $book) {
	$pages = isset($book['pages']) ? $book['pages'] : [];
	$bookdown->downloadBook($book['book_name'], $book['url_format'], $book['token'], $book['total'], $pages);
}


function test()
{

//	$cmd = "id";
//	$rs = exec($cmd);
//	var_dump($rs);
//	exit;

}