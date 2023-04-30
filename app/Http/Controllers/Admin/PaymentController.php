<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderByDesc('id')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }
    /* public function create()
    {
    } */
    /* public function store(Request $request)
    {
    } */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }
    /* public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.edit', compact('payment'));
    } */
    /* public function update(Request $request, $id)
    {
        $request->validate([
            'notic' => 'required',
        ]);

        $chat = Payment::findOrFail($id);

        $chat->update([
            'notic' => $request->notic,
        ]);
        return redirect()->route('admin.group_chats.index')->with('msg', 'Group Chat Note updated successfully')->with('type', 'success');
    } */
}
