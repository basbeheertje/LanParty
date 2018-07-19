<?php

namespace common\components;

use yii\queue\cli\SignalLoop;

/**
 * Class Queue
 * @package common\components
 *
 * @property int $jobsPerRun @todo get from params
 * @property SignalLoop $loop
 */
class Queue extends \yii\queue\db\Queue {
    public $jobsPerRun = 15;
    public $loop;

    /**
     * Initiation of the queue
     */
    public function init () {
        parent::init();
        $this->loop = new SignalLoop($this);
    }

    /**
     * Runs the queue
     * @param bool $repeat
     * @param int $delay
     * @return null|int exit code.
     */
    public function run ($repeat, $delay = 0) {
        /** @var int $jobsRun */
        $jobsRun = 0;
        while ($this->loop->canContinue() && $jobsRun < $this->jobsPerRun && ($payload = $this->reserve())) {
            if ($this->handleMessage(
                $payload['id'],
                $payload['job'],
                $payload['ttr'],
                $payload['attempt']
            )) {
                $this->release($payload);
            }
            $jobsRun++;
        }
    }

    /**
     * Error handler
     * @param $event
     */
    public function onAfterError ($event) {
        throw $event->error;
    }
}