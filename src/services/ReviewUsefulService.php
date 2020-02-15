<?php

namespace vktv\services;

use vktv\models\Review;
use vktv\models\ReviewUseful;
use vktv\models\User;

class ReviewUsefulService
{
    public static function saveUseful(ReviewUseful $reviewUseful, Review $review, User $user, int $value)
    {
        $reviewUseful->user_id = $user->getId();
        $reviewUseful->review_id = $review->id;
        $reviewUseful->value = $value;
        
        return $reviewUseful->save();
    }
}
