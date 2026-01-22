<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand d-sm-flex justify-content-center">
            <a href="/" class="text-decoration-none">
                <div class="sidebar-brand-full text-white fw-bold h4 m-0">
                    {{ app_name() }}
                </div>
                <div class="sidebar-brand-narrow text-white fw-bold h4 m-0">
                    {{ substr(app_name(), 0, 2) }}
                </div>
            </a>
        </div>
        <button
            class="btn-close d-lg-none"
            data-coreui-dismiss="offcanvas"
            data-coreui-theme="dark"
            type="button"
            aria-label="Close"
            onclick='coreui.Sidebar.getInstance(document.querySelector("#sidebar")).toggle()'
        ></button>
    </div>

    {{-- Dynamic Menu from Database --}}
    {{-- Dynamic Menu from Database --}}
    @php
        // Check for merchant: has 'view_wisata' but NOT 'view_users' (which is admin-only)
        $isMerchant = auth()->user()->can('view_wisata') && !auth()->user()->can('view_users');
        $sidebarLocation = $isMerchant ? 'merchant-sidebar' : 'admin-sidebar';
    @endphp
    <x-backend.dynamic-menu :location="$sidebarLocation" />

    {{-- Fallback: Load menu items from menu_data.json (in case dynamic menu is empty) --}}
    @php
        $hasMenuItems = \Modules\Menu\Models\Menu::getCachedMenuData($sidebarLocation, auth()->user())->isNotEmpty();
    @endphp

    @if (! $hasMenuItems)
        <x-backend.fallback-sidebar-menu />
    @endif

    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" data-coreui-toggle="unfoldable" type="button"></button>
    </div>
</div>
