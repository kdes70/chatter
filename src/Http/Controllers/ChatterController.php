<?php

namespace Kdes70\Chatter\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Kdes70\Chatter\Events\NewConversationMessage;
use Kdes70\Chatter\Http\Resources\ConversationResource;
use Kdes70\Chatter\Http\Resources\MessageListsResource;
use Kdes70\Chatter\Http\Resources\MessageResource;
use Kdes70\Chatter\Http\Resources\MessagesCollection;
use Kdes70\Chatter\Services\ChatterService;

class ChatterController extends Controller
{
    /**
     * @var ChatterService
     */
    private $service;

    private $user;

    /**
     * Create a new controller instance.
     * @param ChatterService $service
     */
    public function __construct(ChatterService $service)
    {
        $this->middleware(['auth']);

        $this->middleware(function ($request, $next) {
            $this->user = auth()->check() ? auth()->user() : null;
            return $next($request);
        });

        $this->service = $service;

    }

//    /**
//     * Show the application dashboard.
//     *
//     * @return ConversationsCollection
//     */
//    public function index()
//    {
//
//        return view('chatter::chat');
//    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function conversations()
    {
        return view('chatter::chat_conversations');
    }


    /**
     * @param $conversation_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function conversationId($conversation_id)
    {
        return view('chatter::chat_conversations', ['conversation_id' => $conversation_id]);
    }

    /**
     * @param $conversation_id
     * @return MessageListsResource
     */
    public function getMessages($conversation_id)
    {
        $messages = $this->service->getConversationMessageById($this->user->id, $conversation_id);

        return new MessageListsResource($messages);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getConversationList()
    {
        $conversation_list = $this->service->getAllConversations($this->user->id);

        return ConversationResource::collection($conversation_list);
    }


    /**
     * @param $recipient_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newConversation($recipient_id)
    {
        $conversation = $this->service->startOrGetConversationByRecipient($this->user->id, $recipient_id);


        if ($conversation) {
            return redirect()->route('conversation', ['recipient_id' => $conversation->id]);
        }
    }


    /**
     * @param Request $request
     */
    public function send(Request $request)
    {

        $result = $this->service->sendConversationMessage(
            $this->user->id,
            $request->input('conversation_id'),
            $request->input('message'),
            $request->input('receiver_id')
        );

        if ($result) {

            broadcast(new NewConversationMessage($result['created'], $result['channel'], $this->user->id));

            return new MessageResource($result['created']);
        }
    }


}
