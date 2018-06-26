<?php

namespace App\Jobs\Users;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $uuid;
    public $originalName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $uuid, $originalName)
    {
        $this->user = $user;
        $this->uuid = $uuid;
        $this->originalName = $originalName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->uploadFile()) {
            $this->removeTmpFile();
        }
    }

    protected function tmpFile()
    {
        return Storage::disk('tmp')->get($this->tmpPath());
    }

    protected function tmpPath()
    {
        return storage_path("uploads/{$this->uuid}");
    }

    protected function path()
    {
        return "images/users/{$this->uuid}.png";
    }

    protected function uploadFile()
    {
        return Storage::put($this->path(), $this->resource());
    }

    protected function removeTmpFile()
    {
        return Storage::disk('tmp')->delete($this->uuid);
    }
}
