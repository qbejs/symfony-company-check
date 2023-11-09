<?php

namespace App\Infrastructure\Helper\Enum;

enum SerializationFormat: string
{
    case JSON = 'json';
    case XML = 'xml';
    case XLSX = 'xlsx';
}
