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

namespace OxidProfessionalServices\Usercentrics\Service;

use OxidProfessionalServices\Usercentrics\DataObject\Service;
use OxidProfessionalServices\Usercentrics\Service\Configuration\ConfigurationDaoInterface;

final class ScriptServiceMapper implements ScriptServiceMapperInterface
{
    /**
     * @var ConfigurationDaoInterface
     */
    private $configurationDao;

    /**
     * This is a map of service path as key with a service id
     * @example: ['some/path/to/script.js' => 'SomeConfiguredServiceId']
     *
     * @var array<string,?Service>
     */
    private $scriptPathToService;

    /**
     * @var array<string,?Service>
     */
    private $snippetToService;

    public function __construct(ConfigurationDaoInterface $configurationDao)
    {
        $this->configurationDao = $configurationDao;
        $this->scriptPathToService = $this->mapScriptPathsToServices();
        $this->snippetToService = $this->mapScriptSnippetToServices();
    }

    public function getServiceByScriptUrl(string $url): ?Service
    {
        foreach ($this->scriptPathToService as $path => $service) {
            if (preg_match($this->prepareScriptPathRegex($path), $url)) {
                return $service;
            }
        }

        return null;
    }

    /**
     * Build a regex that will match if the URL's path ends with this path
     *
     * @param string $path
     * @return string
     */
    private function prepareScriptPathRegex(string $path): string
    {
        return '/' . preg_quote($path, '/') . '(:?\?|#|$)/S';
    }

    public function getServiceBySnippetId(string $snippetId): ?Service
    {
        return $this->snippetToService[$snippetId] ?? null;
    }


    protected function getServiceById(string $serviceId): ?Service
    {
        $config = $this->configurationDao->getConfiguration();
        $services = $config->getServices();

        return $services[$serviceId] ?? null;
    }

    /**
     * Gives an array like ["some/path/to/script.js" => 'someServiceId']
     *
     * @return array<string,?Service>
     */
    private function mapScriptPathsToServices(): array
    {
        $config = $this->configurationDao->getConfiguration();
        $scripts = $config->getScripts();
        $result = [];

        foreach ($scripts as $oneScript) {
            $serviceId = $oneScript->getServiceId();
            $path = $oneScript->getPath();
            $result[$path] = $this->getServiceById($serviceId);
        }

        return $result;
    }

    /**
     * Gives an array like ['someSnippetId' => 'someServiceId']
     *
     * @return array<string,?Service>
     */
    private function mapScriptSnippetToServices(): array
    {
        $config = $this->configurationDao->getConfiguration();
        $scripts = $config->getScriptSnippets();
        $result = [];

        foreach ($scripts as $oneScript) {
            $serviceId = $oneScript->getServiceId();
            $result[$oneScript->getId()] = $this->getServiceById($serviceId);
        }

        return $result;
    }

    public function calculateSnippetId(string $snippetContents): string
    {
        return md5(trim($snippetContents));
    }
}
