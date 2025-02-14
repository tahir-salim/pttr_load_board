<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TruckStatus extends Enum
{
    const AVAILABLE = 'AVAILABLE';
    const PENDING = 'PENDING';
    const PICKUP = 'PICKUP';
    const DROP_OFF = 'DROP_OFF';
    const IN_TRANSIT = 'IN_TRANSIT';
    const DELIVERED = 'DELIVERED';
    const DECLINED = 'DECLINED';
    const ACCEPTED = 'ACCEPTED';

}
