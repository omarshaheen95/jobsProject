<?php

use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\Topics;
use GuzzleHttp\Client;
use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;
use RLaurindo\TelegramLogger\Services\TelegramService;

function routeIn($level, $child)
{
    $levels = [
        'admins' => [
            'backend.admin.index',
            'backend.admin.create',
            'backend.admin.edit',
            'backend.role.index',
        ],
        'policies' => [
            'backend.policy.index',
            'backend.policy.create',
            'backend.policy.edit',
            'backend.policy.users_policies',
            'backend.policy_feedback.index',
        ],
        'quizzes' => [
            'backend.quiz.index',
            'backend.quiz.create',
            'backend.quiz.edit',
            'backend.quiz.users_quizzes',
        ],
        'assessments' => [
            'backend.assessment.index',
            'backend.assessment.create',
            'backend.assessment.edit',
            'backend.assessment.users_assessments',
        ],
        'polls' => [
            'backend.poll.index',
            'backend.poll.create',
            'backend.poll.edit',
            'backend.poll.users_polls',
        ],
        'settings' => [
            'backend.company.index',
            'backend.company.create',
            'backend.company.edit',
            'backend.branch.index',
            'backend.branch.create',
            'backend.branch.edit',
            'backend.category.index',
            'backend.category.create',
            'backend.category.edit',
            'backend.sub_category.index',
            'backend.sub_category.create',
            'backend.sub_category.edit',
            'backend.department.index',
            'backend.department.create',
            'backend.department.edit',
            'backend.group.index',
            'backend.group.create',
            'backend.group.edit',
            'backend.position.index',
            'backend.position.create',
            'backend.position.edit',
            'backend.country.index',
            'backend.country.create',
            'backend.country.edit',
            'backend.city.index',
            'backend.city.create',
            'backend.city.edit',
            'backend.status.index',
            'backend.status.create',
            'backend.status.edit',
            'backend.faq.index',
            'backend.faq.create',
            'backend.faq.edit',
            'backend.activity.index',
            'backend.text_translation.*',
            'backend.settings.edit',
            'backend.settings.ad_logs',
            'backend.settings.show_ad_log',
        ],
    ];

    $level_result = $levels[$level] ?? [];
    return in_array($child, $level_result);
}

function uploadFile($file, $path = '')
{
    $fileName = $file->getClientOriginalName();
    $file_exe = $file->getClientOriginalExtension();
    $new_name = uniqid() . '.' . $file_exe;
    $directory = 'uploads' . '/' . $path;//.'/'.date("Y").'/'.date("m").'/'.date("d");
    $destination = public_path($directory);
    $file->move($destination, $new_name);
    $data['path'] = $directory . '/' . $new_name;
    $data['file_name'] = $fileName;
    $data['new_name'] = $new_name;
    $data['extension'] = $file_exe;
    return $data;
}

function set_locale()
{
    $locale = isAPI() ? request()->header('Accept-Language') : (session('lang') ? session('lang') : 'en');
    if (!$locale || !in_array($locale, ['ar', 'en'])) $locale = 'ar';

    app()->setLocale($locale);

    return $locale;
}

function t($key, $placeholder = [], $locale = null)
{

    $group = 'admin';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word))
    {
        return trans($word, $placeholder, $locale);
    } else{
        return $key;
    }

    $messages = [
        $word => $key,
    ];

    app('translator')->addLines($messages, $locale);
    $langs = config('app.languages');
    foreach ($langs as $lang) {
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $key = str_replace("'", "\'", $key);
        $new_key = "\n \t'$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);


}

function f($key, $placeholder = [], $locale = null)
{

    $group = 'frontend';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word))
    {
        return trans($word, $placeholder, $locale);
    } else{
        return $key;
    }

    $messages = [
        $word => $key,
    ];

    app('translator')->addLines($messages, $locale);
    $langs = config('app.languages');
    foreach ($langs as $lang) {
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $key = str_replace("'", "\'", $key);
        $new_key = "\n \t'$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);


}

function w($key, $placeholder = [], $locale = null)
{

    $group = 'web';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word))
    {
        return trans($word, $placeholder, $locale);
    } else{
        return $key;
    }

    $messages = [
        $word => $key,
    ];

    app('translator')->addLines($messages, $locale);
    $langs = config('translatable.locales');
    foreach ($langs as $lang) {
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $new_key = "\n \t'$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);
    return $key;

}

function api($key, $placeholder = [], $locale = null)
{

    $group = 'api';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word))
    {
        return trans($word, $placeholder, $locale);
    } else{
        return $key;
    }

    $messages = [
        $word => $key,
    ];

    app('translator')->addLines($messages, $locale);
    $langs = config('translatable.locales');
    foreach ($langs as $lang) {
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $new_key = "  \n  '$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);
    return $key;

}

function getDeadlineClass($deadline)
{
    $current = \Carbon\Carbon::now();
    $deadline_time = \Carbon\Carbon::parse($deadline);
    $days = $current->diffInDays($deadline_time, false);
    if ($days >= 3)
    {
       return 'text-success';
    }elseif($days == 2 || $days == 1)
    {
        return 'text-warning';
    }else{
        return 'text-danger';
    }
}

function documentTypes()
{
    return [
        'document',
        'audio',
        'video',
        'image',
        'archive',
    ];
}

function questionTypes()
{
    return [
        'radio',
        'checkbox',
    ];
}

function isRtl()
{
    return app()->getLocale() === 'ar';
}

function isRtlJS()
{
    return app()->getLocale() === 'ar' ? 'true' : 'false';
}

function direction($dot = '')
{
    return isRtl() ? 'rtl' . $dot : '';
}

function currentLanguage()
{
    return app()->getLocale();
}

function MimeFile($extension)
{
    /*
     Video Type     Extension       MIME Type
    Flash           .flv            video/x-flv
    MPEG-4          .mp4            video/mp4
    iPhone Index    .m3u8           application/x-mpegURL
    iPhone Segment  .ts             video/MP2T
    3GP Mobile      .3gp            video/3gpp
    QuickTime       .mov            video/quicktime
    A/V Interleave  .avi            video/x-msvideo
    Windows Media   .wmv            video/x-ms-wmv
    */
    $ext_photos = ['png', 'jpg', 'jpeg', 'gif'];
    return in_array($extension, $ext_photos) ? 'photo' : 'video';

}

function split_string($string, $count = 2)
{

//Using the explode method
    $arr_ph = explode(" ", $string, $count);

    if (!isset($arr_ph[1]))
        $arr_ph[1] = '';
    return $arr_ph;

}

function check_mobile($mobile)
{

    if (\Str::startsWith($mobile, '05')) {
        return '+966' . substr($mobile, 1, 9);
    }
    if (\Str::startsWith($mobile, '03')) {
        return '+966' . substr($mobile, 1, 9);
    }
    if (\Str::startsWith($mobile, '5')) {
        return '+966' . substr($mobile, 0, 9);
    }
    if (\Str::startsWith($mobile, '00966')) {
        return '+' . substr($mobile, 2, 13);
    }
    if (\Str::startsWith($mobile, '966')) {
        return '+' . $mobile;
    }

    return $mobile;


    //   $mobile = str_replace('05', '+9665', $mobile);

}

/*
 |--------------------------------------------------------------------------
 | Send sms
 |--------------------------------------------------------------------------
 |
 */

function nearest($lat, $lng, $radius = 1)
{

    // Km
    $angle_radius = $radius / 111;
    $location['min_lat'] = $lat - $angle_radius;
    $location['max_lat'] = $lat + $angle_radius;
    $location['min_lng'] = $lng - $angle_radius;
    $location['max_lng'] = $lng + $angle_radius;

    return (object)$location;

}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2017                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function distance($lat1, $lon1, $lat2, $lon2, $unit)
{

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

/**
 * Calculates the great-circle distance between two points, with
 * the Vincenty formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function DistanceFromLatLonInKm($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
}

function assets($path = '', $relative = false)
{
    return $relative ? 'public/' . $path : url('public/' . $path);
}

function slug($string)
{
    return preg_replace('/\s+/u', '-', trim($string));
}

function generateRandomString($length = 20)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateInvoiceNumber($model)
{
    $year = date('Y');
    $expNum = 0;
//get last record
    $record = $model::latest()->first();
    if ($record)
        list($year, $expNum) = explode('-', $record->invoice_id);

//check first day in a year
    if (date('z') === '0') {
        $nextInvoiceNumber = date('Y') . '-0001';
    } else {
        //increase 1 with last invoice number
        $nextInvoiceNumber = $year . '-' . ((int)$expNum + 1);
    }

    return $nextInvoiceNumber;
//now add into database $nextInvoiceNumber as a next number.
}

function work_hours()
{
    $days = [
        ["day" => 'Saturday', 'num' => 1, 'from' => '8', 'to' => '20'],
        ["day" => 'Sunday', 'num' => 2, 'from' => '8', 'to' => '20'],
        ["day" => 'Monday', 'num' => 3, 'from' => '8', 'to' => '20'],
        ["day" => 'Tuesday', 'num' => 4, 'from' => '8', 'to' => '20'],
        ["day" => 'Wednesday', 'num' => 5, 'from' => '8', 'to' => '20'],
        ["day" => 'Thursday', 'num' => 6, 'from' => '8', 'to' => '20'],
        ["day" => 'Friday', 'num' => 7, 'from' => '8', 'to' => '20'],
    ];

    return $days;
}

function defaultImage()
{
    return "public/assets/img/default.png";
}

function pic($src, $class = 'full')
{
    $html = "<img class='  " . $class . "' src='" . asset($src) . "'>";

    return $html;
}

function ext($filename, $style = false)
{

    //$ext = File::extension($filename);

    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!$style)
        return $ext;
    return $html = "<img class='' src='" . asset('public/assets/img/ext/' . $ext . '.png') . "'>";
}

function IsLang($lang = 'ar')
{
    return session('lang') == $lang;
}

function CurrentLang()
{
    return session('lang', 'en');
}

function isAPI()
{
    return request()->is('api/*');
}

function versions()
{
    return ['v1'];
}

function base64ToFile($data)
{

    $file_name = 'attach_' . time() . '.' . getExtBase64($data);
    $path = 'uploads/user_attachments/' . $file_name;
    $uploadPath = public_path($path);
    if (!file_put_contents($uploadPath, base64_decode($data))) ;
    $path = '';
    return $path;

}

function getExtBase64($data)
{

    $pos = strpos($data, ';');
    $mimi = explode(':', substr($data, 0, $pos))[1];
    return $ext = explode('/', $mimi)[1];
}

function paginate($object)
{
    return [
        'current_page' => $object->currentPage(),
        //'items' => $object->items(),
        'first_page_url' => $object->url(1),
        'from' => $object->firstItem(),
        'last_page' => $object->lastPage(),
        'last_page_url' => $object->url($object->lastPage()),
        'next_page_url' => $object->nextPageUrl(),
        'per_page' => $object->perPage(),
        'prev_page_url' => $object->previousPageUrl(),
        'to' => $object->lastItem(),
        'total' => $object->total(),
    ];
}

function paginate_message($object)
{

    $items = [];
    foreach ($object->items() as $key => $item) {
        foreach ($item['data'] as $k => $val) {
            $items[$key][$k] = $val;

            // $items[$key] = ['id' => $item->id,'title' => $item->data['title'],'body' => $item->data['body'],'created_at' => $item->created_at ];
            /* if(isset($item->data['title']))
              $items[$key]['title'] = $item->data['title']; */
        }
        $items[$key]['notification_id'] = $item->id;
        $items[$key]['created_at'] = $item->created_at->format('Y-m-d H:i:s');
    }

    return [
        'current_page' => $object->currentPage(),
        'items' => $items,
        'first_page_url' => $object->url(1),
        'from' => $object->firstItem(),
        'last_page' => $object->lastPage(),
        'last_page_url' => $object->url($object->lastPage()),
        'next_page_url' => $object->nextPageUrl(),
        'per_page' => $object->perPage(),
        'prev_page_url' => $object->previousPageUrl(),
        'to' => $object->lastItem(),
        'total' => $object->total(),
    ];
}

function getOnly($only, $array)
{
    $data = [];
    foreach ($only as $id) {
        if (isset($array[$id])) {
            $data[$id] = $array[$id];
        }
    }
    return $data;
}


//function cached($index = 'settings', $col = false)
//{
//
//    //Cache::forget('cities');
//    $cache['settings'] = Cache::remember('settings', 60 * 48, function () {
//        return \App\Models\Setting::first();
//    });
//
//    if (!isset($cache[$index]))
//        return $index;
//    if (!$col)
//        return $cache[$index];
//    return $cache[$index]->{$col};
//
//}

function destroyFile($file)
{

    if (!empty($file) and File::exists(public_path($file)))
        File::delete(public_path($file));

}

function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $html = curl_exec($ch);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function arabic_date($datetime)
{

    $months = ["Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر"];
    $days = ["Sat" => "السبت", "Sun" => "الأحد", "Mon" => "الإثنين", "Tue" => "الثلاثاء", "Wed" => "الأربعاء", "Thu" => "الخميس", "Fri" => "الجمعة"];
    $am_pm = ['AM' => 'ص', 'PM' => 'م'];

    $_month = $months[date('M', strtotime($datetime))];
    $_day = $days[date('D', strtotime($datetime))];
    $_day = date('d', strtotime($datetime));
    $_time = date('h:i', strtotime($datetime));
    $_am_pm = $am_pm[date('A', strtotime($datetime))];

    return \Carbon\Carbon::parse($datetime)->format('d/m/Y - h:i') . ' ' . $_am_pm;

}

function arabic_time($_time)
{

    $am_pm = ['AM' => 'ص', 'PM' => 'م'];

    $_time = date('h:i', strtotime($_time));
    $_am_pm = $am_pm[date('A', strtotime($_time))];

    return $_am_pm . ' ' . \Carbon\Carbon::parse($_time)->format('h:i');

}

function numhash($n)
{
    return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
}


function compress_image($source_url, $destination_url, $quality)
{

    // $info = getimagesize($source_url);
//        $memoryNeeded = round(($info[0] * $info[1] * $info['bits']  / 8 + Pow(2, 16)) * 1.65);

// if (function_exists('memory_get_usage') && memory_get_usage() + $memoryNeeded > (integer) ini_get('memory_limit') * pow(1024, 2)) {

//     ini_set('memory_limit', (integer) ini_get('memory_limit') + ceil(((memory_get_usage() + $memoryNeeded) - (integer) ini_get('memory_limit') * pow(1024, 2)) / pow(1024, 2)) . 'M');

// }

    ini_set('memory_limit', '265M');

    // $newHeight = ($height / $width) * $newWidth;
    // $tmp = imagecreatetruecolor($newWidth, $newHeight);
    // imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);


    // if ($info['mime'] == 'image/jpeg'){
    //       $image = imagecreatefromjpeg($source_url);
    // imagejpeg($image, $destination_url, $quality);
    // }
    // if ($info['mime'] == 'image/gif'){
    //       $image = imagecreatefromgif($source_url);
    // imagegif($image, $destination_url, 5);
    // }
    // elseif ($info['mime'] == 'image/png'){
    //       $image = imagecreatefrompng($source_url);
    // imagepng($image, $destination_url, 5);
    // }
    // else{
    // $image = imagecreatefromjpeg($source_url);
    // imagejpeg($image, $destination_url, $quality);
    // }


// jpg, png, gif or bmp?
    $exploded = explode('.', $source_url);
    $ext = $exploded[count($exploded) - 1];

    if (preg_match('/jpg|jpeg/i', $ext))
        $imageTmp = imagecreatefromjpeg($source_url);
    else if (preg_match('/png/i', $ext))
        $imageTmp = imagecreatefrompng($source_url);
    else if (preg_match('/gif/i', $ext))
        $imageTmp = imagecreatefromgif($source_url);
    else if (preg_match('/bmp/i', $ext))
        $imageTmp = imagecreatefrombmp($source_url);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $destination_url, $quality);


    imagedestroy($imageTmp);
    return $destination_url;
}

function resize($newWidth, $originalFile)
{

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;

        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;

        default:
            throw new Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // if (file_exists($targetFile)) {
    //         unlink($targetFile);
    // }

    $image_save_func($tmp, $originalFile);
}

function convertToUnicode($message)
{
    $chrArray[0] = "¡";
    $unicodeArray[0] = "060C";
    $chrArray[1] = "º";
    $unicodeArray[1] = "061B";
    $chrArray[2] = "¿";
    $unicodeArray[2] = "061F";
    $chrArray[3] = "Á";
    $unicodeArray[3] = "0621";
    $chrArray[4] = "Â";
    $unicodeArray[4] = "0622";
    $chrArray[5] = "Ã";
    $unicodeArray[5] = "0623";
    $chrArray[6] = "Ä";
    $unicodeArray[6] = "0624";
    $chrArray[7] = "Å";
    $unicodeArray[7] = "0625";
    $chrArray[8] = "Æ";
    $unicodeArray[8] = "0626";
    $chrArray[9] = "Ç";
    $unicodeArray[9] = "0627";
    $chrArray[10] = "È";
    $unicodeArray[10] = "0628";
    $chrArray[11] = "É";
    $unicodeArray[11] = "0629";
    $chrArray[12] = "Ê";
    $unicodeArray[12] = "062A";
    $chrArray[13] = "Ë";
    $unicodeArray[13] = "062B";
    $chrArray[14] = "Ì";
    $unicodeArray[14] = "062C";
    $chrArray[15] = "Í";
    $unicodeArray[15] = "062D";
    $chrArray[16] = "Î";
    $unicodeArray[16] = "062E";
    $chrArray[17] = "Ï";
    $unicodeArray[17] = "062F";
    $chrArray[18] = "Ð";
    $unicodeArray[18] = "0630";
    $chrArray[19] = "Ñ";
    $unicodeArray[19] = "0631";
    $chrArray[20] = "Ò";
    $unicodeArray[20] = "0632";
    $chrArray[21] = "Ó";
    $unicodeArray[21] = "0633";
    $chrArray[22] = "Ô";
    $unicodeArray[22] = "0634";
    $chrArray[23] = "Õ";
    $unicodeArray[23] = "0635";
    $chrArray[24] = "Ö";
    $unicodeArray[24] = "0636";
    $chrArray[25] = "Ø";
    $unicodeArray[25] = "0637";
    $chrArray[26] = "Ù";
    $unicodeArray[26] = "0638";
    $chrArray[27] = "Ú";
    $unicodeArray[27] = "0639";
    $chrArray[28] = "Û";
    $unicodeArray[28] = "063A";
    $chrArray[29] = "Ý";
    $unicodeArray[29] = "0641";
    $chrArray[30] = "Þ";
    $unicodeArray[30] = "0642";
    $chrArray[31] = "ß";
    $unicodeArray[31] = "0643";
    $chrArray[32] = "á";
    $unicodeArray[32] = "0644";
    $chrArray[33] = "ã";
    $unicodeArray[33] = "0645";
    $chrArray[34] = "ä";
    $unicodeArray[34] = "0646";
    $chrArray[35] = "å";
    $unicodeArray[35] = "0647";
    $chrArray[36] = "æ";
    $unicodeArray[36] = "0648";
    $chrArray[37] = "ì";
    $unicodeArray[37] = "0649";
    $chrArray[38] = "í";
    $unicodeArray[38] = "064A";
    $chrArray[39] = "Ü";
    $unicodeArray[39] = "0640";
    $chrArray[40] = "ð";
    $unicodeArray[40] = "064B";
    $chrArray[41] = "ñ";
    $unicodeArray[41] = "064C";
    $chrArray[42] = "ò";
    $unicodeArray[42] = "064D";
    $chrArray[43] = "ó";
    $unicodeArray[43] = "064E";
    $chrArray[44] = "õ";
    $unicodeArray[44] = "064F";
    $chrArray[45] = "ö";
    $unicodeArray[45] = "0650";
    $chrArray[46] = "ø";
    $unicodeArray[46] = "0651";
    $chrArray[47] = "ú";
    $unicodeArray[47] = "0652";
    $chrArray[48] = "!";
    $unicodeArray[48] = "0021";
    $chrArray[49] = '"';
    $unicodeArray[49] = "0022";
    $chrArray[50] = "#";
    $unicodeArray[50] = "0023";
    $chrArray[51] = "$";
    $unicodeArray[51] = "0024";
    $chrArray[52] = "%";
    $unicodeArray[52] = "0025";
    $chrArray[53] = "&";
    $unicodeArray[53] = "0026";
    $chrArray[54] = "'";
    $unicodeArray[54] = "0027";
    $chrArray[55] = "(";
    $unicodeArray[55] = "0028";
    $chrArray[56] = ")";
    $unicodeArray[56] = "0029";
    $chrArray[57] = "*";
    $unicodeArray[57] = "002A";
    $chrArray[58] = "+";
    $unicodeArray[58] = "002B";
    $chrArray[59] = ",";
    $unicodeArray[59] = "002C";
    $chrArray[60] = "-";
    $unicodeArray[60] = "002D";
    $chrArray[61] = ".";
    $unicodeArray[61] = "002E";
    $chrArray[62] = "/";
    $unicodeArray[62] = "002F";
    $chrArray[63] = "0";
    $unicodeArray[63] = "0030";
    $chrArray[64] = "1";
    $unicodeArray[64] = "0031";
    $chrArray[65] = "2";
    $unicodeArray[65] = "0032";
    $chrArray[66] = "3";
    $unicodeArray[66] = "0033";
    $chrArray[67] = "4";
    $unicodeArray[67] = "0034";
    $chrArray[68] = "5";
    $unicodeArray[68] = "0035";
    $chrArray[69] = "6";
    $unicodeArray[69] = "0036";
    $chrArray[70] = "7";
    $unicodeArray[70] = "0037";
    $chrArray[71] = "8";
    $unicodeArray[71] = "0038";
    $chrArray[72] = "9";
    $unicodeArray[72] = "0039";
    $chrArray[73] = ":";
    $unicodeArray[73] = "003A";
    $chrArray[74] = ";";
    $unicodeArray[74] = "003B";
    $chrArray[75] = "<";
    $unicodeArray[75] = "003C";
    $chrArray[76] = "=";
    $unicodeArray[76] = "003D";
    $chrArray[77] = ">";
    $unicodeArray[77] = "003E";
    $chrArray[78] = "?";
    $unicodeArray[78] = "003F";
    $chrArray[79] = "@";
    $unicodeArray[79] = "0040";
    $chrArray[80] = "A";
    $unicodeArray[80] = "0041";
    $chrArray[81] = "B";
    $unicodeArray[81] = "0042";
    $chrArray[82] = "C";
    $unicodeArray[82] = "0043";
    $chrArray[83] = "D";
    $unicodeArray[83] = "0044";
    $chrArray[84] = "E";
    $unicodeArray[84] = "0045";
    $chrArray[85] = "F";
    $unicodeArray[85] = "0046";
    $chrArray[86] = "G";
    $unicodeArray[86] = "0047";
    $chrArray[87] = "H";
    $unicodeArray[87] = "0048";
    $chrArray[88] = "I";
    $unicodeArray[88] = "0049";
    $chrArray[89] = "J";
    $unicodeArray[89] = "004A";
    $chrArray[90] = "K";
    $unicodeArray[90] = "004B";
    $chrArray[91] = "L";
    $unicodeArray[91] = "004C";
    $chrArray[92] = "M";
    $unicodeArray[92] = "004D";
    $chrArray[93] = "N";
    $unicodeArray[93] = "004E";
    $chrArray[94] = "O";
    $unicodeArray[94] = "004F";
    $chrArray[95] = "P";
    $unicodeArray[95] = "0050";
    $chrArray[96] = "Q";
    $unicodeArray[96] = "0051";
    $chrArray[97] = "R";
    $unicodeArray[97] = "0052";
    $chrArray[98] = "S";
    $unicodeArray[98] = "0053";
    $chrArray[99] = "T";
    $unicodeArray[99] = "0054";
    $chrArray[100] = "U";
    $unicodeArray[100] = "0055";
    $chrArray[101] = "V";
    $unicodeArray[101] = "0056";
    $chrArray[102] = "W";
    $unicodeArray[102] = "0057";
    $chrArray[103] = "X";
    $unicodeArray[103] = "0058";
    $chrArray[104] = "Y";
    $unicodeArray[104] = "0059";
    $chrArray[105] = "Z";
    $unicodeArray[105] = "005A";
    $chrArray[106] = "[";
    $unicodeArray[106] = "005B";
    $char = "\ ";
    $chrArray[107] = trim($char);
    $unicodeArray[107] = "005C";
    $chrArray[108] = "]";
    $unicodeArray[108] = "005D";
    $chrArray[109] = "^";
    $unicodeArray[109] = "005E";
    $chrArray[110] = "_";
    $unicodeArray[110] = "005F";
    $chrArray[111] = "`";
    $unicodeArray[111] = "0060";
    $chrArray[112] = "a";
    $unicodeArray[112] = "0061";
    $chrArray[113] = "b";
    $unicodeArray[113] = "0062";
    $chrArray[114] = "c";
    $unicodeArray[114] = "0063";
    $chrArray[115] = "d";
    $unicodeArray[115] = "0064";
    $chrArray[116] = "e";
    $unicodeArray[116] = "0065";
    $chrArray[117] = "f";
    $unicodeArray[117] = "0066";
    $chrArray[118] = "g";
    $unicodeArray[118] = "0067";
    $chrArray[119] = "h";
    $unicodeArray[119] = "0068";
    $chrArray[120] = "i";
    $unicodeArray[120] = "0069";
    $chrArray[121] = "j";
    $unicodeArray[121] = "006A";
    $chrArray[122] = "k";
    $unicodeArray[122] = "006B";
    $chrArray[123] = "l";
    $unicodeArray[123] = "006C";
    $chrArray[124] = "m";
    $unicodeArray[124] = "006D";
    $chrArray[125] = "n";
    $unicodeArray[125] = "006E";
    $chrArray[126] = "o";
    $unicodeArray[126] = "006F";
    $chrArray[127] = "p";
    $unicodeArray[127] = "0070";
    $chrArray[128] = "q";
    $unicodeArray[128] = "0071";
    $chrArray[129] = "r";
    $unicodeArray[129] = "0072";
    $chrArray[130] = "s";
    $unicodeArray[130] = "0073";
    $chrArray[131] = "t";
    $unicodeArray[131] = "0074";
    $chrArray[132] = "u";
    $unicodeArray[132] = "0075";
    $chrArray[133] = "v";
    $unicodeArray[133] = "0076";
    $chrArray[134] = "w";
    $unicodeArray[134] = "0077";
    $chrArray[135] = "x";
    $unicodeArray[135] = "0078";
    $chrArray[136] = "y";
    $unicodeArray[136] = "0079";
    $chrArray[137] = "z";
    $unicodeArray[137] = "007A";
    $chrArray[138] = "{";
    $unicodeArray[138] = "007B";
    $chrArray[139] = "|";
    $unicodeArray[139] = "007C";
    $chrArray[140] = "}";
    $unicodeArray[140] = "007D";
    $chrArray[141] = "~";
    $unicodeArray[141] = "007E";
    $chrArray[142] = "©";
    $unicodeArray[142] = "00A9";
    $chrArray[143] = "®";
    $unicodeArray[143] = "00AE";
    $chrArray[144] = "÷";
    $unicodeArray[144] = "00F7";
    $chrArray[145] = "×";
    $unicodeArray[145] = "00F7";
    $chrArray[146] = "§";
    $unicodeArray[146] = "00A7";
    $chrArray[147] = " ";
    $unicodeArray[147] = "0020";
    $chrArray[148] = "\n";
    $unicodeArray[148] = "000D";
    $chrArray[149] = "\r";
    $unicodeArray[149] = "000A";

    $strResult = "";
    for ($i = 0; $i < strlen($message); $i++) {
        if (in_array(substr($message, $i, 1), $chrArray))
            $strResult .= $unicodeArray[array_search(substr($message, $i, 1), $chrArray)];
    }
    return $strResult;
}

function get_guard()
{
    if (strpos(request()->url(), '/api/') !== false || strpos(request()->url(), '/web/') !== false) {
        foreach (array_keys(config('auth.guards')) as $guard) {

            if (auth()->guard('sanctum:' . $guard)->check()) return $guard;

        }
    }
    foreach (array_keys(config('auth.guards')) as $guard) {

        if (auth()->guard($guard)->check()) return $guard;

    }
    return null;
}

function send_to_topic($topic_name,$payload_data)
{
    $data = json_encode([
        "to" => "/topics/$topic_name",
        "notification" => [
            "body" => $payload_data['body'],
            "title" => $payload_data['title'],
            "icon" => "ic_launcher",
            "sound" => "default",
            "click_action" => isset($payload_data['click_action']) ? $payload_data['click_action']:"",
        ],
        "data" => [
            "body" => $payload_data['body'],
            "title" => $payload_data['title'],
            "other" => isset($payload_data['other']) ? $payload_data['other']:null,
        ],
    ]);
    //FCM API end-point
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAA5JXGlU0:APA91bGgoCfFBl9vMlFaiGn8h7qwRpdUtDg99LsxmIDJEW-NTida7vmhADeO7W16Znl8ntspEwPSNyug5555qSvZw3q-YnXYnIIa1eCdkUCzh8SWSkH_nyfubRXDR3XgCVoydt_Z9b7w';
    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$server_key
    );
    //CURL request to route notification to FCM connection server (provided by Google)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if ($result === FALSE) {
        \Illuminate\Support\Facades\Log::info('Oops! FCM Send Error: ' . curl_error($ch));
//        Log('Oops! FCM Send Error: ' . curl_error($ch));
    }
    \Illuminate\Support\Facades\Log::info($result);
    curl_close($ch);
}

function daySorter($days)
{
    $new_days = [];
    foreach ($days as $day)
    {
        $new_days[] = \Carbon\Carbon::createFromFormat('d-m', $day)->format('Y-m-d');
    }

    function date_sort($a, $b) {
        return strtotime($a) - strtotime($b);
    }
    usort($new_days, "date_sort");

    return $new_days;
}

function monthSorter($months)
{
    $input = $months;
    $output = array();

    foreach($input as $month) {
        $m = date_parse($month);
        $output[$m['month']] = $month;
    }
    ksort($output);
    return $output;
}

function getLogClass(){
    $class_array = [
        "log-polices",
        "log-poll",
        "log-assessments",
        "log-documents",
        "log-categories",
        "log-users",
        "log-companies",
        "log-departments",
        'log-auth',
    ];

    return $class_array[rand(0, 8)];
}

