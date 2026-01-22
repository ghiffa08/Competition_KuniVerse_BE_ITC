@extends("backend.layouts.app")

@section("title")
    @lang("Dashboard")
@endsection

@push('after-styles')
<style>
    :root {
        --primary-gold: #C19D60;
        --primary-gold-hover: #a6854e;
        --dark-bg: #1e2129;
        --card-bg: #ffffff;
    }
    
    .merchant-welcome {
        background: linear-gradient(135deg, #15171e 0%, #2a2d36 100%);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .merchant-welcome::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: var(--primary-gold);
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
    }

    .stat-card {
        border: none;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        overflow: hidden;
        height: 100%;
        position: relative;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }
    
    .stat-card.wisata .icon-wrapper { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .stat-card.kuliner .icon-wrapper { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .stat-card.umkm .icon-wrapper { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        color: #4b5563;
        transition: all 0.3s;
        height: 100%;
    }
    
    .action-btn:hover {
        border-color: var(--primary-gold);
        background: rgba(193, 157, 96, 0.05);
        color: var(--primary-gold);
        text-decoration: none;
        transform: translateY(-2px);
    }
    
    .action-btn i {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        color: var(--primary-gold);
    }
    
    .action-btn span {
        font-weight: 600;
    }
</style>
@endpush

@section("content")
    {{-- Non-Merchant View (Admin/SuperUser) --}}
    @unlessrole('merchant')
        <div class="mb-5">
            <div class="merchant-welcome mb-5" style="background: linear-gradient(135deg, #1e2129 0%, #15171e 100%);">
                <div class="position-relative z-10">
                    <h2 class="fw-bold fs-2 mb-2">Welcome Back, Admin! 👋</h2>
                    <p class="mb-0 opacity-75">
                        Here is the overview of KuniVerse platform today.
                    </p>
                </div>
            </div>

            {{-- Admin Stats Grid --}}
            <h4 class="fw-bold text-dark mb-4 ms-1">Platform Overview</h4>
            <div class="row g-4 mb-5">
                {{-- Users --}}
                <div class="col-md-3">
                    <div class="stat-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $user_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Users</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wisata --}}
                <div class="col-md-3">
                    <div class="stat-card wisata p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $wisata_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Wisata</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kuliner --}}
                <div class="col-md-3">
                    <div class="stat-card kuliner p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $kuliner_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Kuliner</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- UMKM --}}
                <div class="col-md-3">
                    <div class="stat-card umkm p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $umkm_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total UMKM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-bottom-0 py-3 rounded-top-4">
                            <h5 class="fw-bold mb-0">Recent Users</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joined At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_users ?? [] as $user)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-label-primary">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">No recent users found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                     <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-bottom-0 py-3 rounded-top-4">
                            <h5 class="fw-bold mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                             <div class="d-grid gap-3">
                                <a href="{{ route('backend.users.create') }}" class="btn btn-outline-primary py-2 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-user-plus"></i> Add New User
                                </a>
                                {{-- Add other admin actions here --}}
                             </div>
                        </div>
                     </div>
                </div>
            </div>
            
        </div>
    @endunlessrole

    {{-- Merchant View --}}
    @hasrole('merchant')
        <div class="mb-5">
            {{-- Welcome Banner --}}
            <div class="merchant-welcome mb-5">
                <div class="position-relative z-10">
                    <h2 class="fw-bold fs-2 mb-2">Hello, {{ auth()->user()->name }}! 👋</h2>
                    <p class="mb-0 opacity-75" style="max-width: 600px;">
                        Selamat datang di Dashboard Merchant. Kelola Wisata, Kuliner, dan UMKM Anda dengan mudah dari sini. 
                    </p>
                </div>
            </div>

            {{-- Stats Grid --}}
            <h4 class="fw-bold text-dark mb-4 ms-1">Overview</h4>
            <div class="row g-4 mb-5">
                {{-- Wisata --}}
                <div class="col-md-4">
                    <div class="stat-card wisata p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $wisata_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Wisata</p>
                            </div>
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                Active
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kuliner (Hidden for now) --}}
                {{-- 
                <div class="col-md-4">
                    <div class="stat-card kuliner p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $kuliner_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total Kuliner</p>
                            </div>
                             <span class="badge bg-light text-warning rounded-pill px-3 py-2">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
                --}}

                {{-- UMKM (Hidden for now) --}}
                {{-- 
                <div class="col-md-4">
                    <div class="stat-card umkm p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="icon-wrapper">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <h3 class="fw-bold fs-2 mb-0">{{ $umkm_count ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Total UMKM</p>
                            </div>
                             <span class="badge bg-light text-danger rounded-pill px-3 py-2">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
                --}}
            </div>

             {{-- Quick Actions --}}
            <h4 class="fw-bold text-dark mb-4 ms-1">Quick Actions</h4>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <a href="{{ route('backend.wisata.create') }}" class="action-btn">
                        <i class="fa-solid fa-mountain-sun"></i>
                        <span>Tambah Wisata</span>
                    </a>
                </div>
                {{-- 
                <div class="col-6 col-md-3">
                    <a href="{{ route('backend.kuliner.create') }}" class="action-btn">
                        <i class="fa-solid fa-burger"></i>
                        <span>Tambah Kuliner</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('backend.umkm.create') }}" class="action-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>Tambah UMKM</span>
                    </a>
                </div>
                --}}
                 <div class="col-6 col-md-3">
                    {{-- Assuming edit profile link --}}
                    <a href="{{ route('frontend.users.profile') }}" class="action-btn">
                        <i class="fa-solid fa-user-circle"></i>
                        <span>Lihat Profile</span>
                    </a>
                </div>
            </div>

        </div>
    @endhasrole
@endsection
