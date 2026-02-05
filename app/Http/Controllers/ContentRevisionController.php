<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentRevision;
use Illuminate\Http\RedirectResponse;

class ContentRevisionController extends Controller
{
    public function restore(Content $content, ContentRevision $revision): RedirectResponse
    {
        $this->authorize('update', $content);

        if ($revision->content_id !== $content->id) {
            abort(404);
        }

        $payload = collect($revision->data ?? [])->only([
            'title',
            'slug',
            'description',
            'content_type',
            'file_path',
            'external_url',
            'content_text',
            'publish_status',
            'published_at',
            'scheduled_publish_at',
            'expires_at',
            'archived_at',
        ])->toArray();

        $content->shouldRecordRevision = false;
        $content->fill($payload);
        $content->save();

        $content->categories()->sync($revision->data['category_ids'] ?? []);

        $content->shouldRecordRevision = true;
        $content->recordRevision();

        return redirect()
            ->route('admin.contents.show', $content)
            ->with('success', 'Revision restored successfully.');
    }
}
