@extends('backend.layouts.app')

@section('title') Manage Menus - {{ $culinary->name }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{ route("backend.culinaries.index") }}' icon='fa-solid fa-utensils'>Culinaries</x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">Manage Menus</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Menu Management for: <strong>{{ $culinary->name }}</strong></h4>
    </div>
    <div class="card-body">
        
        <!-- Add Menu Form -->
        <div class="mb-5 border p-4 rounded bg-light">
            <h5>Add New Menu</h5>
            <form action="{{ route('backend.culinaries.menus.store', $culinary->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nasi Goreng">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" class="form-control" required>
                                <option value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                                <option value="cemilan">Cemilan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" required placeholder="15000">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" name="image" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-success btn-block w-100"><i class="fas fa-plus"></i> Add</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Menu List -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td width="80">
                            @if($menu->image)
                                <img src="{{ $menu->image }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted">No Img</span>
                            @endif
                        </td>
                        <td>{{ $menu->name }}</td>
                        <td>
                            <span class="badge bg-{{ $menu->category == 'makanan' ? 'primary' : ($menu->category == 'minuman' ? 'info' : 'warning') }}">
                                {{ ucfirst($menu->category) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="text-end">
                            <form action="{{ route('backend.culinaries.menus.destroy', [$culinary->id, $menu->id]) }}" method="POST" onsubmit="return confirm('Delete this menu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No menus added yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
