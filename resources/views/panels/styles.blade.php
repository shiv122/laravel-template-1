<link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}" />
@if (!empty($pageConfigs['has_table']))
    @if ($pageConfigs['has_table'])
        <link rel="stylesheet"
            href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}" />
        <link rel="stylesheet"
            href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}" />
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}" />
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}" />
    @endif
@endif
@if (!empty($pageConfigs['has_editor']))
    @if ($pageConfigs['has_editor'])
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
    @endif
@endif
@if (!empty($pageConfigs['has_sweetAlert']))
    @if ($pageConfigs['has_sweetAlert'])
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

    @endif
@endif
@if (!empty($pageConfigs['has_animation']))
    @if ($pageConfigs['has_animation'])
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">

    @endif
@endif
@if (!empty($pageConfigs['has_player']))
    @if ($pageConfigs['has_player'])
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/plyr.min.css')) }}">

    @endif
@endif



{{-- Vendor Styles --}}
@yield('vendor-style')
{{-- Theme Styles --}}

<link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />

{{-- {!! Helper::applClasses() !!} --}}
@php $configData = Helper::applClasses(); @endphp

{{-- Page Styles --}}
@if ($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/horizontal-menu.css')) }}" />
@endif
<link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css')) }}" />
<!-- <link rel="stylesheet" href="{{ asset(mix('css/base/core/colors/palette-gradient.css')) }}"> -->

{{-- Page Styles --}}
@yield('page-style')

@if (!empty($pageConfigs['has_editor']))
    @if ($pageConfigs['has_editor'])
        <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
    @endif
@endif
@if (!empty($pageConfigs['has_sweetAlert']))
    @if ($pageConfigs['has_sweetAlert'])
        <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    @endif
@endif
@if (!empty($pageConfigs['has_player']))
    @if ($pageConfigs['has_player'])
        <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-media-player.css')) }}">
    @endif
@endif




{{-- Laravel Style --}}
<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}" />

{{-- Custom RTL Styles --}}

@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ asset(mix('css/custom-rtl.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('css/style-rtl.css')) }}" />
@endif





{{-- user custom styles --}}
<link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}" />
