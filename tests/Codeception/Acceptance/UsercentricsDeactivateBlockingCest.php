<?php

/**
 * This file is part of O3-Shop Usercentrics Cookie Compliance module.
 *
 * O3-Shop is free software: you can redistribute it and/or modify  
 * it under the terms of the GNU General Public License as published by  
 * the Free Software Foundation, version 3.
 *
 * O3-Shop is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
 * General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with O3-Shop.  If not, see <http://www.gnu.org/licenses/>
 *
 * @copyright  Copyright (c) 2022 OXID eSales AG (https://www.oxid-esales.com)
 * @copyright  Copyright (c) 2022 O3-Shop (https://www.o3-shop.com)
 * @license    https://www.gnu.org/licenses/gpl-3.0  GNU General Public License 3 (GPLv3)
 */

declare(strict_types=1);

namespace OxidProfessionalServices\Usercentrics\Tests\Codeception\Acceptance;

use OxidEsales\Codeception\Page\Home;
use OxidProfessionalServices\Usercentrics\Tests\Codeception\AcceptanceTester;
use OxidProfessionalServices\Usercentrics\Tests\Codeception\Module\Config;

final class UsercentricsDeactivateBlockingCest extends BaseCest
{
    public function _before(AcceptanceTester $I, Config $configModule): void
    {
        parent::_before($I, $configModule);

        $I->saveShopConfVar(
            'string',
            'smartDataProtectorDeactivateBlocking',
            'xxx , yyy',
            1,
            'module:oxps_usercentrics'
        );
    }

    public function _after(AcceptanceTester $I, Config $configModule): void
    {
        parent::_after($I, $configModule);

        $I->saveShopConfVar(
            'string',
            'smartDataProtectorDeactivateBlocking',
            '',
            1,
            'module:oxps_usercentrics'
        );
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     * @group usercentrics
     */
    public function protectorBlockingDeactivationConfigurationPresent(AcceptanceTester $I)
    {
        $homePage = new Home($I);
        $I->amOnPage($homePage->URL);

        $I->seeInSource('<script>uc.deactivateBlocking(["xxx", "yyy"]);</script>');
    }
}
