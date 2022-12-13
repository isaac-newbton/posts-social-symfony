<?php

namespace App\Entity;

enum PostStatus: string {
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case DELETED = 'deleted';
}