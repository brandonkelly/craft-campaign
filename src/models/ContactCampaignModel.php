<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\campaign\models;

use craft\base\Model;
use DateTime;
use putyourlightson\campaign\Campaign;
use putyourlightson\campaign\elements\CampaignElement;
use putyourlightson\campaign\elements\ContactElement;
use putyourlightson\campaign\elements\MailingListElement;
use putyourlightson\campaign\elements\SendoutElement;
use putyourlightson\campaign\records\LinkRecord;

/**
 * @property-read SendoutElement|null $sendout
 * @property-read null|ContactElement $contact
 * @property-read string $interaction
 * @property-read null|CampaignElement $campaign
 * @property-read null|MailingListElement $mailingList
 * @property-read array $interactions
 */
class ContactCampaignModel extends Model
{
    /**
     * @const array
     */
    public const INTERACTIONS = ['opened', 'clicked', 'unsubscribed', 'complained', 'bounced'];

    /**
     * @var int|null ID
     */
    public ?int $id = null;

    /**
     * @var int|null Contact ID
     */
    public ?int $contactId = null;

    /**
     * @var int|null Campaign ID
     */
    public ?int $campaignId = null;

    /**
     * @var int|null Sendout ID
     */
    public ?int $sendoutId = null;

    /**
     * @var int|null Mailing List ID
     */
    public ?int $mailingListId = null;

    /**
     * @var DateTime|null Sent
     */
    public ?DateTime $sent = null;

    /**
     * @var DateTime|null Opened
     */
    public ?DateTime $opened = null;

    /**
     * @var DateTime|null Clicked
     */
    public ?DateTime $clicked = null;

    /**
     * @var DateTime|null Unsubscribed
     */
    public ?DateTime $unsubscribed = null;

    /**
     * @var DateTime|null Complained
     */
    public ?DateTime $complained = null;

    /**
     * @var DateTime|null Bounced
     */
    public ?DateTime $bounced = null;

    /**
     * @var int Opens
     */
    public int $opens = 0;

    /**
     * @var int Clicks
     */
    public int $clicks = 0;

    /**
     * @var string|null Links
     */
    public ?string $links = null;

    /**
     * @var string|null Device
     */
    public ?string $device = null;

    /**
     * @var string|null OS
     */
    public ?string $os = null;

    /**
     * @var string|null Client
     */
    public ?string $client = null;

    /**
     * @var DateTime|null
     */
    public ?DateTime $dateUpdated = null;

    /**
     * Returns the contact.
     */
    public function getContact(): ?ContactElement
    {
        return Campaign::$plugin->contacts->getContactById($this->contactId);
    }

    /**
     * Returns the campaign.
     */
    public function getCampaign(): ?CampaignElement
    {
        return Campaign::$plugin->campaigns->getCampaignById($this->campaignId);
    }

    /**
     * Returns the sendout.
     */
    public function getSendout(): ?SendoutElement
    {
        if ($this->sendoutId === null) {
            return null;
        }

        return Campaign::$plugin->sendouts->getSendoutById($this->sendoutId);
    }

    /**
     * Returns the mailing list.
     */
    public function getMailingList(): ?MailingListElement
    {
        if ($this->mailingListId === null) {
            return null;
        }

        return Campaign::$plugin->mailingLists->getMailingListById($this->mailingListId);
    }

    /**
     * Returns the links as an array.
     */
    public function getLinks(): array
    {
        $links = [];
        $linkIds = $this->links ? explode(',', $this->links) : [];

        if (count($linkIds)) {
            $linkRecords = LinkRecord::find()
                ->where(['id' => $linkIds])
                ->all();

            /** @var LinkRecord $linkRecord */
            foreach ($linkRecords as $linkRecord) {
                $links[] = $linkRecord->url;
            }
        }

        return $links;
    }

    /**
     * Returns the most significant interaction.
     */
    public function getInteraction(): string
    {
        $interactions = ['bounced', 'complained', 'unsubscribed', 'clicked', 'opened'];
        $return = '';

        foreach ($interactions as $interaction) {
            if ($this->{$interaction} !== null) {
                $return = $this->interaction;
                break;
            }
        }

        return $return;
    }

    /**
     * Returns all interactions.
     */
    public function getInteractions(): array
    {
        $interactions = [];

        foreach (self::INTERACTIONS as $interaction) {
            if ($this->{$interaction} !== null) {
                $interactions[] = $interaction;
            }
        }

        return $interactions;
    }
}
