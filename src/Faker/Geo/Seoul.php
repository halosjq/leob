<?php

/*
 * This file is part of the Faker package.
 *
 * (c) 2013 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Faker\Geo;

/**
 * Seoul geolocation Faker.
 *
 * @abstract
 * @extends Faker\Geo\Region
 */
class Seoul extends Region
{
    // Source: http://en.wikipedia.org/wiki/Seoul
    const LAT_CENTER =  37.566536;
    const LNG_CENTER = 126.977969;
}
