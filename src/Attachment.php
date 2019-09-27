<?php

namespace Envant\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    /** @var array */
    protected $guarded = ['id'];

    /** @var array */
    protected $appends = [
        'url',
    ];

    /**
     * Override default model name
     *
     * @return string
     */
    public function getTable()
    {
        return config('attachments.table');
    }

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    /**
     * Uploader
     * 
     * @return BelongsTo|User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo($this->getAuthModelName());
    }

    /**
     * Related model
     *
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors
     |--------------------------------------------------------------------------
     */

    /**
     * Get direct url
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk(config('attachments.storage.disk'))
            ->url($this->path);
    }

    /*
     |--------------------------------------------------------------------------
     | Static functions
     |--------------------------------------------------------------------------
     */

    /*
    protected static function boot()
    {
        static::saved(function ($model) {
            $model->process();
        });
    }
    */

    /**
     * Get auth model
     *
     * @return string
     * @throws Exception
     */
    protected function getAuthModelName()
    {
        if (config('attachments.user_model')) {
            return config('attachments.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the commentator model name.');
    }

    /**
     * Assign temporary files to model
     *
     * @param Model|null $model
     * @param string $uuid
     * @return void
     */
    public static function assignToModel(?Model $model, string $uuid)
    {
        static::whereUuid($uuid)
            ->whereNull('model_id')
            ->update([
                'model_id' => $model->getKey(),
            ]);
    }
}
