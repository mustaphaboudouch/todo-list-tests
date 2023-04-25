<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $todoList = $request->user()->todoList;
        $todoList->items()->create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

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
