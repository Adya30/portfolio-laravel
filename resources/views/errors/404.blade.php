@extends('errors.layout')

@section('code', '404')
@section('title', 'Halaman Tidak Ditemukan')

@section('badge-class', 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20')
@section('dot-class', 'bg-blue-500')
@section('icon-bg-class', 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400')

@section('icon')
<svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
@endsection

@section('message')
{{ $exception->getMessage() ?: 'Halaman atau konten yang Anda cari tidak dapat ditemukan, telah dipindahkan, atau tautan yang dimasukkan keliru.' }}
@endsection
