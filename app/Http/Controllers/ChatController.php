<?php

namespace App\Http\Controllers;

use App\Events\ChatSentEvent;
use App\Interfaces\ChatInterface;
use App\Interfaces\UserInterface;
use App\Jobs\CreateChatJob;
use App\Jobs\MarkMessagesAsReadJob;
use App\Transformers\ChannelsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $userRepositoryInterface;
    protected $chatRepositoryInterface;

    public function __construct
    (
        UserInterface $userRepositoryInterface,
        ChatInterface $chatRepositoryInterface
    )
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->chatRepositoryInterface = $chatRepositoryInterface;
    }


    public function send( Request $request )
    {
        $validated = Validator::make($request->all(), [
            'message' => 'required|max:10000'
        ]);

        if ($validated->fails()) {
            return response()->json([
               "errors" => $validated->errors()
            ], 422);
        }
        $message = $request->message;
        $message_id = Str::uuid();
        $token = $request->header('Authorization');
        event(new ChatSentEvent($this->userRepositoryInterface->getAuthUser($token), $this->userRepositoryInterface->getUser(2), $message, $message_id));
        dispatch(new CreateChatJob($message_id,$this->userRepositoryInterface->getAuthUser($token),$this->userRepositoryInterface->getUser(2), $message,null));
        return $this->successResponse([
            "message" => [
                "from" => [
                    "id" => $this->userRepositoryInterface->getUser(2),
                    "username" => "imanimen"
                ],
            "time" => Carbon::now()->format('Y-m-d h:i:s'),
        ]])->header('X-Header', 'value');
    }


    public function getChats( Request $request )
    {
        $validated = Validator::make($request->all(), [
            'channel_id' => 'required|exists:chat_service_channels,id'
        ]);

        if ($validated->fails()) {
            return response()->json([
               "errors" => $validated->errors()
            ], 422);
        }


        $channel_id = $request->channel_id;
        $token = $request->header('Authorization');
        dispatch(new MarkMessagesAsReadJob($this->userRepositoryInterface->getAuthUser($token), $channel_id));
        return $this->successResponse([
            "messages" => $this->chatRepositoryInterface->getChatMessages($channel_id)
        ]);
        
    }

    public function getChannels( Request $request )
    {
        $token = 123;
        $chats = $this->chatRepositoryInterface->getChatChannels($this->userRepositoryInterface->getAuthUser($token));
        return $this->successResponse([
            "chats" => ChannelsResource::collection($chats),
        ]);
    }

    public function getArchivedChannels ( Request $request )
    {
        $token = 123;
        $chats = $this->chatRepositoryInterface->getArchivedChannels($this->userRepositoryInterface->getAuthUser($token));
        return $this->successResponse([
            "chats" => ChannelsResource::collection($chats),
        ]);
    }

}
