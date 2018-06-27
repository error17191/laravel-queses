<?php

namespace App\Jobs\Users;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UpdateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $tmpName;
    public $uuid;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $tmpName)
    {
        $this->user = $user;
        $this->tmpName = $tmpName;
        $this->uuid = Str::uuid();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->resizeImage() && $this->uploadFile()) {
            $this->removeTmpFile();
        }

        $this->updateUserInfo();
    }

    protected function tmpFilePath()
    {
        return storage_path("uploads/{$this->tmpName}");
    }

    protected function tmpFile()
    {
        return Storage::disk('tmp')->get($this->tmpName);
    }

    protected function path()
    {
        return "images/users/{$this->uuid}.png";
    }

    protected function resizeImage()
    {
        try {
            Image::make($this->tmpFilePath())->encode('png')->fit(60, 60, function ($c) {
                $c->upsize();
            })->save();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    protected function uploadFile()
    {
        return Storage::put($this->path(), $this->tmpFile());
    }

    protected function removeTmpFile()
    {
        return Storage::disk('tmp')->delete($this->tmpName);
    }

    protected function updateUserInfo()
    {
        $this->user->image_path = $this->path();
        $this->user->save();
    }
}
