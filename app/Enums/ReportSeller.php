<?php

namespace App\Enums;

enum ReportSeller: string
{
    case FakeReview = 'Fake-Review';
    case Scam = 'Scam';
    case MisleadingInformation = 'Misleading-Information';
    case Other = 'Other';
}
