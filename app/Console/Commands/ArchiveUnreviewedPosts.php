<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class ArchiveUnreviewedPosts extends Command
{
    protected $signature = 'posts:archive-unreviewed';

    protected $description = 'Archive posts which are unreviewed after 3 days';

    public function handle()
    {
        $dateThreshold = Carbon::now()->subDays(3);

        $posts = Post::where('status', 'pending')
            ->where('created_at', '<=', $dateThreshold)
            ->whereNull('archived_at')
            ->get();

        foreach ($posts as $post) {
            $post->archived_at = now();
            $post->save();
        }

        $this->info(count($posts).' posts archived successfully.');
    }
}
