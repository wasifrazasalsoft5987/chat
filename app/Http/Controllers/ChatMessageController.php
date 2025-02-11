<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\ChatMessageService;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatMessageController extends MainController
{
    public $chatService;
    public $messageService;

    public function __construct(ChatMessageService $messageService, ChatService $chatService)
    {
        parent::__construct();
        $this->chatService = $chatService;
        $this->messageService = $messageService;
    }

    public function index($id)
    {
        $chat = $this->chatService->get_chat($id);
        $messages = $this->messageService->getChatMessages($chat);
        return $this->response->success(MessageResource::collection($messages));
    }

    public function send_message(MessageRequest $request, $id)
    {
        // $chat = $this->chatService->get_chat($id);
        // $message = $this->messageService->sendMessage($chat, $request);
        // return $this->response->success(new MessageResource($message));
    }
}
