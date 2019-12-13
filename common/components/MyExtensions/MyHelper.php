<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 12.11.15
 * Time: 15:56
 */

namespace common\components\MyExtensions;


use yii\web\Cookie;
use common\models\Region;

class MyHelper
{
    public static function formatTextToHTML($string, $useBr = false)
    {
        $strGlue =($useBr)?"<br>":"</p><p>";
        $pArray = preg_split('/\n|\r\n/', $string);

        $returnStr = implode($strGlue,$pArray);

        if (!$useBr){
            $returnStr = "<p>".$returnStr."</p>";
        }

        return  $returnStr;
    }

    /**
     * @param $array
     * @param $id
     * @return \stdClass
     */
    public static function searchById($array, $id)
    {
        $return = null;
        foreach ($array as $el) {
            if (property_exists($el, 'id') && $el->id==$id){
                $return = $el;
                break;
            }
        }

        return $return;
    }

    /**
     * @param string $text
     * @param string $phone
     * @return array
     */
    public static function sendSms($text, $phone)
    {
        $ch = curl_init("http://sms.ru/auth/get_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $token = curl_exec($ch);
        curl_close($ch);


        $ch = curl_init("http://sms.ru/sms/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "login"		=>	"79057324605",
            "sha512"    =>	hash("sha512","pronto24".$token."D134150D-CA02-06CE-4BAA-F657F5B13A51"),
            "token"		=>	$token,
            "to"		=>	$phone,
            "text"		=>	$text
        ]);
        $body = curl_exec($ch);
        curl_close($ch);

        return ['token' => $token,'b' => $phone];
    }

    /**
     * @return void
     */
    public static function detectCity()
    {
        if (!isset(\Yii::$app->request->cookies[Region::COOKIE_NAME])) {
            $ip = $_SERVER['REMOTE_ADDR'];

            try {
                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
            }
            catch (\Exception $e) {
                \Yii::warning($e->getMessage());
                $details = null;
            }

            $city = is_object($details) && property_exists($details, 'city') ? $details->city : false;
            // it's better to set special name for search, cuz names could be different
            $cityModel = $city ? Region::find()->where(['ilike', 'title', $city])->one() : false;
            if ($cityModel) {
                \Yii::$app->response->cookies->add(new Cookie([
                    'name' => Region::COOKIE_NAME,
                    'value' => $cityModel->id
                ]));
            }
        }
    }

    /**
     * @return bool
     */
    public static function isMobile()
    {
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            return true;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

        if (in_array($mobile_ua,$mobile_agents)) {
            true;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
            return true;
        }

        return false;
    }

    public function formatDate($date){
        $month = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
        return date('d', strtotime($date))." ".$month[date('n', strtotime($date)) - 1]." ".date('Y', strtotime($date));
    }
}