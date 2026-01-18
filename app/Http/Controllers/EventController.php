<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Category;
use App\Models\EventParticipant;
use App\Notifications\RegistrationSuccess;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category');

        // Filter by Status
        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        // Filter by Kategori
        if($request->filled('category')){
            $query->where('category_id', $request->category);
        }

        // Filter by Pencarian nama Event
        if($request->filled('keyword')){
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Show per halaman
        $showPage = $request->get('show', 10);

        $events = $query->orderBy('created_at', 'desc')
                        ->paginate($showPage)
                        ->withQueryString();
        
        $categories = Category::all();
        
        // $search = $request->search;

        // $events = Event::with('category')
        //     ->when($search, function($query, $search){
        //         $query->where('event_name','like',"%{$search}%")
        //             ->orWhere('location','like',"%{$search}%")
        //             ->orWhereHas('category', function($q) use ($search){
        //                     $q->where('name','like',"%{$search}%");
        //             });
        //     })
        //     ->orderBy('date','asc')
        //     ->paginate(10);

        return view('events.index', compact('events', 'categories'));
    }

    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('page.events.create', compact('categories'));
    // }

    public function show(Event $event)
    {
        $user = auth()->user();

        $isRegistered = $event->participants()
        ->where('user_id', $user->id)
        ->exists();

        return view('events.detail', compact('event', 'isRegistered'));
    }

    public function register(Event $event)
    {
        $user = auth()->user();
        $now  = Carbon::now();

        // Event selesai
        if ($event->status === 'finished') {
            return back()->with('error', 'Event sudah selesai');
        }

        // Registrasi belum dibuka
        if ($event->registration_open && $now->lt($event->registration_open)) {
            return back()->with('error', 'Pendaftaran belum dibuka');
        }

        // egistrasi sudah ditutup
        if ($event->registration_close && $now->gt($event->registration_close)) {
            return back()->with('error', 'Pendaftaran sudah ditutup');
        }

        // Kuota penuh
        if ($event->quota_taken >= $event->total_quota) {
            return back()->with('error', 'Kuota sudah penuh');
        }

        // Sudah terdaftar
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Anda sudah terdaftar pada event ini');
        }

        // Simpan ke pivot
        $event->participants()->attach($user->id, [
            'status' => 'registered_success',
            'joined_at' => now(),
        ]);

        // Update kuota
        $event->increment('quota_taken');

        return back()->with('success', 'Berhasil mendaftar event');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Event $event)
    // {
    //     if($event->created_by !== auth()->id()){
    //         abort(403);
    //     }

    //     $categories = Category::all();

    //     return view('page.events.edit', compact('categories'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateEventRequest $request, Event $event)
    // {
    //     if($event->created_by !== auth()->id()){
    //         abort(403);
    //     }

    //     $event->update($request->validate());

    //     return redirect()->route('events.index')->with('success','Event telah berhasil diperbarui');
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Event $event)
    // {
    //     if($event->created_by !== auth()->id()){
    //         abort(403);
    //     }

    //     $event->delete();

    //     return back()->with('success','Event telah berhasil dihapus');
    // }


    /**
     * User mendaftar ke event.
     */
    // public function join(Event $event)
    // {
    //     $user = auth()->user();

    //     // 1. Cek apakah user sudah daftar
    //     $isRegistered = \App\Models\EventParticipant::where('user_id', $user->id)
    //         ->where('event_id', $event->id)
    //         ->exists();

    //     if ($isRegistered) {
    //         return back()->with('error', 'Anda sudah terdaftar di event ini.');
    //     }

    //     // 2. Cek kuota (Opsional, sesuaikan kebutuhan)
    //     if ($event->quota_taken >= $event->total_quota) {
    //         return back()->with('error', 'Kuota event sudah penuh.');
    //     }

    //     // 3. Simpan ke tabel participants
    //     \App\Models\EventParticipant::create([
    //         'user_id' => $user->id,
    //         'event_id' => $event->id,
    //         'status' => 'registered_success', // Sesuai enum di migration Anda
    //         'joined_at' => now(),
    //     ]);

    //     // 4. Update kuota event
    //     $event->increment('quota_taken');

    //     // 5. KIRIM NOTIFIKASI
    //     // Pastikan model User punya trait "use Notifiable" (biasanya default Laravel sudah ada)
    //     $user->notify(new \App\Notifications\RegistrationSuccess($event));

    //     return back()->with('success', 'Pendaftaran berhasil! Cek notifikasi Anda.');
    // }
}
