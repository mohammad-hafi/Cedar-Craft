<?php

namespace App;

enum RequestStatus: string
{
    case PENDING='Pending';
    case ACCEPTED='Accepted';
    case REJECTED='Rejected';

 
}
