<?php

interface QuestionDeckContract
{
    public function getCategoryFromPosition($position);

    public function getQuestion($category);

}