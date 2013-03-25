<?php

/**
 * SystemScheduler
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class SystemScheduler {

    /**
     * Constructor
     */
    function __construct() {
        ;
    }

    /**
     * Init function
     */
    public function init() {
        $console = FALSE; // run ot not run?
        
        if (isset($_SERVER['REMOTE_ADDR'], $_SERVER['SERVER_ADDR']) && $_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'] && $_SERVER['REMOTE_ADDR'] != '127.0.0.1')
            $console = TRUE; // ok run

        if (!isset($_SERVER['REMOTE_ADDR'], $_SERVER['SERVER_ADDR'], $_SERVER['HTTP_HOST']))
            $console = TRUE; // ok run
        
        if(PHP_OS=='WINNT')
            $console = FALSE; // ok run
        
        if ($console===TRUE)
            $this->run();
    }

    /**
     * Run
     */
    public function run() {
        define('SCHEDULER_TASK', '1');
        $tasks = $this->getTaks();
        foreach ($tasks as $task) {
            $this->runTask($task);
        }
    }

    /**
     * Get the task list
     * @return <type>
     */
    protected function getTaks() {
        $time_now = time();
        /* Load all task need to be run */
        $criteria = new CDbCriteria;
        $criteria->condition = 'next_run<=:now AND enabled=1';
        $criteria->params = array(':now' => $time_now);
        return Scheduler::model()->findAll($criteria);
    }

    /**
     * Run task
     * @param <type> $task
     */
    protected function runTask($task) {
        $time_now = time();
        /* Update time */
        $task->last_run = $time_now;
        if ($task->run_one)
            $task->enabled = 0;
        $task->save();

        /* Include Task */
        
        include(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'tasks' . DIRECTORY_SEPARATOR . $task->task_file . '.php');
        $task_file = new $task->task_file;

        /* Logging */
        $log = new SchedulerLog();
        $log->id_scheduler = $task->id;
        $log->date_run = $time_now;
        $log->ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'internal';
        $log->description = $task_file->run();
        $log->save();
    }

}