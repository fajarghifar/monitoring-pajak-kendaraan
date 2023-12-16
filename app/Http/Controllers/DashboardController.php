<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Inventory;
use Illuminate\View\View;
use App\Enums\VehicleStatus;
use App\Enums\InventoryStatus;
use App\Models\InventoryDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    private function adminDashboard()
    {
        $vehiclesCount = Vehicle::count();
        $borrowedVehiclesCount = Vehicle::where('status', VehicleStatus::DIPINJAM)->count();
        $inventoriesCount = Inventory::count();
        $borrowedInventoriesCount = Inventory::where('status', InventoryStatus::DIPINJAM)->count();
        $usersCount = User::count();

        $userVehiclesCount = Auth::user()->vehicles->count();
        $userInventoriesCount = Auth::user()->inventories->count();

        return view('dashboard.admin-dashboard', compact('vehiclesCount', 'borrowedVehiclesCount', 'inventoriesCount', 'borrowedInventoriesCount', 'usersCount', 'userVehiclesCount', 'userInventoriesCount'));
    }

    private function userDashboard()
    {
        $userVehiclesCount = Auth::user()->vehicles->count();
        $userInventoriesCount = Auth::user()->inventories->count();

        return view('dashboard.user-dashboard', compact('userVehiclesCount', 'userInventoriesCount'));
    }

    public function showMyInventories(): View
    {
        $userInventories = Auth::user()->load('inventories')->inventories;

        return view('my.inventories', compact('userInventories'));
    }

    public function showMyInventoryDetail(Inventory $inventory): View
    {
        return view('my.inventory-detail', compact('inventory'));
    }

    public function showMyVehicles(): View
    {
        $userVehicles = Auth::user()->load('vehicles')->vehicles;

        return view('my.vehicles', compact('userVehicles'));
    }

    public function showMyVehicleDetail(Vehicle $vehicle): View
    {
        return view('my.vehicle-details', compact('vehicle'));
    }
}
