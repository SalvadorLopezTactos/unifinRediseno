<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
use Sugarcrm\Sugarcrm\Hint\Initializer;
use Sugarcrm\Sugarcrm\modules\HintAccountsets\HintAccountsetCategories;
use Sugarcrm\Sugarcrm\modules\HintAccountsets\HintAccountsetTypes;
use Sugarcrm\Sugarcrm\modules\HintNotificationTargets\NotificationTargetTypes;
use Sugarcrm\Sugarcrm\Util\Uuid;

class HintAccountset extends \Basic
{
    const MODULE_NAME = 'HintAccountsets';

    public $id;
    public $type;
    public $assigned_user_id;
    public $category;
    public $name;
    public $description;
    public $date_entered;
    public $date_modified;
    public $deleted;

    public $module_dir = self::MODULE_NAME;
    public $module_name = self::MODULE_NAME;
    public $table_name = 'hint_accountsets';
    public $object_name = 'HintAccountset';


    /**
     * Creates a new accountset with default targets for given user
     *
     * HintAccountset save results to EventTypes::ACCOUNTSET_ADD event being
     * recorded. If we add relationships (targets) after that the code will
     * record some EventTypes::ACCOUNTSET_ADD_TARGET events resulting to something
     * like that in the queue:
     * - ACCOUNTSET_ADD
     * - TARGET_ADD
     * - ACCOUNTSET_ADD_TARGET
     * - TARGET_ADD
     * - ACCOUNTSET_ADD_TARGET
     *
     * Precreating bean id (and setting "new_with_id" to true) allows us to use
     * this bean in relationship operations (add / delete) and to postpone "save".
     * This way we know target ids in advance and can move ACCOUNTSET_ADD_TARGET
     * logic to HintAccountset after_save logic hook making the queue look like this:
     * - TARGET_ADD
     * - TARGET_ADD
     * - ACCOUNTSET_ADD
     *
     * @param \Person $person
     * @return \HintAccountset
     */
    public static function createUserAccountset(\Person $person)
    {
        $accountset = new static();
        $accountset->assigned_user_id = $person->id;
        $accountset->type = HintAccountsetTypes::OWNER;
        $accountset->category = HintAccountsetCategories::CATEGORY_ALL;

        // to create relationships before bean itself
        $accountset->id = Uuid::uuid1();
        $accountset->new_with_id = true;

        if (!$accountset->load_relationship('notification_targets')) {
            $accountset->save();

            return $accountset;
        }

        // create and add sugar target
        $sugarTarget = \HintNotificationTarget::activateTarget(
            $person->id,
            NotificationTargetTypes::SUGAR_TARGET_TYPE,
            $person->id
        );
        $accountset->notification_targets->add($sugarTarget);

        // ensure user emails are populated
        $emails = [];
        if (!empty($person->emailAddress)) {
            $emails = $person->emailAddress->addresses ?: $person->email;
            if (!$emails) {
                $person->populateFetchedEmail('bean_field');
                $emails = $person->email;
            }
        }

        foreach ($emails as $email) {
            if (!empty($email['primary_address']) && !empty($email['email_address'])) {
                /* @var $user \User */
                $user = $person;
                if ($person instanceof \Employee) {
                    $user = \BeanFactory::retrieveBean('Users', $person->id);
                }

                // create and add email target
                $emailTarget = \HintNotificationTarget::activateTarget(
                    $user->id,
                    NotificationTargetTypes::EMAIL_WEEKLY_TARGET_TYPE,
                    [
                        'email' => $email['email_address'],
                        'timezone' => \TimeDate::userTimezone($user),
                        // just "site" url, as there's no path for dashlet preferences
                        'siteUrl' => \SugarConfig::getInstance()->get('site_url'),
                    ]
                );
                $accountset->notification_targets->add($emailTarget);
                break;
            }
        }

        $accountset->save();

        return $accountset;
    }
}
