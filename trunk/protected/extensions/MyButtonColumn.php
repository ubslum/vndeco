<?php
/**
 * My ButtonColumn
 * MyButtonColumn extends CButtonColumn in CGridView and adds the attribute
 * 'visible' to the buttons properties so that the buttons can be different from
 * row to row depending on the evaluation of this attribute
 * @link http://www.wuiwa.com/
 * @author Gia Duy (admin@giaduy.info)
 * @copyright Copyright &copy; wuiwa.com
 * @license http://www.wuiwa.com/code/license
 */
class MyButtonColumn extends CButtonColumn
{
	public $viewButtonVisible;
	public $updateButtonVisible;
	public $deleteButtonVisible;

	/**
	 * Initializes the column.
	 * This method registers necessary client script for the button column.
	 * @param CGridView the grid view instance
	 */
	public function init()
	{
		parent::init();

		if(isset($this->buttons['view']) && isset($this->viewButtonVisible))
			$this->buttons['view']['visible']=$this->viewButtonVisible;
		if(isset($this->buttons['update']) && isset($this->updateButtonVisible))
			$this->buttons['update']['visible']=$this->updateButtonVisible;
		if(isset($this->buttons['delete']) && isset($this->deleteButtonVisible))
			$this->buttons['delete']['visible']=$this->deleteButtonVisible;
	}
}
