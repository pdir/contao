<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao\CoreBundle\Picker;

abstract class AbstractInsertTagPickerProvider extends AbstractPickerProvider
{
    protected const INSERTTAG = null;

    /**
     * Returns the configured insert tag or the default one.
     */
    protected function getInsertTag(PickerConfig $config): string
    {
        if ($insertTag = $config->getExtraForProvider('insertTag', $this->getName())) {
            return (string) $insertTag;
        }

        if (null === static::INSERTTAG) {
            throw new \LogicException('Please add a protected INSERTTAG constant in your picker provider class');
        }

        return (string) static::INSERTTAG;
    }

    /**
     * Splits an insert tag at the placeholder (%s) and returns the chunks.
     */
    protected function getInsertTagChunks(PickerConfig $config): array
    {
        return explode('%s', $this->getInsertTag($config), 2);
    }

    /**
     * Returns the value without the surrounding insert tag chunks.
     */
    protected function getInsertTagValue(PickerConfig $config)
    {
        return str_replace($this->getInsertTagChunks($config), '', $config->getValue());
    }

    /**
     * Checks if the value matches the insert tag.
     */
    protected function isMatchingInsertTag(PickerConfig $config): bool
    {
        return false !== strpos($config->getValue(), $this->getInsertTagChunks($config)[0]);
    }
}