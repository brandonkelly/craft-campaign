<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\campaign\fieldlayoutelements\reports;

use Craft;
use craft\base\ElementInterface;
use craft\models\FieldLayoutTab;

/**
 * @since 2.0.0
 */
abstract class BaseReportFieldLayoutTab extends FieldLayoutTab
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->name = Craft::t('campaign', 'Report');
    }


    /**
     * @inheritdoc
     */
    public function showInForm(?ElementInterface $element = null): bool
    {
        return true;
    }
}
