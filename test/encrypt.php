<?php
// +----------------------------------------------------------------------
// | 加密解密(根据base64加密解密原理封装，有密钥才能解开加密数据)
// +----------------------------------------------------------------------
// | Author: Rongkai Yang <yangrk2008@qq.com>
// +----------------------------------------------------------------------
header('Content-type:text/html; charset=utf-8');

class encrypt {
    public static $secretKey = 'RongkaiYang';//密钥
    public static $expire;//过期时间 单位秒
    public static $string;
    protected static $table = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
        'I', 'J', 'K', 'L', 'M', 'N', 'O' ,'P',
        'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
        'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
        'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
        'w', 'x', 'y', 'z', '0', '1', '2', '3',
        '4', '5', '6', '7', '8', '9', '+', '/'
    ];

    /**
     * 初始化检查设置
     * @param string $string  需要加密、解密的字符串
     * @param string $secretKey  密钥
     * @return bool
     */
    public static function init($string = '', $secretKey = ''){
        if(!empty($string) && is_string($string))
            self::$string = $string;
        
        if(empty(self::$string)){
            return false;
        }

        if(!empty($secretKey) && is_string($secretKey))
            self::$secretKey = $secretKey;
        return true;
    }

    /*
     * 解密
     * @param string $string 加密密文
     * @param string $secretKey 密钥
     * @return bool|string
     */
    public static function deCode($string = '', $secretKey = ''){
        if(!self::init($string, $secretKey))
            return false;
        $decodeString = base64_decode(self::encryption(self::$string));
        $createTime = hexdec(substr($decodeString, 32, 8));
        if(!empty(self::$expire) && (time() - $createTime > self::$expire)){
            return false;
        }
        return substr($decodeString, 40);
    }

    /*
     * 加密
     * @param string $string 需要加密的字符串
     * @param string $secretKey 密钥
     * @return bool|string
     */
    public static function enCode($string = '', $secretKey = ''){
        if(!self::init($string, $secretKey))
            return false;
        return self::encryption(base64_encode(md5(time()).dechex(time()).self::$string));
    }

    /*
     * 加密解密算法
     * @param $string 需要处理的字符串
     * @return string
     */
    public static function encryption($string){
        $tableFlip = array_flip(self::$table);
        $string = rtrim($string, '=');
        $stringLen = strlen($string);
        $secretKey = rtrim(base64_encode(self::$secretKey), '=');
        $secretKeyLen = strlen($secretKey);
        $encryptString = '';
        for ($i = 0; $i < $stringLen; $i++) {
            $key = $tableFlip[$secretKey[$i % $secretKeyLen]];
            $sOrd = $tableFlip[$string[$i]];
            $encrypt = $key ^ $sOrd;
            $encryptString .= self::$table[$encrypt];
        }
        return $encryptString;
    }
}

$str = '豫章故郡，洪都新府。星分翼轸，地接衡庐。襟三江而带五湖，控蛮荆而引瓯越。物华天宝，龙光射牛斗之墟；人杰地灵，徐孺下陈蕃之榻。雄州雾列，俊采星驰。台隍枕夷夏之交，宾主尽东南之美。都督阎公之雅望，棨戟遥临；宇文新州之懿范，襜帷暂驻。十旬休假，胜友如云；千里逢迎，高朋满座。腾蛟起凤，孟学士之词宗；紫电青霜，王将军之武库。家君作宰，路出名区；童子何知，躬逢胜饯。';

$str2 = '中国人!上午好，风轻云淡。';
//encrypt::init('中国人!上午好，风轻云淡。');

$start = microtime(true);
echo base64_encode($str);
echo '<hr>';
encrypt::init($str, '123456');
echo $encodeString = encrypt::enCode();
echo '<hr>';
//encrypt::init($encodeString);
echo encrypt::deCode($encodeString);

$end = microtime(true);
echo '<hr>';

echo $end - $start;
?>
