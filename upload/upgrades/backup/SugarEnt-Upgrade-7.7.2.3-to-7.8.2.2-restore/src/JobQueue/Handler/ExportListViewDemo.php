<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\Sugarcrm\JobQueue\Handler;

use Sugarcrm\Sugarcrm\JobQueue\Client\ClientInterface;
use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;

class ExportListViewDemo implements RunnableInterface, SubtaskCapableInterface
{
    /**
     * @var string $module Module name.
     */
    protected $module;

    /**
     * @var array $data Of Ids.
     */
    protected $data;

    /**
     * @var ClientInterface To create related jobs.
     */
    protected $client;

    /**
     * @param string $module
     * @param string $data
     * @throws LogicException
     */
    public function __construct($module, $data)
    {
        if (empty($data)) {
            throw new LogicException('Nothing to export.');
        }
        $this->module = $module;
        $this->data = $data;
    }

    /**
     * Divides target records into chunks and save results into a note.
     * {@inheritdoc}
     */
    public function run()
    {
        // Or a link to a Note record can be passed via constructor.
        $note = \BeanFactory::getBean('Notes');
        $note->id = create_guid();
        $note->new_with_id = true;
        $note->name = "ExportListView_{$this->module}_{$note->id}";
        $note->filename = $note->id;
        $note->save();

        $fileName = "upload://{$note->id}";
        file_put_contents($fileName, '');

        $records = array_chunk($this->data, \SugarConfig::getInstance()->get('max_record_fetch_size'));
        foreach ($records as $chunk) {
            $this->client->exportToCSVDemo($this->module, $chunk, $fileName);
        }

        return \SchedulersJob::JOB_RUNNING;
    }
}
