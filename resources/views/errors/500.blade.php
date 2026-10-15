@extends('errors.layout')

@section('code', '500')
@section('title', 'Terjadi Kesalahan Server')

@section('badge-class', 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20')
@section('dot-class', 'bg-rose-500')
@section('icon-bg-class', 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400')

@section('icon')
<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
</svg>
@endsection

@section('message')
Terjadi kendala teknis internal pada server saat memproses permintaan Anda. Tim kami telah mencatat kendala ini dan akan segera menanganinya.
@endsection
