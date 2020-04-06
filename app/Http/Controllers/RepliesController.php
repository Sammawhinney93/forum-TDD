<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param integer $channelId
     * @param Thread $thread
     * @return RedirectResponse
     */
    public function store($channelId, Thread $thread): RedirectResponse
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }
}
