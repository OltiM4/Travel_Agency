<?php

class ReviewRepository implements IRepository
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function getAllReviews()
    {
        return $this->context->query("SELECT * FROM reviews");
    }

    public function getReviewById($id)
    {
        return $this->context->query("SELECT * FROM reviews WHERE id = ?", [$id]);
    }

    public function addReview($review)
    {
        return $this->context->execute("INSERT INTO reviews (user_id, rating, comment, review_date) VALUES (?, ?, ?, ?)", [$review->user_id, $review->rating, $review->comment, $review->review_date]);
    }

    public function updateReview($review)
    {
        return $this->context->execute("UPDATE reviews SET user_id = ?, rating = ?, comment = ?, review_date = ? WHERE id = ?", [$review->user_id, $review->rating, $review->comment, $review->review_date, $review->id]);
    }

    public function deleteReview($id)
    {
        return $this->context->execute("DELETE FROM reviews WHERE id = ?", [$id]);
    }
}