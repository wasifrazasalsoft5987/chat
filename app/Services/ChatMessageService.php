<?php

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class ChatMessageService extends BaseService
{
    public function getChatMessages($chat)
    {
        $messages = $chat->messages()->latest()->paginate($this->pagination);
        return $messages;
    }

    public function sendMessage($chat, $request)
    {
    }
}