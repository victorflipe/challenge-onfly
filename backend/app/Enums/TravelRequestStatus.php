<?php

namespace App\Enums;

enum TravelRequestStatus:string
{
    case REQUESTED = "requested";
    case APPROVED = "approved";
    case CANCELED = "canceled";
}
