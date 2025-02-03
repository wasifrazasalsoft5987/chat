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
        $chats = $this->chatService->getChatList($request);
        return $this->response->success(ChatResource::collection($chats));
    }

    public function unread_list(Request $request)
    {
        $chats = $this->chatService->getUnreadChatList($request);
        return $this->response->success(ChatResource::collection($chats));
    }

    public function unread_count()
    {
        $chats = $this->chatService->getUnreadChatCount();
        return $this->response->success(["count" => $chats]);
    }

    // public function get_chat()
    // {
    //     $chat = Chat::with('users', 'messages')->first();
    //     $isUser = $chat->users()->where('user_id', auth()->id())->first();

    //     if (!$isUser) {
    //         $chat->users()->attach(auth()->id(), [
    //             'is_admin'   => false,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //     }

    //     $messages = $chat->messages()->latest()->paginate(25);
    //     return $this->response->success(
    //         MessageResource::collection($messages)->response()->getData(true)
    //     );
    // }

    // public function send_message(MessageRequest $request)
    // {
    //     $chat = Chat::with('users', 'messages')->first();
    //     $isUser = $chat->users()->where('user_id', auth()->id())->first();

    //     if (!$isUser) {
    //         $chat->users()->attach(auth()->id(), [
    //             'is_admin'   => false,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //     }

    //     // $chat->messages()->whereNull('read_at')->where('user_id', '!=', auth()->id())->update(['read_at' => now()]);

    //     $message = $chat->messages()->create([
    //         'user_id' => auth()->id(),
    //         'message' => $request->message ?? null,
    //     ]);

    //     return $this->response->success(new MessageResource($message));
    // }

    // public function create_chat(Request $request)
    // {
    //     $request->validate(['user_id' => 'required|exists:users,id']);

    //     $chat = Chat::with('users')
    //         ->whereHas('users', function ($query) use ($request) {
    //             $query->where('user_id', auth()->id());
    //         })
    //         ->whereHas('users', function ($query) use ($request) {
    //             $query->where('user_id', $request->user_id);
    //         })
    //         ->first();

    //     if ($chat)
    //         return $this->response->success(new ChatResource($chat));

    //     DB::beginTransaction();
    //     $chat = Chat::create(['type' => Constant::CHAT_PRIVATE]);

    //     $chat->users()->attach(auth()->id(), [
    //         'is_admin'   => false,
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);

    //     $chat->users()->attach($request->user_id, [
    //         'is_admin'   => false,
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);
    //     DB::commit();

    //     return $this->response->success(new ChatResource($chat));
    // }
}
