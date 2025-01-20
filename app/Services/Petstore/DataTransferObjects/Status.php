<?php

namespace App\Services\Petstore\DataTransferObjects;

enum Status: string
{
    case Available = 'available';
    case Pending = 'pending';
    case Sold = 'sold';
}
