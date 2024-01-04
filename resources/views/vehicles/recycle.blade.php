@extends('layouts.dashboard')

@section('content')
<div class="page-body">
    <div class="container-xl">

        <x-alert/>

        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <i class="fa-solid fa-trash me-2"></i>
                        {{ __('Recycle Kendaraan') }}
                    </h3>
                </div>

                {{-- <div class="card-actions btn-group">
                    <div class="dropdown">
                        <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="{{ route('vehicles.import.view') }}" class="dropdown-item">
                                <i class="fa-solid fa-file-import me-2"></i>
                                {{ __('Import Kendaraan') }}
                            </a>
                            <a href="{{ route('vehicles.export') }}" class="dropdown-item">
                                <i class="fa-solid fa-file-export me-2"></i>
                                {{ __('Export Kendaraan') }}
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="card-body border-bottom py-3">
                <form action="{{ route('vehicles.recycle.show') }}" method="GET">
                    <div class="d-flex">
                        <div class="text-secondary">
                            Tampilkan
                            <div class="mx-2 d-inline-block">
                                <select class="form-select form-select-sm" aria-label="result per page" name="row">
                                    <option value="10" {{ request('row') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request('row') == '15' ? 'selected' : '' }}>15</option>
                                    <option value="25" {{ request('row') == '25' ? 'selected' : '' }}>25</option>
                                </select>
                            </div>
                            baris
                        </div>
                        <div class="ms-auto text-secondary">
                            Cari:
                            <div class="ms-2 d-inline-block input-icon">
                                <input type="text"class="form-control form-control-sm" aria-label="Search…" placeholder="Search…" name="search" value="{{ request('search') }}">
                                <span class="input-icon-addon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th class="align-middle w-1">
                                {{ __('No') }}
                            </th>
                            <th scope="col" class="align-middle">
                                {{ __('Nomor STNK') }}
                            </th>
                            <th scope="col" class="align-middle">
                                {{ __('Nomor Polisi') }}
                            </th>
                            <th scope="col" class="align-middle">
                                {{ __('Brand') }}
                            </th>
                            <th scope="col" class="align-middle">
                                @sortablelink('model', 'Model')
                            </th>
                            <th scope="col" class="align-middle">
                                @sortablelink('category', 'Kategori')
                            </th>
                            <th scope="col" class="align-middle">
                                {{ __('Kantor') }}
                            </th>
                            <th scope="col" class="align-middle">
                                {{ __('Aksi') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td class="align-middle">
                                {{ ($vehicles->currentPage() - 1) * $vehicles->perPage() + $loop->iteration }}
                            </td>

                            <td class="align-middle">
                                {{ $vehicle->stnk_number }}
                            </td>
                            <td class="align-middle">
                                {{ $vehicle->license_plate }}
                            </td>
                            <td class="align-middle">
                                {{ $vehicle->brand->name }}
                            </td>
                            <td class="align-middle">
                                {{ $vehicle->model }}
                            </td>
                            <td class="align-middle">
                                {{ $vehicle->category->label() }}
                            </td>
                            <td class="align-middle">
                                {{ $vehicle->office->code }} - {{ $vehicle->office->name }}
                            </td>
                            <td class="align-middle" style="width: 10%">
                                <x-button.restore class="btn-icon" route="{{ route('vehicles.recycle.restore', $vehicle) }}"/>
                                <x-button.delete class="btn-icon" route="{{ route('vehicles.recycle.delete', $vehicle) }}"/>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="align-middle text-center" colspan="9">
                                <div class="empty">
                                    <p class="empty-title">
                                        Tidak ditemukan kendaraan!
                                    </p>
                                    <p class="empty-subtitle text-secondary">
                                        Coba sesuaikan pencarian atau filter Anda untuk menemukan apa yang sedang Anda cari.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-secondary">
                    Showing <span>{{ $vehicles->firstItem() }}</span>
                    to <span>{{ $vehicles->lastItem() }}</span> of <span>{{ $vehicles->total() }}</span> entries
                </p>

                <ul class="pagination m-0 ms-auto">
                    {{ $vehicles->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection