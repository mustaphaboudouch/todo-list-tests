<?php

namespace App\Http\Controllers;

use App\Http\Services\EmailSenderService;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $todoList = $request->user()->todoList;

        return view('items.index', [
            'items' => $todoList->items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $todoList = $request->user()->todoList;

        // user can only create 10 items
        if ($todoList->items()->count() === 10) {
            return redirect()->route('items.index')
                ->with('status', 'You can only create 10 items.');
        }

        // validate item creating date
        if ($todoList->items()->count() > 0) {
            $item = $todoList->items()->orderBy('created_at', 'DESC')->first();
            $now = Carbon::now();
            $diff = $now->diffInMinutes($item->created_at);
            $rest = 30 - $diff;

            if ($diff < 30) {
                return redirect()->route('items.index')
                    ->with('status', 'Wait for ' .  $rest . ' min.');
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $todoList->items()->create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        // Mock: warn user that remains only 2 items to create
        if ($todoList->items()->count() === 8) {
            EmailSenderService::sendEmail();
        }

        return redirect()->route('items.index')
            ->with('status', 'The item has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): View
    {
        return view('items.show', [
            'item' => $item,
        ]);
    }
}
