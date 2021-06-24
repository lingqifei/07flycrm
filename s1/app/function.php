<?php
/**
 * 零起飞-(07FLY-CRM)
 * ==============================================
 * 版权所有 2015-2028   成都零起飞网络，并保留所有权利。
 * 网站地址: http://www.07fly.xyz
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ==============================================
 * Author: kfrs <goodkfrs@QQ.com> 574249366
 * Date: 2019-10-3
 */

// 扩展函数文件，系统研发过程中需要的函数建议放在此处，与框架相关函数分离
/**
 * 时间计算函数
 * @param int $time
 * @param int $caclVal 增加、减少的值
 * @param int $type 计算时间类型
 * @return string 完整的时间显示
 */
function date_calc($time = null, $caclVal = "0", $type = "day", $format = 'Y-m-d')
{
    if (null === $time) {
        $time = TIME_NOW;
    }
    return date($format, strtotime(" $caclVal $type", strtotime($time)));

}

/**
 * 获取两个日期之间所有日期
 * @param int $startDate 开始时间
 * @param int $endDate 结束时间
 * @return string 完整的时间显示
 */
function getDatesBetweenTwoDays($startDate, $endDate)
{
    $dates = [];
    if (strtotime($startDate) > strtotime($endDate)) {
        //如果开始日期大于结束日期，直接return 防止下面的循环出现死循环
        return $dates;
    } elseif ($startDate == $endDate) {
        //开始日期与结束日期是同一天时
        array_push($dates, $startDate);
        return $dates;
    } else {
        array_push($dates, $startDate);
        $currentDate = $startDate;
        do {
            $nextDate = date('Y-m-d', strtotime($currentDate . ' +1 days'));
            array_push($dates, $nextDate);
            $currentDate = $nextDate;
        } while ($endDate != $currentDate);
        return $dates;
    }
}

/**
 * 时间计算函数
 * @param int $time
 * @param int $caclVal 增加、减少的值
 * @param int $type 计算时间类型
 * @return string 完整的时间显示
 */
function date_to_day($dates = [])
{
    $days = [];
    foreach ($dates as $date) {
        $days[] = date("d", strtotime($date));
    }

    return $days;
}


/**
 * [time_friend 时间美化函数v2.0]
 */
function time_friend($time)
{
    $todayLast = strtotime(date('Y-m-d') . ' 23:59:59');
    $agoTimeTrue = time() - $time;
    $agoTime = $todayLast - $time;
    $agoDay = floor($agoTime / 86400);
    $res = '';
    if ($agoTimeTrue < 60) {
        $res = '刚刚';
    } elseif ($agoTimeTrue < 3600) {
        $res = (ceil($agoTimeTrue / 60)) . '分钟前';
    } elseif ($agoTimeTrue < (3600 * 12)) {
        $res = (ceil($agoTimeTrue / 3600)) . '小时前';
    } elseif ($agoDay == 0) {
        $res = '今天 ' . date('H:i', $time);
    } elseif ($agoDay == 1) {
        $res = '昨天 ' . date('H:i', $time);
    } elseif ($agoDay == 2) {
        $res = '前天 ' . date('H:i', $time);
    } elseif (($agoDay > 2) && ($agoDay < 16)) {
        $res = $agoDay . '天前' . date('H:i', $time);
    } else {
        $res = date('Y-m-d H:i:s', $time);
    }

    return $res;
}


function make_time(){
	//获取今日开始时间戳和结束时间戳
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$times['today']['begin'] = $beginToday;
	$times['today']['end'] = $endToday;

	//获取昨日起始时间戳和结束时间戳
	$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
	$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
	$times['yesterday']['begin'] = $beginYesterday;
	$times['yesterday']['end'] = $endYesterday;

	//获取昨日起始时间戳和结束时间戳
	$beginYesterday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
	$endYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'))-2;
	$times['beforeyesterday']['begin'] = $beginYesterday;
	$times['beforeyesterday']['end'] = $endYesterday;

	//获取本周开始时间和结束时间，此例中开始时间为周一
//	$defaultDate = date('Y-m-d');
//	$first = 1;
//	$w = date('w',strtotime($defaultDate));
//	$beginWeek = strtotime("$defaultDate-" . ($w?$w-$first:6) . 'days');
//	$endWeek = $beginWeek + 6*24*3600-1;
//	$times['thisweek']['begin'] = $beginWeek;
//	$times['thisweek']['end'] = $endWeek;

	//获取本周起始时间戳和结束时间戳
	$beginWeek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
	$endWeek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
	$times['thisweek']['begin'] = $beginWeek;
	$times['thisweek']['end'] = $endWeek;

	//获取上周起始时间戳和结束时间戳
	$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-14,date('Y'));
	$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-14,date('Y'));
	$times['lastweek']['begin'] = $beginLastweek;
	$times['lastweek']['end'] = $endLastweek;


	//获取上周起始时间戳和结束时间戳
	$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-21,date('Y'));
	$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-21,date('Y'));
	$times['beforelastweek']['begin'] = $beginLastweek;
	$times['beforelastweek']['end'] = $endLastweek;

	//获取本月起始时间戳和结束时间戳
	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
	$times['thismonth']['begin'] = $beginThismonth;
	$times['thismonth']['end'] = $endThismonth;

	//获取上月的起始时间戳和结束时间戳
	$beginLastmonth=mktime(0,0,0,date('m')-1,1,date('Y'));
	$endLastmonth=mktime(23,59,59,date('m'),0,date('Y'));

	$times['lastmonth']['begin'] = $beginLastmonth;
	$times['lastmonth']['end'] = $endLastmonth;

	//获取上2月的起始时间戳和结束时间戳
	$beginLastmonth=mktime(0,0,0,date('m')-2,1,date('Y'));
	$endLastmonth=mktime(23,59,59,date('m')-1,0,date('Y'));
	$times['beforelastmonth']['begin'] = $beginLastmonth;
	$times['beforelastmonth']['end'] = $endLastmonth;

	//获取今年的起始时间和结束时间
	$beginThisyear = mktime(0,0,0,1,1,date('Y'));
	$endThisyear = mktime(23,59,59,12,31,date('Y'));
	$times['thisyear']['begin'] = $beginThisyear;
	$times['thisyear']['end'] = $endThisyear;

	//获取上年的起始时间和结束时间
	$beginLastyear = mktime(0,0,0,1,1,date('Y')-1);
	$endLastyear = mktime(23,59,59,12,31,date('Y')-1);
	$times['lastyear']['begin'] = $beginLastyear;
	$times['lastyear']['end'] = $endLastyear;

	//获取上2年的起始时间和结束时间
	$beginLastyear = mktime(0,0,0,1,1,date('Y')-2);
	$endLastyear = mktime(23,59,59,12,31,date('Y')-2);
	$times['beforelastyear']['begin'] = $beginLastyear;
	$times['beforelastyear']['end'] = $endLastyear;

	//获取本季度开始时间和结束时间
	$season = ceil((date('n'))/3);//当月是第几季度
	$beginThisSeason = mktime(0, 0, 0,$season*3-3+1,1,date('Y'));
	$endThisSeason = mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'));
	$times['thisseason']['begin'] = $beginThisSeason;
	$times['thisseason']['end'] = $endThisSeason;

	//获取上季度的起始时间和结束时间
	$beginLastSeason = mktime(0, 0, 0,($season-1)*3-3+1,1,date('Y'));
	$endLastSeason = mktime(23,59,59,($season-1)*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'));
	$times['lastseason']['begin'] = $beginLastSeason;
	$times['lastseason']['end'] = $endLastSeason;

	//获取上季度的起始时间和结束时间
	$beginLastSeason = mktime(0, 0, 0,($season-2)*3-3+1,1,date('Y'));
	$endLastSeason = mktime(23,59,59,($season-2)*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'));
	$times['beforelastseason']['begin'] = $beginLastSeason;
	$times['beforelastseason']['end'] = $endLastSeason;

	return $times;
}


if (!function_exists('msubstr')) {
    /**
     * 字符串截取，支持中文和其他编码
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    function msubstr($str = '', $start = 0, $length = NULL, $suffix = false, $charset = "utf-8")
    {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
            if (false === $slice) {
                $slice = '';
            }
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }

        $str_len = strlen($str); // 原字符串长度
        $slice_len = strlen($slice); // 截取字符串的长度
        if ($slice_len < $str_len) {
            $slice = $suffix ? $slice . '...' : $slice;
        }
        return $slice;
    }
}

if (!function_exists('html_msubstr')) {
    /**
     * 截取内容清除html之后的字符串长度，支持中文和其他编码
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    function html_msubstr($str = '', $start = 0, $length = NULL, $suffix = false, $charset = "utf-8")
    {
        $str = htmlspecialchars_decode($str);
        $str = checkStrHtml($str);
        return msubstr($str, $start, $length, $suffix, $charset);
    }
}

if (!function_exists('text_msubstr')) {
    /**
     * 针对多语言截取，其他语言的截取是中文语言的2倍长度
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    function text_msubstr($str = '', $start = 0, $length = NULL, $suffix = false, $charset = "utf-8")
    {
        return msubstr($str, $start, $length, $suffix, $charset);
    }
}

if (!function_exists('htmlspecialchars_decode')) {
    /**
     * 自定义只针对htmlspecialchars编码过的字符串进行解码
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    function htmlspecialchars_decode($str = '')
    {
        if (is_string($str) && stripos($str, '&lt;') !== false && stripos($str, '&gt;') !== false) {
            $str = htmlspecialchars_decode($str);
        }
        return $str;
    }
}

if (!function_exists('checkStrHtml')) {
    /**
     * 过滤Html标签
     *
     * @param string $string 内容
     * @return    string
     */
    function checkStrHtml($string)
    {
        $string = trim_space($string);

        if (is_numeric($string)) return $string;
        if (!isset($string) or empty($string)) return '';

        $string = preg_replace('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/', '', $string);
        $string = ($string);

        $string = strip_tags($string, ""); //清除HTML如<br />等代码
        // $string = str_replace("\n", "", str_replace(" ", "", $string));//去掉空格和换行
        $string = str_replace("\n", "", $string);//去掉空格和换行
        $string = str_replace("\t", "", $string); //去掉制表符号
        $string = str_replace(PHP_EOL, "", $string); //去掉回车换行符号
        $string = str_replace("\r", "", $string); //去掉回车
        $string = str_replace("'", "‘", $string); //替换单引号
        $string = str_replace("&amp;", "&", $string);
        $string = str_replace("=★", "", $string);
        $string = str_replace("★=", "", $string);
        $string = str_replace("★", "", $string);
        $string = str_replace("☆", "", $string);
        $string = str_replace("√", "", $string);
        $string = str_replace("±", "", $string);
        $string = str_replace("‖", "", $string);
        $string = str_replace("×", "", $string);
        $string = str_replace("∏", "", $string);
        $string = str_replace("∷", "", $string);
        $string = str_replace("⊥", "", $string);
        $string = str_replace("∠", "", $string);
        $string = str_replace("⊙", "", $string);
        $string = str_replace("≈", "", $string);
        $string = str_replace("≤", "", $string);
        $string = str_replace("≥", "", $string);
        $string = str_replace("∞", "", $string);
        $string = str_replace("∵", "", $string);
        $string = str_replace("♂", "", $string);
        $string = str_replace("♀", "", $string);
        $string = str_replace("°", "", $string);
        $string = str_replace("¤", "", $string);
        $string = str_replace("◎", "", $string);
        $string = str_replace("◇", "", $string);
        $string = str_replace("◆", "", $string);
        $string = str_replace("→", "", $string);
        $string = str_replace("←", "", $string);
        $string = str_replace("↑", "", $string);
        $string = str_replace("↓", "", $string);
        $string = str_replace("▲", "", $string);
        $string = str_replace("▼", "", $string);

        // --过滤微信表情
        $string = preg_replace_callback('/[\xf0-\xf7].{3}/', function ($r) {
            return '';
        }, $string);

        return $string;
    }
}


if (!function_exists('trim_space')) {
    /**
     * 过滤前后空格等多种字符
     *
     * @param string $str 字符串
     * @param array $arr 特殊字符的数组集合
     * @return string
     */
    function trim_space($str, $arr = array())
    {
        if (empty($arr)) {
            $arr = array(' ', '　');
        }
        foreach ($arr as $key => $val) {
            $str = preg_replace('/(^' . $val . ')|(' . $val . '$)/', '', $str);
        }

        return $str;
    }
}

if (!function_exists('func_preg_replace')) {
    /**
     * 替换指定的符号
     *
     * @param array $arr 特殊字符的数组集合
     * @param string $replacement 符号
     * @param string $str 字符串
     * @return string
     */
    function func_preg_replace($arr = array(), $replacement = ',', $str = '')
    {
        if (empty($arr)) {
            $arr = array('，');
        }
        foreach ($arr as $key => $val) {
            $str = preg_replace('/(' . $val . ')/', $replacement, $str);
        }

        return $str;
    }
}


if (!function_exists('is_http_url')) {
    /**
     * 判断url是否完整的链接
     *
     * @param string $url 网址
     * @return boolean
     */
    function is_http_url($url)
    {
        // preg_match("/^(http:|https:|ftp:|svn:)?(\/\/).*$/", $url, $match);
        preg_match("/^((\w)*:)?(\/\/).*$/", $url, $match);
        if (empty($match)) {
            return false;
        } else {
            return true;
        }
    }
}


if (!function_exists('cut_str')) {

    /**字符串按符号截取
     * $str='123/456/789/abc';
     * 示例：
     * echo cut_str($str,'/',0); //输出 123
     * echo cut_str($str,'/',2); //输出 789
     * echo cut_str($str,'/',-1);//输出 abc
     * echo cut_str($str,'/',-3);//输出 456
     * @param $str
     * @param $sign
     * @param $number
     * @return string
     *
     * Author: lingqifei created by at 2020/2/29 0029
     */
    function cut_str($str, $sign, $number)
    {
        $array = explode($sign, $str);
        $length = count($array);
        if ($number < 0) {
            $new_array = array_reverse($array);
            $abs_number = abs($number);
            if ($abs_number > $length) {
                return 'error';
            } else {
                return $new_array[$abs_number - 1];
            }
        } else {
            if ($number >= $length) {
                return 'error';
            } else {
                return $array[$number];
            }
        }
    }
}

if (!function_exists('download')) {

    /**
     * 文件下载函数
     * Author: lingqifei created by at 2020/6/4 0004
     */
    function download($filepath, $filename = 'downfile.zip')
    {
        // 检查文件是否存在
        if (!file_exists($filepath)) {
            $this->error('文件未找到');
        } else {
            // 打开文件
            $file1 = fopen($filepath, "r");
            // 输入文件标签
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length:" . filesize($filepath));
            Header("Content-Disposition: attachment;filename=" . $filename);
            ob_clean();     // 重点！！！
            flush();        // 重点！！！！可以清除文件中多余的路径名以及解决乱码的问题：
            //输出文件内容
            //读取文件内容并直接输出到浏览器
            echo fread($file1, filesize($filepath));
            fclose($file1);
            exit();
        }
    }
}

if (!function_exists('check_file_exists')) {
	/**
	 * 判断文件是否存在，支持本地及远程文件
	 * @param String $file 文件路径
	 * @return Boolean
	 */
	function check_file_exists($file)
	{
		// 远程文件
		if (strtolower(substr($file, 0, 4)) == 'http') {
			$header = get_headers($file, true);
			return isset($header[0]) && (strpos($header[0], '200') || strpos($header[0], '304'));
			// 本地文件
		} else {
			return file_exists($file);
		}
	}
}

if (!function_exists('httpcode')) {
    /**
     *检测网址是否能正常打开
     *
     * @param $url
     * @return mixed
     * Author: kfrs <goodkfrs@QQ.com> created by at 2020/12/25 0025
     */
    function httpcode($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch); // $resp = curl_exec($ch);
        $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $curl_code;
//        if ($curl_code == 200 || $curl_code == 302) {
//            echo '连接成功，状态码：' . $curl_code;
//        } else {
//            echo '连接失败，状态码：' . $curl_code;
//        }
    }
}
if (!function_exists('curl_post')) {

    /**使用curl。post获取数据
     * @param $url
     * @param $arr_data
     * Author: kfrs <goodkfrs@QQ.com> created by at 2020/12/25 0025
     */
    function curl_post($url, $post_data)
    {
        //$post_data = http_build_query($post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //设置header
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
//		var_dump($response);
//		var_dump($error);
        curl_close($ch);//关闭
        return $response;
    }
}

if (!function_exists('hide_name')) {

    /**使用curl。post获取数据
     * @param $url
     * @param $arr_data
     * Author: kfrs <goodkfrs@QQ.com> created by at 2020/12/25 0025
     */
    /**
     * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
     * @param string $user_name 姓名
     * @return string 格式化后的姓名
     */
    function hiddle_name($user_name)
    {
        $strlen = mb_strlen($user_name, 'utf-8');
        $firstStr = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr = mb_substr($user_name, -1, 1, 'utf-8');

        if($strlen > 2){
            return $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
        }else if($strlen == 2){
            return  $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) ;
        }else{
            return  $user_name;
        }
    }
}

if (!function_exists('hide_mobile')) {

    /**
     * 定义函数手机号隐藏中间四位
     * @param string $str 手机号
     * @return string 格式化后手机号
     */
    function hiddle_mobile($str)
    {
        $str = $str;
        $resstr = substr_replace($str, '****', 3, 4);
        return $resstr;
    }
}

if (!function_exists('downFileOutput')) {

	/**
	 * 服务器文件下载输出，支持断点输出
	 * @param string $file  文件路径为本地绝对路径
	 *
	 * @return 文件
	 */
	function downFileOutput($file) {

		str_replace(['/','\\'], DIRECTORY_SEPARATOR, $file);
		//检查文件是否存在
		if (empty($file) or !is_file($file)) {
			die('文件不存在');
		}
		$fileName = basename($file);
		//以只读和二进制模式打开文件
		$fp = @fopen($file, 'rb');
		if ($fp) {
			// 获取文件大小
			$file_size = filesize($file);
			//告诉浏览器这是一个文件流格式的文件
			header('content-type:application/octet-stream');
			header('Content-Disposition: attachment; filename=' . $fileName);
			// 断点续传
			$range = null;
			if (!empty($_SERVER['HTTP_RANGE'])) {
				$range = $_SERVER['HTTP_RANGE'];
				$range = preg_replace('/[\s|,].*/', '', $range);
				$range = explode('-', substr($range, 6));
				if (count($range) < 2) {
					$range[1] = $file_size;
				}
				$range = array_combine(array('start', 'end'), $range);
				if (empty($range['start'])) {
					$range['start'] = 0;
				}
				if (empty($range['end'])) {
					$range['end'] = $file_size;
				}
			}
			// 使用续传
			if ($range != null) {
				header('HTTP/1.1 206 Partial Content');
				header('Accept-Ranges:bytes');
				// 计算剩余长度
				header(sprintf('content-length:%u', $range['end'] - $range['start']));
				header(sprintf('content-range:bytes %s-%s/%s', $range['start'], $range['end'], $file_size));
				// fp指针跳到断点位置
				fseek($fp, sprintf('%u', $range['start']));
			} else {
				header('HTTP/1.1 200 OK');
				header('Accept-Ranges:bytes');
				header('content-length:' . $file_size);
			}
			while (!feof($fp)) {
				echo fread($fp, 4096);
				ob_flush();
			}
			fclose($fp);
		} else {
			die('File loading failed');
		}
	}
}

/**
 *  生成一个随机字符
 *
 * @access    public
 * @param     string $ddnum
 * @return    string
 */
if (!function_exists('dd2char')) {
	function dd2char($ddnum)
	{
		$ddnum = strval($ddnum);
		$slen  = strlen($ddnum);
		$okdd  = '';
		$nn    = '';
		for ($i = 0; $i < $slen; $i++) {
			if (isset($ddnum[$i + 1])) {
				$n = $ddnum[$i] . $ddnum[$i + 1];
				if (($n > 96 && $n < 123) || ($n > 64 && $n < 91)) {
					$okdd .= chr($n);
					$i++;
				} else {
					$okdd .= $ddnum[$i];
				}
			} else {
				$okdd .= $ddnum[$i];
			}
		}
		return $okdd;
	}
}
/**
 *  PHP stdClass Object转array
 *
 * @access    public
 * @param     string $ddnum
 * @return    string
 */
if (!function_exists('obj2arr')) {

	function obj2arr($array) {
		if(is_object($array)) {
			$array = (array)$array;
		} if(is_array($array)) {
			foreach($array as $key=>$value) {
				$array[$key] = obj2arr($value);
			}
		}
		return $array;
	}
}