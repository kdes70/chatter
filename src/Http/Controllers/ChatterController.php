<?php

namespace Kdes70\Chatter\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kdes70\Chatter\Facades\Chatter;
use Kdes70\Chatter\Http\Resources\ConversationsCollection;
use Kdes70\Chatter\Http\Resources\Messages;
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
            $this->user = auth()->check() ? auth()->user()->id : null;
            return $next($request);
        });

        $this->service = $service;

    }

    /**
     * Show the application dashboard.
     *
     * @return ConversationsCollection
     */
    public function index()
    {
        return view('chatter::chat');
    }


    /**
     * @return ConversationsCollection
     */
    public function conversations()
    {
        $conversations = $this->service->getAllConversations($this->user);

        return new ConversationsCollection($conversations);
    }

    /**
     * @param $conversation_id
     * @return Messages
     */
    public function chat($conversation_id)
    {
        $conversation = $this->service->getConversationMessageById($this->user, $conversation_id);

        return new Messages($conversation);
    }


    /**
     * @param Request $request
     */
    public function send(Request $request)
    {
       return $this->service->sendConversationMessage(
            $this->user,
            $request->input('conversation_id'),
            $request->input('message'),
            $request->input('receiver_id')
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
