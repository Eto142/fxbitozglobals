<?php

namespace App\Http\Controllers\Admin;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalSubmitted;
use App\Http\Controllers\Controller;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::join('users', 'withdrawals.user_id', '=', 'users.id')
            ->select('withdrawals.*', 'users.name as name', 'users.email as user_email') // You can select any user fields you need
            ->get();

        return view('admin.manage_withdrawal', compact('withdrawals'));
    }


    public function edit($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        return view('admin.withdrawals.edit', compact('withdrawal'));
    }

    public function update(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->update($request->all());
        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal updated successfully');
    }

    public function destroy($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->delete();
        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal deleted successfully');
    }

    // public function approve($id)
    // {
    //     $withdrawal = Withdrawal::findOrFail($id);
    //     $withdrawal->update(['status' => '1']);
    //     return redirect()->route('withdrawals.index')->with('success', 'Withdrawal approved successfully');
    // }
    
    
    
//     public function approve(Request $request, $id)
// {
//     $request->validate([
//         'status' => 'required|in:0,1,2',
//     ]);

//     $withdrawal = Withdrawal::findOrFail($id);
//     $withdrawal->update(['status' => $request->status]);

//     // Optional: message that matches status
//     $message = match ($request->status) {
//         '0' => 'Withdrawal marked as Processing',
//         '1' => 'Withdrawal approved successfully',
//         '2' => 'Withdrawal marked as Pending',
//         default => 'Status updated successfully',
//     };

//     return redirect()->route('withdrawals.index')->with('success', $message);
// }





// public function approve(Request $request, $id)
// {
//     $request->validate([
//         'status' => 'required|in:0,1,2',
//     ]);

//     $withdrawal = Withdrawal::with('user')->findOrFail($id);
//     $withdrawal->status = $request->status;
//     $withdrawal->save();

//     /**
//      * ===============================
//      * SEND EMAILS ONLY IF SUCCESSFUL
//      * ===============================
//      */
//     if ($request->status == 1) {

//         $user = $withdrawal->user;

//         // Receiver email (if exists in details or stored column)
//         $receiverEmail = $withdrawal->receiver_email ?? null;

//         // 1️⃣ Receiver → Transfer Successful
//         if ($receiverEmail) {
//             Mail::to($receiverEmail)
//                 ->send(new WithdrawalSubmitted($withdrawal, 'receiver_success'));
//         }

//         // 2️⃣ Support → Transfer Successful
//         Mail::to('support@fxbitozglobals.com')
//             ->send(new WithdrawalSubmitted($withdrawal, 'support_success'));

//         // 3️⃣ User (Sender) → Account Credited
//         Mail::to($user->email)
//             ->send(new WithdrawalSubmitted($withdrawal, 'user_credited'));
//     }

//     /**
//      * ===============================
//      * FLASH MESSAGE
//      * ===============================
//      */
//     $message = match ($request->status) {
//         '0' => 'Transfer marked as Processing',
//         '2' => 'Transfer marked as Pending',
//         '1' => 'Transfer completed successfully',
//         default => 'Status updated successfully',
//     };

//     return redirect()
//         ->route('withdrawals.index')
//         ->with('success', $message);
// }





public function approve(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:0,1,2',
    ]);

    $withdrawal = Withdrawal::with('user')->findOrFail($id);
    $withdrawal->status = $request->status;
    $withdrawal->save();

    // Only send emails if completed
    if ($request->status == 1) {

        $user = $withdrawal->user;

        // Extract receiver email safely
        $receiverEmail = $withdrawal->receiver_email ?? null;

        // 1️⃣ Receiver → sees Sender Name
        if ($receiverEmail) {
            Mail::to($receiverEmail)
                ->send(new \App\Mail\WithdrawalSubmitted($withdrawal, 'receiver'));
        }

        // 2️⃣ Support → can see both
        Mail::to('support@fxbitozglobals.com')
            ->send(new \App\Mail\WithdrawalSubmitted($withdrawal, 'support'));

        // 3️⃣ Sender → sees Recipient Name
        Mail::to($user->email)
            ->send(new \App\Mail\WithdrawalSubmitted($withdrawal, 'sender'));
    }

    // Flash message
    $message = match ($request->status) {
        '0' => 'Transfer marked as Processing',
        '2' => 'Transfer marked as Pending',
        '1' => 'Transfer completed successfully',
        default => 'Status updated successfully',
    };

    return redirect()
        ->route('withdrawals.index')
        ->with('success', $message);
}





}
