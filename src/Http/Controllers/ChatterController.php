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
        //$this->middleware(['web','auth']);

        $this->service = $service;
//


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $onversations = $this->service->getAllConversations();

        return view('chatter::chat')->with([
            'conversations' => $onversations,
        ]);
    }

    /**
     * @param $conversation_id
     */
    public function chat($conversation_id)
    {
        $conversation = Chatter::getConversationMessageById($conversation_id);

//        return view('chat')->with([
//            'conversation' => $conversation
//        ]);
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
