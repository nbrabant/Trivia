<?php

interface CategoryContract
{
    public function getCategoryFromPosition($position);

    public function getQuestion($category);

}