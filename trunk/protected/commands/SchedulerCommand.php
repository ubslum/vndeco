<?php
/**
 * SchedulerCommand
 * Run web app command cron job
 */
class SchedulerCommand extends CConsoleCommand {

    /**
     * Execute the action.
     * @param array command line parameters specific for this command
     */
    public function run($args) {

        Yii::app()->sysScheduler;
    }

}