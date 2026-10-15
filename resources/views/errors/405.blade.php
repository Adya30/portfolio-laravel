@extends('errors.layout')

@section('code', '405')
@section('title', 'Metode Tidak Diizinkan')

@section('badge-class', 'bg-orange-50 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400 border border-orange-200/60 dark:border-orange-500/20')
@section('dot-class', 'bg-orange-500')
@section('icon-bg-class', 'bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400')

@section('icon')
<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
</svg>
@endsection

@section('message')
{{ $exception->getMessage() ?: 'Metode permintaan HTTP (GET/POST/PUT) yang dikirimkan tidak didukung oleh tautan ini. Silakan kembali atau muat ulang halaman.' }}
@endsection
