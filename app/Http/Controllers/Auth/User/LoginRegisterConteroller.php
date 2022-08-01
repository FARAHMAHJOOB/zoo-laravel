<?php

namespace App\Http\Controllers\Auth\User;

use Carbon\Carbon;
use App\Models\Otp;
use Illuminate\Support\Str;
use App\Models\Admin\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Requests\Auth\User\LoginRegisterRequest;

class LoginRegisterConteroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function LoginRegisterForm()
    {
        return view('user.auth.login-register');
    }

    public function LoginRegister(LoginRegisterRequest $request)
    {
        $inputs = convertPersianToEnglish($request->validated());
        //check id is email or not
        if (filter_var($inputs['id'], FILTER_VALIDATE_EMAIL)) {
            $type = 1; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['id'];
            }
        }
        //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])) {
            $type = 0; // 0 => mobile;
            // all mobile numbers are in on format 9** *** ***
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);
            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['id'];
            }
        } else {
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            return redirect()->route('auth.user.login-register-form')->withErrors(['id' => $errorText]);
        }
        if (empty($user)) {
            $newUser['password'] = '98355154';
            $newUser['activation'] = 1;
            $newUser['status'] = 1;
            $user = User::create($newUser);
        } elseif ($user->status == 0) {
            return to_route('auth.user.login-register-form')->withErrors(['id' => 'دسترسی شما مسدود شده است']);
        }
        return $this->createOtpAndSend($user, $inputs['id'] , $type);

    }

    public function LoginRegisterConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return to_route('auth.user.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر می باشد']);
        }
        return view('user.auth.login-register-confirm', compact('token', 'otp'));
    }
    public function LoginRegisterConfirm(LoginRegisterRequest $request, $token)
    {
        $inputs = $request->validated();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(2)->toDateTimeString())->first();
        if (empty($otp)) {
            return to_route('auth.user.login-register-confirm-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر می باشد']);
        }
        //if otp not match
        if ($otp->otp_code !== $inputs['otp']) {
            return to_route('auth.user.login-register-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نمی باشد']);
        }
        // if everything is ok :
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if ($otp->type == 0 && empty($user->mobile_verified_at)) {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        } elseif ($otp->type == 1 && empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return to_route('home');
    }
    public function LoginRegisterResendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(2)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('auth.user.login-register-form', $token)->withErrors(['id' => 'ادرس وارد شده نامعتبر می باشد']);
        }
        $user = $otp->user()->first();
        return $this->createOtpAndSend($user, $otp->login_id , $otp->type);
    }

    protected function createOtpAndSend($user, $login_id , $type)
    {
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(50);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $login_id,
            'type' => $type,
        ];
        Otp::create($otpInputs);
        //send sms or email
        if ($type == 0) {
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText("باغ وحش \n  کد تایید : $otpCode");
            $smsService->setIsFlash(true);
            $messagesService = new MessageService($smsService);
        } elseif ($type === 1) {
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' => "کد فعال سازی شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($login_id);
            $messagesService = new MessageService($emailService);
        }
        $messagesService->send();
        return to_route('auth.user.login-register-confirm-form', $token);
    }

    public function Logout()
    {
        Auth::logout();
        return to_route('home');
    }
}
