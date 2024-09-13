<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function supportIndex()
    {
        $title = "Support Tickets";
        $tickets = SupportTicket::with('user')->get();
        return view('admin.tickets', compact('title', 'tickets'));
    }

    public function readTicket($id)
    {
        $ticket = SupportTicket::with('user')->findOrFail($id);
        return response()->json(['ticket' => $ticket]);
    }

    public function updateTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = $request->input('status');

        try{
            $ticket->save();
            return redirect()->back()->with('success', 'Ticket updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Ticket!');
        } 

    }

    public function ticketDelete($id)
    {
        try {
            $ticket = SupportTicket::findOrFail($id);
            $ticket->delete();

            if($ticket){
                $ticket->delete();
            }

            return redirect()->back()->with('success','Ticket Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Ticket!');
        }
    }
}
