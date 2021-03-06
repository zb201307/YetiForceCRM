<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class SMSNotifier_CheckStatus_View extends Vtiger_IndexAjax_View
{

	public function checkPermission(\App\Request $request)
	{
		$moduleName = $request->getModule();

		if (!Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $request->get('record'))) {
			throw new \Exception\NoPermittedToRecord('LBL_PERMISSION_DENIED');
		}
	}

	public function process(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();

		$notifierRecordModel = Vtiger_Record_Model::getInstanceById($request->get('record'), $moduleName);
		$notifierRecordModel->checkStatus();

		$viewer->assign('RECORD', $notifierRecordModel);
		$viewer->view('StatusWidget.tpl', $moduleName);
	}
}
