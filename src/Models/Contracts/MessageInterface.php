<?php

namespace Kdes70\Chatter\Models\Contracts;

interface MessageInterface
{
    public function conversation();
    public function users();
    public function userFrom();
    public function userTo();
}