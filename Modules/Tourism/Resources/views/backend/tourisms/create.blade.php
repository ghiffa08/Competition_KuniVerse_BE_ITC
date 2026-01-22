@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />

        <div class="row mt-4">
            <div class="col">
                {{ html()->form("POST", route((request()->routeIs("merchant.*") ? "merchant" : "backend") . ".$module_name.store"))->acceptsFiles()->open() }}

                @include("tourism::backend.tourisms.form")

                <div class="row">
                    <div class="col-6">
                        <x-backend.buttons.create>Create</x-backend.buttons.create>
                    </div>
                </div>

                {{ html()->form()->close() }}

                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="float-end">
                            <x-backend.buttons.cancel />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@endsection