<?php

namespace Envant\Attachments;

use Envant\Attachments\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAttachments
{
    protected static function bootHasAttachments()
    {
        static::saved(function ($model) {
            if (request()->has('uuid')) {
                Attachment::assignToModel($model, request()->uuid);
            }
        });

        static::deleting(function ($model) {
            $model->attachments()->delete();
        });
    }

    /**
     * Attachments
     *
     * @return MorphMany|Attachment
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'model');
    }
}
