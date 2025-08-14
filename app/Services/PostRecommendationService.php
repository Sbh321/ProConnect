<?php
namespace App\Services;

class PostRecommendationService
{
    public function cosineSimilarity(array $vec1, array $vec2)
    {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($vec1 as $key => $value) {
            $dotProduct += $value * ($vec2[$key] ?? 0);
            $magnitude1 += $value ** 2;
        }

        foreach ($vec2 as $value) {
            $magnitude2 += $value ** 2;
        }

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / (sqrt($magnitude1) * sqrt($magnitude2));
    }

    public function textToVector(string $text)
    {
        $tokens = preg_split('/\s+/', strtolower($text));
        $vector = [];

        foreach ($tokens as $token) {
            $vector[$token] = ($vector[$token] ?? 0) + 1;
        }

        return $vector;
    }

    public function buildUserProfileVector($user)
    {
        $userPosts = $user->stars()->get()->merge($user->saves()->get())->merge($user->posts);

        $profileVector = [];

        foreach ($userPosts as $post) {
            $text = $post->status . ' ' . $post->hashtags;
            $vec  = $this->textToVector($text);

            foreach ($vec as $word => $count) {
                $profileVector[$word] = ($profileVector[$word] ?? 0) + $count;
            }
        }

        return $profileVector;
    }
}
