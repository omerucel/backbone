<?php

namespace Framework\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Loader\PoFileLoader;
use Symfony\Component\Translation\Translator;
use Zend\Config\Config;

class TranslatorFactory
{
    /**
     * @param ContainerInterface $container
     * @return Translator
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(Config::class);
        $translator = new Translator($config->translations->default_locale);
        $translator->setFallbackLocales($config->translations->fallback_locales->toArray());
        $translator->addLoader('array', new ArrayLoader());
        $translator->addLoader('po', new PoFileLoader());
        $translator->addLoader('mo', new MoFileLoader());
        foreach ($config->translations->locales as $locale => $localeSettings) {
            if ($localeSettings->loader == 'array') {
                $data = include($localeSettings->file);
                $translator->addResource('array', $data, $locale);
            } elseif ($localeSettings->loader == 'po') {
                $translator->addResource('po', $localeSettings->file, $locale);
            } elseif ($localeSettings->loader == 'mo') {
                $translator->addResource('mo', $localeSettings->file, $locale);
            }
        }
        return $translator;
    }
}
