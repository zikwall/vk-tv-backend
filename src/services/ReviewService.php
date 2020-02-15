<?php

namespace vktv\services;

use vktv\models\Content;
use vktv\models\Review;
use vktv\models\ReviewUseful;
use vktv\models\User;

class ReviewService
{
    public static function saveReview(Review $review, User $user, Content $content, array $reviewAttributes)
    {
        $review->content_id = $content->id;
        $review->user_id    = $user->getId();
        $review->content    = $reviewAttributes['content'];
        $review->value      = $reviewAttributes['value'];
        $review->created_at = time();
        
        return $review->save();
    }

    public static function deleteReview(Review $review)
    {
        return $review->delete() !== false;
    }
}
