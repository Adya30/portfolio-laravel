@extends('errors.layout')

@section('code', '403')
@section('title', 'Akses Ditolak')

@section('badge-class', 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20')
@section('dot-class', 'bg-amber-500')
@section('icon-bg-class', 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400')

@section('icon')
<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
</svg>
@endsection

@section('message')
{{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin atau hak akses untuk melihat halaman ini.' }}
@endsection
