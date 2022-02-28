<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return redirect()->route('login'); 
});*/
//employee
Route::get('/','EmployeeLoginController@login')->name('employee.login');
Route::post('employee/check-login','EmployeeLoginController@checkLogin')->name('employeeCheckLogin');
Route::post('employee/logout','EmployeeLoginController@logout')->name('employeeLogout');

Route::middleware(['employee'])->group(function(){
	Route::namespace('Employee')->group(function(){
		Route::prefix('employee')->group(function(){
			Route::name('employee.')->group(function(){
				Route::get('home','HomeController@index')->name('home');
				Route::get('profile', 'HomeController@profile')->name('profile');
				Route::post('profile-save', 'HomeController@profileSave')->name('profileSave');
				Route::post('password-save', 'HomeController@passwordSave')->name('passwordSave');
				//userForm
				//Route::get('user-form/{slug?}','HomeController@userForm')->name('userForm');

				//Vendor Controller
				Route::get('vendors','VendorController@index')->name('vendors');
				Route::get('vendor-add','VendorController@add')->name('addVendor');
				Route::post('vendor-save','VendorController@insert')->name('saveVendor');
				Route::get('vendor-edit/{slug}/{page}','VendorController@edit')->name('editVendor');
				Route::post('update-vendor/{slug}/{page}','VendorController@update')->name('updateVendor');
				//Route::post('vendor-status/{slug}','VendorController@statusChange')->name('changeVendorStatus');
				Route::get('remove-permanent-vendor/{slug}','VendorController@remove')->name('removeVendor');
				Route::post('get-City-By-State','VendorController@getCityByState')->name('getVendorCityByState');
				Route::get('vendors-export/{format?}','VendorController@export')->name('exportVendor');
				Route::post('vendor-import','VendorController@import')->name('importVendor');

				Route::post('vendor-form-mail','VendorController@VendorFormMail')->name('VendorFormMail');

				Route::get('vendors-link-share','VendorController@VendorFormLink')->name('VendorFormLink');

				Route::get('vendors-excel','VendorController@VendorExcel')->name('VendorExcel');

				Route::get('vendor-pending-reject-list','VendorController@pendingEmpVendor')->name('pendingEmpVendor');
				Route::post('vendor-request-status/{slug}','VendorController@changeVendorStatus')->name('changeVendorRequestStatus');
				Route::get('pending-vendor-edit/{slug}/{page}','VendorController@editPendingVendor')->name('editPendingVendor');
				Route::post('update-pending-vendor/{slug}/{page}','VendorController@updatePendingVendor')->name('updatePendingVendor');

				

				Route::get('vendor-pdf/{slug}','VendorController@vendorPDF')->name('vendorPDF');

				//ajax
				Route::post('getVendorDetail','VendorController@getVendorDetail')->name('getVendor');
				

				//PO Controller
				Route::get('purchase-orders','PurchaseOrderController@index')->name('POs');
				Route::get('PO-add','PurchaseOrderController@add')->name('addPO');
				Route::post('PO-save','PurchaseOrderController@insert')->name('savePO');
				Route::get('PO-edit/{slug}/{page}','PurchaseOrderController@edit')->name('editPO');
				Route::post('update-PO/{slug}/{page}','PurchaseOrderController@update')->name('updatePO');
				//Route::post('PO-status/{slug}','PurchaseOrderController@statusChange')->name('changeActStatus');
				Route::get('remove-permanent-PO/{slug}','PurchaseOrderController@remove')->name('removePO');
				
				Route::get('PO-pending-reject-list','PurchaseOrderController@pendingPO')->name('pendingPO');
				Route::post('PO-process-status/{slug}','PurchaseOrderController@changePoStatus')->name('changePoStatus');
				Route::get('PO-order-edit/{slug}/{page}','PurchaseOrderController@editPendingPO')->name('editPendingPO');
				Route::post('update-pending-PO/{slug}/{page}','PurchaseOrderController@updatePendingPO')->name('updatePendingPO');

				Route::get('po-pending-img-remove/{slug}','PurchaseOrderController@removePendingPOImage')->name('POPendIMG');

				Route::get('po-approve-img-remove/{slug}','PurchaseOrderController@removeAppPOImage')->name('POAppIMG');
				Route::get('po-PDF/{slug}','PurchaseOrderController@poPDF')->name('poPDF');

				Route::get('po-request-pending-approve/{slug}/{page}','PurchaseOrderController@statusApprove')->name('statusApprovePO');
				Route::post('update-pending-po-approval/{slug}/{page}','PurchaseOrderController@statusRequestApprove')->name('POApprove');

				//ajax
				Route::post('getPoDetail','PurchaseOrderController@getPoDetail')->name('getPoDetail');
				Route::post('PoVendorAjaxResponse','PurchaseOrderController@vendorAjaxResponse')->name('vendorAjaxResponse');

				//invoice
				Route::get('invoices','InvoiceController@index')->name('invoices');
				Route::get('invoice-add','InvoiceController@add')->name('addInvoice');
				Route::post('invoice-save','InvoiceController@insert')->name('saveInvoice');
				Route::get('invoice-edit/{slug}/{page}','InvoiceController@edit')->name('editInvoice');
				Route::post('update-invoice/{slug}/{page}','InvoiceController@update')->name('updateInvoice');
				//Route::post('invoice-status/{slug}','InvoiceController@statusChange')->name('changeInvoiceStatus');
				Route::get('remove-permanent-invoice/{slug}','InvoiceController@remove')->name('removeInvoice');
				Route::get('invoices-pending-reject-list','InvoiceController@pendingInvoice')->name('pendingInvoice');
				Route::get('invoice-pending-edit/{slug}/{page}','InvoiceController@editPendingInvoice')->name('editPendingInvoice');
				Route::post('update-pending-invoice/{slug}/{page}','InvoiceController@updatePendingInvoice')->name('updatePendingInvoice');

				Route::get('invoice-status-approve/{slug}/{page}','InvoiceController@invoiceStatusApprove')->name('invoiceStatusApprove');
				Route::post('invoice-process-status/{slug}/{page}','InvoiceController@changeInvoiceStatus')->name('changeInvoiceActStatus');

				Route::get('invoice-pending-invoice-edit/{slug}/{page}','InvoiceController@editPendingEditInvoice')->name('editPendingInvoiceEdit');
				Route::post('update-pending-invoice-save/{slug}/{page}','InvoiceController@updatePendingUpdateInvoice')->name('updatePendingInvoiceSave');

				Route::get('invoice-item-view/{slug}/{page}','InvoiceController@addItemView')->name('invoiceAddItemView');
				Route::post('invoice-item-save/{slug}/{page}','InvoiceController@saveItemDetail')->name('invoiceAddItemSave');

				Route::get('po-invoice-pdf/{slug}','InvoiceController@PoInvoicePDF')->name('PoInvoicePDF');

				//ajax
				Route::post('getInvoiceDetail','InvoiceController@getInvoiceDetail')->name('getInvoiceDetail');
				Route::post('invoiceVendorAjax','InvoiceController@vendorAjaxResponse')->name('invoiceVendorAjax');
				Route::post('InvoicePOAjaxResponse','InvoiceController@InvoicePOAjaxResponse')->name('InvoicePOAjaxResponse');
				Route::post('getInvoiceItemRow','InvoiceController@getInvoiceItemRow')->name('getInvoiceItemRow');

				//without po invoice
				Route::get('without-po-invoices','WithoutPoInvoiceController@index')->name('withoutPoinvoices');
				Route::get('without-po-invoice-add','WithoutPoInvoiceController@add')->name('addWithoutPoInvoice');
				Route::post('without-po-invoice-save','WithoutPoInvoiceController@insert')->name('saveWithoutPoInvoice');
				
				Route::get('remove-permanent-without-po-invoice/{slug}','WithoutPoInvoiceController@remove')->name('removeWithoutPoInvoice');
				Route::get('without-po-invoices-pending-reject-list','WithoutPoInvoiceController@pendingInvoice')->name('pendingWithoutPoInvoice');
				Route::get('without-po-invoice-pending-edit/{slug}/{page}','WithoutPoInvoiceController@editPendingInvoice')->name('editPendingWithoutPoInvoice');
				Route::post('update-pending-without-po-invoice/{slug}/{page}','WithoutPoInvoiceController@updatePendingInvoice')->name('updatePendingWithoutPoInvoice');

				Route::get('without-po-invoice-status-approve/{slug}/{page}','WithoutPoInvoiceController@invoiceStatusApprove')->name('WithoutPoinvoiceStatusApprove');
				Route::post('without-po-invoice-process-status/{slug}/{page}','WithoutPoInvoiceController@changeInvoiceStatus')->name('changeWithoutPoInvoiceActStatus');

				Route::get('without-po-invoice-pending-invoice-edit/{slug}/{page}','WithoutPoInvoiceController@editPendingEditInvoice')->name('editPendingWithoutPoInvoiceEdit');
				Route::post('update-pending-without-po-invoice-save/{slug}/{page}','WithoutPoInvoiceController@updatePendingUpdateInvoice')->name('updatePendingWithoutPoInvoiceSave');

				Route::get('without-po-item-view/{slug}/{page}','WithoutPoInvoiceController@addItemView')->name('WithoutPoAddItemView');
				Route::post('without-po-item-save/{slug}/{page}','WithoutPoInvoiceController@saveItemDetail')->name('WithoutPoAddItemSave');
				Route::get('without-po-invoice-pdf/{slug}','WithoutPoInvoiceController@withoutPOInvoicePDF')->name('withoutPOInvoicePDF');

				//ajax
				Route::post('get-without-po-InvoiceDetail','WithoutPoInvoiceController@getInvoiceDetail')->name('getWithoutPoInvoiceDetail');
				Route::post('without-po-invoiceVendorAjax','WithoutPoInvoiceController@vendorAjaxResponse')->name('WithoutPoinvoiceVendorAjax');

				//employee pay
				Route::get('employee-pay-form-add','EmployeePayController@add')->name('addEmployeePayForm');
				Route::post('getEmpCodeEmpPay','EmployeePayController@getEmpCodeEmpPay')->name('getEmpCodeEmpPay');
				Route::post('employee-payment-request-save','EmployeePayController@insert')->name('EmployeePayFormSave');
				Route::get('employee-payment-pending-reject-list','EmployeePayController@pendingRequest')->name('pendingEmpPay');
				Route::get('employee-pay-form-remove/{slug}','EmployeePayController@remove')->name('removeEmployeePay');

				Route::get('employee-request-pending-edit/{slug}/{page}','EmployeePayController@editPending')->name('editPendingEmployeePay');
				Route::post('update-pending-employee-request-save/{slug}/{page}','EmployeePayController@updatePending')->name('EmployeePayFormUpdate');

				Route::get('employee-request-pending-approve/{slug}/{page}','EmployeePayController@statusApprove')->name('statusApproveEmployeePay');
				Route::post('update-pending-employee-approval/{slug}/{page}','EmployeePayController@statusRequestApprove')->name('EmployeePayFormApprove');
				Route::get('employee-payment-approved-list','EmployeePayController@index')->name('approvedEmpPay');

				Route::get('emp-request-pen-img-remove/{slug}','EmployeePayController@removePendingReqImage')->name('empReqPendIMG');

				Route::get('employee-pay-pdf/{slug}','EmployeePayController@employeePayPDF')->name('employeePayPDF');

				//ajax
				Route::post('get-employee-request-detail','EmployeePayController@getEmpPayDetail')->name('getEmpPayDetail');
				Route::post('get-employeePay-full-array','EmployeePayController@getEmpPayFullArray')->name('getEmpPayFullArray');
				Route::post('getEmpPayItemRowByClaim','EmployeePayController@getItemRowByClaim')->name('getEmpPayItemRowByClaim');
				Route::post('getMedicalEmpPayHistory','EmployeePayController@getMedicalPayHistory')->name('getMedicalEmpPayHistory');

				//Internal Transfer
				Route::get('internal-Transfer-add','InternalTransferController@add')->name('addInternalTransfer');
				Route::post('Internal-Transfer-save','InternalTransferController@insert')->name('InternalTransferSave');
				Route::get('internal-transfer-pending-reject-list','InternalTransferController@pendingRequest')->name('pendingInternalTransfer');
				Route::get('InternalTransfer-form-remove/{slug}','InternalTransferController@remove')->name('removeInternalTransfer');

				Route::get('Internal-Transfer-pending-edit/{slug}/{page}','InternalTransferController@editPending')->name('editPendingInternalTransfer');
				Route::post('update-pending-Internal-Transfer-save/{slug}/{page}','InternalTransferController@updatePending')->name('InternalTransferUpdate');

				Route::get('Internal-Transfer-pending-approve/{slug}/{page}','InternalTransferController@statusApprove')->name('statusApproveInternalTransfer');
				Route::post('update-pending-InternalTransfer-approval/{slug}/{page}','InternalTransferController@statusRequestApprove')->name('InternalTransferApprove');
				Route::get('InternalTransfer-approved-list','InternalTransferController@index')->name('approvedInternalTransfer');

				Route::get('Internal-Transfer-pen-img-remove/{slug}','InternalTransferController@removeInternalTransferImage')->name('InternalTransferPendIMG');
				Route::get('internal-transfer-pdf/{slug}','InternalTransferController@bnkPDF')->name('internalTranferPDF');
				
				//ajax
				Route::post('getInternalTrnsDetail','InternalTransferController@getInternalTrnsDetail')->name('getInternalTrnsDetail');
				Route::post('getInternalTransBankAccountArray','InternalTransferController@getBankAccountArray')->name('getInternalTransBankAccountArray');

				//Bulk upload
				Route::get('bulk-upload-add','BulkUploadController@add')->name('addBulkUpload');
				Route::post('bulk-upload-request-save','BulkUploadController@insert')->name('BulkUploadSave');
				Route::get('bulk-upload-pending-reject-list','BulkUploadController@pendingRequest')->name('pendingBulkUpload');
				Route::get('bulk-upload-remove/{slug}','BulkUploadController@remove')->name('removeBulkUpload');

				Route::get('bulk-upload-pending-edit/{slug}/{page}','BulkUploadController@editPending')->name('editPendingBulkUpload');
				Route::post('update-pending-bulk-upload-save/{slug}/{page}','BulkUploadController@updatePending')->name('BulkUploadUpdate');

				Route::get('bulk-upload-pending-approve/{slug}/{page}','BulkUploadController@statusApprove')->name('statusApproveBulkUpload');
				Route::post('update-bulk-upload-approval/{slug}/{page}','BulkUploadController@statusRequestApprove')->name('BulkUploadApprove');
				Route::get('bulk-upload-approved-list','BulkUploadController@index')->name('approvedBulkUpload');

				Route::get('bulk-upload-pen-img-remove/{slug}','BulkUploadController@removePendingReqImage')->name('bulkUploadPendIMG');
				Route::get('bulk-upload-pdf/{slug}','BulkUploadController@bulkUploadPDF')->name('bulkUploadPDF');

				Route::get('bulk-upload-export/{slug}','BulkUploadController@bulkExport')->name('bulkUploadExport');
				//ajax
				Route::post('get-bulk-upload-detail','BulkUploadController@BulkUploadDetail')->name('getBulkUploadDetail');

				//report
				Route::post('get-all-emp-req-report-detail','HomeController@getEmpRequestRepDetail')->name('getEmpRequestRepDetail');
				Route::post('Employee-All-Request-Export','HomeController@employeeAllRequestExport')->name('employeeAllRequestExport');
				
				//dashboard
				Route::post('payment-offoce-approval-import','HomeController@paymentOfficeApproval')->name('paymentOfficeApproval');

				//common ajax
				Route::post('getBankCommonDetail','HomeController@getBankCommonDetail')->name('getBankCommonDetail');
				

			});
		});
	});
});

Route::post('get-vendor-form-City-By-State','Employee\VendorController@getVendorFormCityByState')->name('employee.getVendorFormCityByState');


//vendor
Route::get('vendor/login','VendorLoginController@login')->name('vendor.login');
Route::post('vendor/check-login','VendorLoginController@checkLogin')->name('vendorCheckLogin');
Route::post('vendor/logout','VendorLoginController@logout')->name('vendorLogout');

Route::middleware(['vendor'])->group(function(){
	Route::namespace('Vendor')->group(function(){
		Route::prefix('vendor')->group(function(){
			Route::name('vendor.')->group(function(){
				Route::get('home','HomeController@index')->name('home');
				Route::get('profile', 'HomeController@profile')->name('profile');
				Route::post('profile-save', 'HomeController@profileSave')->name('profileSave');
				Route::post('password-save', 'HomeController@passwordSave')->name('passwordSave');
			});
		});
	});
});

Auth::routes(['register' => false]);

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('admin/login','AdminLoginController@login')->name('admin.login');
Route::get('admin','AdminLoginController@login')->name('admin.login');
Route::post('admin/check-login','AdminLoginController@checkLogin')->name('adminCheckLogin');
Route::post('admin/logout','AdminLoginController@logout')->name('adminLogout');
Route::middleware(['is_admin'])->group(function(){

	Route::namespace('Admin')->group(function(){

		Route::name('admin.')->group(function(){

			Route::prefix('admin')->group(function(){

				// admin
				Route::get('home', 'HomeController@adminHome')->name('home');
				Route::get('profile', 'HomeController@profile')->name('profile');
				Route::post('profile-save', 'HomeController@profileSave')->name('profileSave');
				Route::post('password-save', 'HomeController@passwordSave')->name('passwordSave');

				// setting
				Route::get('setting','SettingController@index')->name('setting');
				Route::post('setting-save','SettingController@settingSave')->name('settingSave');

				
				//state
				Route::get('states','StateController@index')->name('states');
				Route::get('state-add','StateController@add')->name('addState');
				Route::post('state-save','StateController@insert')->name('saveState');
				Route::get('state-edit/{slug}','StateController@edit')->name('editState');
				Route::post('update-state/{slug}','StateController@update')->name('updateState');
				Route::post('state-status/{slug}','StateController@statusChange')->name('changeStateStatus');
				Route::get('remove-state/{slug}','StateController@remove')->name('removeState');
				Route::get('trashed-state','StateController@trashed')->name('trashedStates');
				Route::get('restore-state/{slug}','StateController@restore')->name('restoreState');
				Route::get('remove-permanent-state/{slug}','StateController@removeTrashed')->name('removeTrashedState');

				//city
				Route::get('cities','CityController@index')->name('cities');
				Route::get('city-add','CityController@add')->name('addCity');
				Route::post('city-save','CityController@insert')->name('saveCity');
				Route::get('city-edit/{slug}','CityController@edit')->name('editCity');
				Route::post('update-city/{slug}','CityController@update')->name('updateCity');
				Route::post('city-status/{slug}','CityController@statusChange')->name('changeCityStatus');
				Route::get('remove-city/{slug}','CityController@remove')->name('removeCity');
				Route::get('trashed-city','CityController@trashed')->name('trashedCities');
				Route::get('restore-city/{slug}','CityController@restore')->name('restoreCity');
				Route::get('remove-permanent-city/{slug}','CityController@removeTrashed')->name('removeTrashedCity');
				
				//Role
				Route::get('roles','RoleController@index')->name('roles');
				Route::get('role-add','RoleController@add')->name('addRole');
				Route::post('role-save','RoleController@insert')->name('saveRole');
				Route::get('role-edit/{slug}','RoleController@edit')->name('editRole');
				Route::post('update-role/{slug}','RoleController@update')->name('updateRole');
				Route::post('role-status/{slug}','RoleController@statusChange')->name('changeRoleStatus');
				Route::get('remove-permanent-role/{slug}','RoleController@remove')->name('removeTrashedRole');

				//Assign Process
				Route::get('assign-process','AssignProcessController@index')->name('assignProcess');
				Route::get('assign-process-add','AssignProcessController@add')->name('addAssignProcess');
				Route::post('assign-process-save','AssignProcessController@insert')->name('saveAssignProcess');
				Route::get('assign-process-edit/{slug}','AssignProcessController@edit')->name('editAssignProcess');
				Route::post('update-assign-process/{slug}','AssignProcessController@update')->name('updateAssignProcess');
				Route::post('assign-process-status/{slug}','AssignProcessController@statusChange')->name('changeAssignProcessStatus');
				Route::get('remove-permanent-assign-process/{slug}','AssignProcessController@removeTrashed')->name('removeTrashedAssignProcess');

				//Employee Controller
				Route::get('employees','EmployeeController@index')->name('employees');
				Route::get('employees-add','EmployeeController@add')->name('addEmployees');
				Route::post('employees-save','EmployeeController@insert')->name('saveEmployee');
				Route::get('employees-edit/{slug}/{page}','EmployeeController@edit')->name('editEmployees');
				Route::post('update-employees/{slug}/{page}','EmployeeController@update')->name('updateEmployees');
				Route::post('employees-status/{slug}','EmployeeController@statusChange')->name('changeEmployeesStatus');
				Route::get('remove-permanent-employees/{slug}','EmployeeController@remove')->name('removeEmployees');
				Route::post('getCityByState','EmployeeController@getCityByState')->name('getCityByState');
				Route::get('employees-export/{format?}','EmployeeController@export')->name('exportEmployees');
				Route::post('employees-import','EmployeeController@import')->name('importEmployee');

				Route::get('employee-excel','EmployeeController@EmployeeExcel')->name('EmployeeExcel');
				
				//ajax
				Route::post('getEmployeesDetail','EmployeeController@getEmployeesDetail')->name('getEmployees');
				
				//Claim type
				Route::get('nature-claim-types','ClaimTypeController@index')->name('claimTypes');
				Route::get('nature-claim-type-add','ClaimTypeController@add')->name('addClaimType');
				Route::post('nature-claim-type-save','ClaimTypeController@insert')->name('saveClaimType');
				Route::get('nature-claim-type-edit/{slug}','ClaimTypeController@edit')->name('editClaimType');
				Route::post('update-nature-claim-type/{slug}','ClaimTypeController@update')->name('updateClaimType');
				Route::post('nature-claim-type-status/{slug}','ClaimTypeController@statusChange')->name('changeClaimTypeStatus');
				Route::get('remove-permanent-nature-claim-type/{slug}','ClaimTypeController@remove')->name('removeTrashedClaimType');

				//Apex
				Route::get('apexs','ApexController@index')->name('apexs');
				Route::get('apex-add','ApexController@add')->name('addApex');
				Route::post('apex-save','ApexController@insert')->name('saveApex');
				Route::get('apex-edit/{slug}','ApexController@edit')->name('editApex');
				Route::post('update-apex/{slug}','ApexController@update')->name('updateApex');
				Route::post('apex-status/{slug}','ApexController@statusChange')->name('changeApexStatus');
				Route::get('remove-permanent-apex/{slug}','ApexController@remove')->name('removeTrashedApex');

				//bank Account
				Route::get('bank-accounts','BankAccountController@index')->name('bankAccounts');
				Route::get('bank-account-add','BankAccountController@add')->name('addBankAccount');
				Route::post('bank-account-save','BankAccountController@insert')->name('saveBankAccount');
				Route::get('bank-account-edit/{slug}','BankAccountController@edit')->name('editBankAccount');
				Route::post('update-bank-account/{slug}','BankAccountController@update')->name('updateBankAccount');
				Route::post('bank-account-status/{slug}','BankAccountController@statusChange')->name('changeBankAccountStatus');
				Route::get('remove-permanent-bank-account/{slug}','BankAccountController@remove')->name('removeTrashedBankAccount');
				//report
				Route::get('employee-Invoices-report','ReportController@employeeInvoice')->name('employeeInvoice');
				Route::get('employee-WithoutPo-Invoice-report','ReportController@employeeWithoutPoInvoice')->name('employeeWithoutPoInvoice');
				Route::get('all-vendor-report','ReportController@allVendorList')->name('allVendorReportList');
				Route::post('vendor-status-report/{slug}','ReportController@vendorStatusChange')->name('vendorReportStatusChange');
				Route::get('all-admin-request-report','ReportController@allAdminRequest')->name('allAdminRequest');
				Route::get('employee-employeePay-report','ReportController@employeeEmployeePay')->name('employeePayReport');
				Route::get('employee-employeePaid-report','ReportController@employeePaidReport')->name('employeePaidReport');
				Route::get('employee-po-report','ReportController@employeePOreport')->name('employeePOreport');
				Route::get('employee-po-vendor-wise-report','ReportController@employeePoVendorWiseReport')->name('employeePoVendorWiseReport');

				Route::get('employee-internal-transfer-report','ReportController@employeeInternalTransferReport')->name('employeeInternalTransferReport');
				Route::get('employee-state-transfer-report','ReportController@employeeStateTransferReport')->name('employeeStateTransferReport');

				Route::get('employee-invoice-payment-report','ReportController@employeePaymentReportInvoice')->name('employeePaymentReportInvoice');
				
				Route::get('employee-bulk-upload-report','ReportController@employeeBulkUploadReport')->name('employeeBulkUploadReport');

				Route::get('employee-tds-payable-report','ReportController@allTdsPayableReport')->name('allTdsPayableReport');

				Route::post('admin-all-request-export','ReportController@adminAllRequestExport')->name('adminAllRequestExport');

				Route::post('admin-single-request-export/{slug}','ReportController@AdminSingleRequestExport')->name('AdminSingleRequestExport');
				Route::post('admin-tds-request-export','ReportController@adminTdsRequestExport')->name('adminTdsRequestExport');
				Route::post('admin-invoice-payment-request-export','ReportController@adminInvoicePaymentRequestExport')->name('adminInvoicePaymentRequestExport');
				
				
				//ajax
				Route::post('getInvoiceDetail','ReportController@getInvoiceDetail')->name('getInvoiceDetail');
				Route::post('getWithoutPoInvoiceDetail','ReportController@getWithoutPoInvoiceDetail')->name('getWithoutPoInvoiceDetail');
				Route::post('getReportVendorDetail','ReportController@getVendorDetail')->name('getReportVendorDetail');
				Route::post('getAdminRequestRepDetail','ReportController@getAdminRequestRepDetail')->name('getAdminRequestRepDetail');

				//CostCenter
				Route::get('cost-centers','CostCenterController@index')->name('cost_centers');
				Route::get('cost-center-add','CostCenterController@add')->name('addCostCenter');
				Route::post('cost-center-save','CostCenterController@insert')->name('saveCostCenter');
				Route::get('cost-center-edit/{slug}','CostCenterController@edit')->name('editCostCenter');
				Route::post('update-cost-center/{slug}','CostCenterController@update')->name('updateCostCenter');
				Route::post('cost-center-status/{slug}','CostCenterController@statusChange')->name('changeCostCenterStatus');
				Route::get('remove-permanent-cost-center/{slug}','CostCenterController@remove')->name('removeTrashedCostCenter');

				//DebitAccount
				Route::get('debit-accounts','DebitAccountController@index')->name('debit_accounts');
				Route::get('debit-account-add','DebitAccountController@add')->name('addDebitAccount');
				Route::post('debit-account-save','DebitAccountController@insert')->name('saveDebitAccount');
				Route::get('debit-account-edit/{slug}','DebitAccountController@edit')->name('editDebitAccount');
				Route::post('update-debit-account/{slug}','DebitAccountController@update')->name('updateDebitAccount');
				Route::post('debit-account-status/{slug}','DebitAccountController@statusChange')->name('changeDebitAccountStatus');
				Route::get('remove-permanent-debit-account/{slug}','DebitAccountController@remove')->name('removeTrashedDebitAccount');

				//Category
				Route::get('categories','CategoryController@index')->name('categories');
				Route::get('category-add','CategoryController@add')->name('addCategory');
				Route::post('category-save','CategoryController@insert')->name('saveCategory');
				Route::get('categorys-edit/{slug}','CategoryController@edit')->name('editCategory');
				Route::post('update-category/{slug}','CategoryController@update')->name('updateCategory');
				Route::post('category-status/{slug}','CategoryController@statusChange')->name('changeCategoryStatus');
				Route::get('remove-permanent-category/{slug}','CategoryController@remove')->name('removeTrashedCategory');
				
			});
			
		});
			
	});
});
 

Route::get('vendor-form/{emp_code?}','Employee\VendorController@vendorForm')->name('vendorForm');
Route::post('vendor-form-save/{emp_code?}','Employee\VendorController@saveVendorForm')->name('saveVendorForm');

Route::get('form-conf-msg/{id}','Employee\VendorController@formConfMsg')->name('employee.formConfMsg');