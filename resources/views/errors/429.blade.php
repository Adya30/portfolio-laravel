@extends('errors.layout')

@section('code', '429')
@section('title', 'Terlalu Banyak Permintaan')

@section('badge-class', 'bg-purple-50 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400 border border-purple-200/60 dark:border-purple-500/20')
@section('dot-class', 'bg-purple-500')
@section('icon-bg-class', 'bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400')

@section('icon')
<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
@endsection

@section('message')
{{ $exception->getMessage() ?: 'Anda telah melakukan terlalu banyak permintaan dalam waktu singkat. Mohon tunggu beberapa saat sebelum mencoba kembali.' }}
@endsection
