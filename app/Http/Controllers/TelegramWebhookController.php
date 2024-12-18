<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        if ($request->input('message.text')) {
            $user = User::where('otp', $request->message['text'])->first();
            $chatId = $request->input('message.chat.id');
            if ($user) {
                if ($user->otp_expires_at < now()) {
                    $this->sendMessage($chatId, 'Your OTP code has expired. Please request a new one.');
                } else {
                    $user->update([
                        'email_verified_at' => now(),
                        'status'            => 'active',
                        'otp'               => null,
                        'otp_expires_at'    => null,
                        'otp_resend_at'     => null,
                        'id_telegram'       => $chatId,
                    ]);

                    $this->sendMessage($chatId, 'Congratulations! Your email has been verified.');
                }
            } else {
                $this->sendMessage($chatId, 'Invalid OTP code. Please try again.');
                info("User not found (Telegram Webhook)");
            }
        }
    }

    public function sendMessage($chatId, $message)
    {
        $token  = env('TELEGRAM_BOT_TOKEN');
        $url    = "https://api.telegram.org/bot{$token}/sendMessage";

        \Illuminate\Support\Facades\Http::post($url, [
            'chat_id'   => $chatId,
            'text'      => $message,
        ]);
    }
}
