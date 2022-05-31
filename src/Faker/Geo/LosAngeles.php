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
 * Los Angeles geolocation Faker.
 *
 * @abstract
 * @extends Faker\Geo\Region
 */
class LosAngeles extends Region
{
    // Source: http://en.wikipedia.org/wiki/Los_Angeles_metropolitan_area
    const LAT_CENTER =   33.9;
    const LNG_CENTER = -118.25;
}
