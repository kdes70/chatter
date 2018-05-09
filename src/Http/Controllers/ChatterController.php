<?php

namespace Kdes70\Chatter\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kdes70\Chatter\Facades\Chatter;
use Kdes70\Chatter\Services\ChatterService;

class ChatterController extends Controller
{
    /**
     * @var ChatterService
     */
    private $service;

    /**
     * Create a new controller instance.
     * @param ChatterService $service
     */
    public function __construct(ChatterService $service)
    {
        $this->middleware(['auth']);

        $this->service = $service;

        dd( $this->service);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO понять почему не определяется в конструкторе
        $user_id = auth()->check() ? auth()->user()->id : null;

        $conversations = $this->service->getAllConversations($user_id);

        return view('chatter::chat')->with([
            'conversations' => $conversations,
        ]);
    }

    /**
     * @param $conversation_id
     */
    public function chat($conversation_id)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;

        $conversation = Chatter::getConversationMessageById($user_id);

//        return view('chat')->with([
//            'conversation' => $conversation
//        ]);
    }

    public function newConversation($recipient_id)
    {

    }

    public function send(Request $request)
    {
        $user_id = auth()->check() ? auth()->user()->id : null;

        Chatter::sendConversationMessage($user_id, $request->input('conversationId'), $request->input('text'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
