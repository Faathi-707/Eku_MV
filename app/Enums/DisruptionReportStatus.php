<?php

namespace App\Enums;

enum DisruptionReportStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}
