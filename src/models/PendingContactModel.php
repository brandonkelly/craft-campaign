<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\campaign\models;

use putyourlightson\campaign\base\BaseModel;
use putyourlightson\campaign\helpers\StringHelper;

/**
 * PendingContactModel
 *
 * @author    PutYourLightsOn
 * @package   Campaign
 * @since     1.0.0
 */
class PendingContactModel extends BaseModel
{
    // Properties
    // =========================================================================

    /**
     * @var string Pending ID
     */
    public $pid;

    /**
     * @var string Email
     */
    public $email;

    /**
     * @var int Mailing list ID
     */
    public $mailingListId;

    /**
     * @var string Source
     */
    public $source;

    /**
     * @var mixed Field data
     */
    public $fieldData;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->pid === null) {
            $this->pid = StringHelper::uniqueId('p');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['pid', 'email'], 'required'],
            [['pid'], 'string', 'max' => 32],
            [['email'], 'email'],
        ];
    }
}
