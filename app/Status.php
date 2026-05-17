<?php

declare(strict_types=1);//I added this it was not added .
namespace App;

enum Status: string
{
    case PENDING='Pending';
    case IN_PROGRESS='In Progress';
    case PAID='Paid';
    case COMPLETED='Completed';
    case DELIVERY='Delivery';

    public function label(): string
    {
        return match ($this) {
            Status::PENDING => 'Pending',
            Status::IN_PROGRESS => 'In Progress',
            Status::PAID => 'Paid',
            Status::COMPLETED => 'Completed',
        };
    }
}
