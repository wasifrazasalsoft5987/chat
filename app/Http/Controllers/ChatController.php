<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends MainController
{
    public $chatService;

    public function __construct(ChatService $chatService)
    {
        parent::__construct();
        $this->chatService = $chatService;
    }

    public function index(Request $request)
    {
        $chats = $this->chatService->get_chat_list($request);
        return $this->response->success(ChatResource::collection($chats));
    }

    public function unread_list(Request $request)
    {
        $chats = $this->chatService->get_unread_chat_list($request);
        return $this->response->success(ChatResource::collection($chats));
    }

    public function unread_count()
    {
        $count = $this->chatService->get_unread_chat_count();
        return $this->response->success(["count" => $count]);
    }
}
