<?php
/**
 * Class BookDown
 * 从西山图书馆下载电子书
 *
 *
 */

class BookDown
{
	private $save_path = "./book_down/down_imgs";
	private $book_path = "./book_down/books";
	private $book_name;
	private $total_len;

	public function __construct()
	{

	}

	private function getHeader()
	{
		return [
			"Host" => "sxsjs.cahd.chineseall.cn",
			"User-Agent: Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:94.0) Gecko/20100101 Firefox/94.0",
			"Accept: application/json, text/plain, */*",
			"Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
			"Accept-Encoding: gzip, deflate",
			"Referer: http://sxsjs.w.chineseall.cn/",
			"Origin: http://sxsjs.w.chineseall.cn",
			"Connection: keep-alive",
			"Pragma: no-cache",
			"Cache-Control: no-cache"
		];
	}

	private function getImgUrl($url, $header = [])
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$json = curl_exec($ch);
		if (!$json) {
			throw new Exception("get img url error: " . curl_error($ch));
		}
		curl_close($ch);

		$out_arr = json_decode($json, true);
		return empty($out_arr['result']['resourceUrl']) ? "" : $out_arr['result']['resourceUrl'];
	}

	private function getSavePath($num)
	{
		return sprintf($this->save_path . DIRECTORY_SEPARATOR . "%0" . $this->total_len . "s.jpg", $num);
	}

	private function downImg($img_url, $save_path)
	{
		if (!$img_url) {
			return "";
		}

		$con = file_get_contents($img_url);
		file_put_contents($save_path, $con);
	}

	private function make_pdf()
	{
		echo " >>> start to pdf " . PHP_EOL;
		$cmd = sprintf("convert %s/*.jpg %s/%s.pdf", $this->save_path, $this->book_path, $this->book_name);
		exec($cmd);
	}

	public function downloadBook($book_name, $url_format, $token, $total, $pages = [])
	{
		try {
			$this->total_len = strlen($total);
			$this->book_name = $book_name;
			$this->save_path .= DIRECTORY_SEPARATOR . $this->book_name;
			if (!file_exists($this->save_path)) {
				mkdir($this->save_path, 777, true);
			}

			echo " >>> start to download img" . PHP_EOL;
			$header = $this->getHeader();
			for ($num = 1; $num <= $total; $num++) {
				if (!$pages || !in_array($num, $pages)) {
					continue;
				}

				$url      = sprintf($url_format, $num, $token);
				$imgUrl   = $this->getImgUrl($url, $header);
				$savePath = $this->getSavePath($num);
				$this->downImg($imgUrl, $savePath);

				if (0 == $num % 10) {
					echo ".";
				}
				if (0 == $num % 100) {
					echo " done {$num}" . PHP_EOL;
				}
			}
			// 耗时太常，而且，没有生成目录结构
//			$this->make_pdf();

			echo PHP_EOL;
			echo " >>> done";

		} catch (Exception $e) {
			print_r($e);
		}

		return true;
	}
}