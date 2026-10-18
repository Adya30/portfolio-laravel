@include('admin.projects._blocks-editor', [
    'blocksValue' => $blocksValue ?? [],
    'uploadUrl' => $uploadUrl ?? route('admin.experiences.upload-image'),
    'autosaveKey' => $autosaveKey ?? ('autosave_experience_' . (($experience ?? null)?->id ?? 'new')),
])
