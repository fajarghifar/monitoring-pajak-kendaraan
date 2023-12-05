<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Office;
use App\Models\Inventory;
use Illuminate\View\View;
use App\Enums\BrandCategory;
use Illuminate\Http\Request;
use App\Models\InventoryDetail;
use App\Enums\InventoryCategory;
use App\Exports\InventoriesExport;
use App\Imports\InventoriesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Inventory\StoreInventoryRequest;
use App\Http\Requests\Inventory\UpdateInventoryRequest;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $perPage = (int) request('row', 10);

        abort_if($perPage < 1 || $perPage > 25, 404);

        $inventories = Inventory::with(['brand', 'office'])
            ->filter(request(['search']))
            ->paginate($perPage)
            ->appends(request()->query());

        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()  : View
    {
        return view('inventories.create', [
            'users' => User::all(),
            'categories' => InventoryCategory::cases(),
            'brands' => Brand::where('category', '=', BrandCategory::ELEKTRONIK)->get(),
            'offices' => Office::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryRequest $request) : RedirectResponse
    {
        $inventory = Inventory::create($request->all());

        /**
         * Handle upload image
         */
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            $file->storeAs('inventory/', $filename, 'public');
            $inventory->update([
                'photo' => $filename
            ]);
        }

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Inventaris berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)  : View
    {
        $inventory_details = InventoryDetail::with(['user'])
            ->where('inventory_id', $inventory->id)
            ->orderByDesc('id')
            ->get();

        return view('inventories.show', [
            'inventory' => $inventory,
            'inventory_details' => $inventory_details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory) : View
    {
        $inventory_details = InventoryDetail::with(['user'])
            ->where('inventory_id', $inventory->id)
            ->orderByDesc('id')
            ->get();

        $inventory_detail_current = $inventory_details->first() ?? 0 ;

        return view('inventories.edit', [
            'inventory' => $inventory,
            'inventory_details' => $inventory_details,
            'inventory_detail_current' => $inventory_detail_current,

            'categories' => InventoryCategory::cases(),
            'brands' => Brand::where('category', '=', BrandCategory::ELEKTRONIK)->get(),
            'offices' => Office::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory) : RedirectResponse
    {
        $inventory->update($request->except('photo'));

        /**
         * Handle upload an image
         */
        if($request->hasFile('photo')){
            $photoPath = public_path('storage/inventory/') . $inventory->photo;

            // Delete Old Photo
            if(file_exists($photoPath) && is_file($photoPath)){
                unlink($photoPath);
            }

            // Prepare New Photo
            $file = $request->file('photo');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store an image to Storage
            $file->storeAs('inventory/', $fileName, 'public');

            // Save DB
            $inventory->update([
                'photo' => $fileName
            ]);
        }

        return redirect()
            ->route('inventories.edit', $inventory->id)
            ->with('success', 'Inventaris berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory) : RedirectResponse
    {
        // Menggunakan metode delete() pada instance model $inventory untuk menghapus data
        $inventory->delete();

        // Menggunakan metode where() dengan operator '=' untuk mencari data yang sesuai
        InventoryDetail::where('inventory_id', $inventory->id)->delete();

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Inventaris berhasil dihapus!');
    }

    // Import Excel
    public function import(Request $request)
    {
        return view('inventories.import');
    }

    public function importHandler(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new InventoriesImport, $file);

        return redirect()
            ->route('inventories.index')
            ->with('success', 'Excel file imported successfully!');
    }

    // Excel Export
    public function export(){
        $file_name = 'inventories_'.date('Y_m_d_H_i_s').'.xlsx';
        return Excel::download(new InventoriesExport, $file_name);
    }
}
