<?php
/**
 * Created by PhpStorm.
 * User: Yang
 * Date: 2017/3/13
 * Time: 10:19
 */
namespace App\Http\Controllers;

use DB;
use App\Models\Contact;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public $module = 'contact';

    public function index()
    {
        return view('cms.contact');
    }

    public function feedback(Request $request)
    {
        if ($request->isMethod('post')) {

            $name = $request->name;
            $email = $request->email;
            $mobile = $request->mobile;
            $message = $request->message;

            if (empty($name) || empty($email) || empty($mobile) || empty($message)) {
                return ['errcode' => 1, 'errmsg' => '请填写信息'];
            }
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if ( ! preg_match( $pattern, $email)) {
                return ['errcode' => 1, 'errmsg' => '请输入正确的邮箱格式'];
            }
            $pattern_mobile = "/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/";
            if ( ! preg_match($pattern_mobile, $mobile)) {
                return ['errcode' => 1, 'errmsg' => '请输入正确的手机格式'];
            }

            $created = date('Y-m-d H:i:s', time());
            $updated = date('Y-m-d H:i:s', time());
            DB::insert('insert into `contact` (`name`, `email`, `mobile`, `message`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)', [$name, $email, $mobile, $message, $created, $updated]);
            return ['errcode' => 0, 'errmsg' => '提交成功'];

        } else {
            return ['errcode' => 1, 'errmsg' => '提交失败'];
        }
    }

}