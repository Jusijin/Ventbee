<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // 1. Dashboard Admin (List Event)
    public function index(Request $request){
        $query = Event::with('category');

        // Filter dari Status
        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        // Filter dari kategori
        if($request->filled('keyword')){
            $query->where('event_name', 'like', '%' . $request->keyword . '%');
        }

        $show = $request->input('show', 10);

        $events = $query->orderBy('date', 'desc')
                        ->paginate($show)
                        ->appends($request->all());

        $categories = Category::all();

        return view('page.admin.dashboard', compact('events', 'categories'));
    }

    // 2. Halaman Tambah Event
    public function create(){
        $categories = Category::orderBy('name')->get();

        return view('page.admin.create', compact('categories'));
    }

    // 3. Proses Simpan Event Baru
    public function store(Request $request){
        // 1. Validasi (Ganti category_id jadi category_name)
        $request->validate([
            'event_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'registration_open' => 'required|date',
            'registration_close' => 'required|date|after:registration_open',
            'location' => 'required|string',
            'description' => 'required|string',
            'total_quota' => 'required|numeric|min:1',
            'status' => 'required|in:open,closed,on_progress,finished',
        ]);

        // 3. Simpan Event dengan ID Kategori yang didapat
        Event::create([
            'category_id' => $request->category_id, // Pakai ID dari proses di atas
            'event_name' => $request->event_name,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'registration_open' => $request->registration_open,
            'registration_close' => $request->registration_close,
            'total_quota' => $request->total_quota,
            'status' => $request->status,
            'quota_taken' => 0,
            'role' => 'user',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', __('admindash.event_created'));
    }

    // 4. Halaman Edit
    public function edit($id){
        $event = Event::findOrFail($id);
        $categories = Category::all();
        return view('page.admin.edit', compact('event', 'categories'));
    }

    // 5. Proses Update
    public function update(Request $request, $id){
        $event = Event::findOrFail($id);

        $request->validate([
            'event_name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'registration_open' => 'required|date',
            'registration_close' => 'required|date|after:registration_open',
            'date' => 'required|date',
            'location' => 'required',
            'description' => 'required',
            'total_quota' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        if($request->has('category_name')){
             $category = Category::firstOrCreate(
                ['name' => $request->category_name],
                ['slug' => Str::slug($request->category_name)]
            );
            
            $request->merge(['category_id' => $category->id]);
        }

        $event->update($request->except('category_name'));

        return redirect()->route('admin.dashboard')->with('success', __('admindash.event_updated'));
    }

    // 6. Proses Hapus
    public function destroy($id)
    {
        Event::destroy($id);
        return redirect()->back()->with('success', __('admindash.event_deleted'));
    }

    // 7. Lihat Peserta (Participants)
    public function participants($id)
    {
        $event = Event::with('participants')->findOrFail($id);
        return view('page.admin.participants', compact('event'));
    }
}