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

namespace OxidProfessionalServices\Usercentrics\DataObject;

/** @psalm-immutable */
final class Configuration
{
    /**
     * @var Script[]
     */
    private $scripts;

    /**
     * @var Service[]
     */
    private $services;

    /**
     * @var ScriptSnippet[]
     */
    private $scriptSnippets;

    /**
     * Configuration constructor.
     *
     * @param Service[] $services
     * @param Script[] $scripts
     * @param ScriptSnippet[] $scriptSnippets
     */
    public function __construct(array $services, array $scripts, array $scriptSnippets)
    {
        $this->scripts = $scripts;
        $this->services = $services;
        $this->scriptSnippets = $scriptSnippets;
    }

    /**
     * @return Script[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * @return Service[]
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @return ScriptSnippet[]
     */
    public function getScriptSnippets(): array
    {
        return $this->scriptSnippets;
    }
}
