<?php

namespace Envant\Attachments\Controllers;

use Illuminate\Routing\Controller;
use Envant\Attachments\Requests\AttachmentRequest;
use Envant\Attachments\Resources\AttachmentResource;
use Envant\Attachments\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function store(AttachmentRequest $request)
    {
        $file = $request->file('file');
        $path = Storage::disk(config('attachments.storage.disk'))
            ->put(config('attachments.storage.directory'), $file);

        $attachment = Attachment::create([
            'user_id' => $this->user ? $this->user->id : null,
            'uuid' => $request->uuid ?? Str::uuid(),
            'model_type' => $request->model,
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
            'name' => $request->name ?? $file->getClientOriginalName(),
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return new AttachmentResource($attachment);
    }

    public function show(Attachment $attachment)
    {
        return Storage::disk(config('attachments.storage.disk'))
            ->download($attachment->path, $attachment->name);
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete();

        response()->json([
            'success' => true,
        ], Response::HTTP_NO_CONTENT);
    }
}
