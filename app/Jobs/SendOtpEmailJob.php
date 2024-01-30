<?php
namespace App\Jobs;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendOtpEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $otp = $this->generateOTP();

        // Job to send email with OTP
        Mail::to($this->user->email)->send(new OtpMail($this->user, $otp));

        // save into rediss
        $this->saveOtpIntoRedis($otp);
    }

    private function generateOTP($length = 6)
    {
        // Set the character pool for the OTP
        $characters = '0123456789';

        // Get the length of the character pool
        $charLength = strlen($characters);

        // Initialize the OTP variable
        $otp = '';

        // Generate the OTP
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, $charLength - 1)];
        }

        return $otp;
    }

    private function saveOtpIntoRedis($otp)
    {
        $key = "OTP-email_" . $this->user->email;
        $expTime = 300;

        Redis::setex($key, $expTime, $otp);
    }
}