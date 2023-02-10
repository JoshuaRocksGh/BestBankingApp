<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountCreation\SavingsAccountCreationController;
use App\Http\Controllers\AccountEnquiry\AccountEnquiryController;
use App\Http\Controllers\AccountEnquiry\GetAccountDescription;
use App\Http\Controllers\AccountServices\accountCreationController;
use App\Http\Controllers\AccountServices\AccountServicesController;
use App\Http\Controllers\AccountServices\AtmCardRequestController;
use App\Http\Controllers\AccountServices\ChequeBookRequestController as AccountServicesChequeBookRequestController;
use App\Http\Controllers\AccountServices\ComplaintController;
use App\Http\Controllers\AccountServices\StatementRequestController;
use App\Http\Controllers\AccountServices\StopChequeController;
use App\Http\Controllers\Authentication\ForgotPasswordController;
use App\Http\Controllers\AccountServices\KycController;
use App\Http\Controllers\AccountServices\SalaryAdvanceController;
use App\Http\Controllers\Authentication\LoginController as AuthenticationLoginController;
use App\Http\Controllers\Authentication\ResetPasswordController;
use App\Http\Controllers\Payments\Beneficiary\PaymentBeneficiaryController;
use App\Http\Controllers\Transfers\Beneficiary\TransferBeneficiaryController;
use App\Http\Controllers\Branch\BranchesController;
use App\Http\Controllers\BranchLocator\branchLocatorController;
use App\Http\Controllers\Budgeting\SpendingStaticsController;
use App\Http\Controllers\Cards\CardsController;
use App\Http\Controllers\Cheques\ChequesApprovedController;
use App\Http\Controllers\Cheques\ChequesPendingController;
use App\Http\Controllers\Cheques\ChequesRejectedController;
use App\Http\Controllers\Corporate\Approvals\PendingController;
use App\Http\Controllers\Corporate\Approvals\ApprovedController;
use App\Http\Controllers\Corporate\Approvals\ApprovedRequestController;
use App\Http\Controllers\Corporate\Approvals\RejectedController;
use App\Http\Controllers\Corporate\GeneralFunctions\FunctionsController as GeneralFunctionsFunctionsController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Enquiry\EnquiryController;
use App\Http\Controllers\FAQ\FAQController;
use App\Http\Controllers\FixedDeposit\FixedDepositAccountController;
use App\Http\Controllers\GeneralFunctions\FunctionsController;
use App\Http\Controllers\Loan\LoanRequestController;
use App\Http\Controllers\Loan\LoansController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MaileController;
use App\Http\Controllers\Payments\Bulk\BulkKorporController;
use App\Http\Controllers\Payments\BulkUpload\BulkUploadsController;
use App\Http\Controllers\Payments\BulkUpload\CorporateKorporController as BulkUploadCorporateKorporController;
use App\Http\Controllers\Payments\CardlessController;
use App\Http\Controllers\Payments\KorporController;
use App\Http\Controllers\Payments\PaymentsController;
use App\Http\Controllers\Payments\paymentController;
use App\Http\Controllers\Settings\ChangePasswordController;
use App\Http\Controllers\Settings\ChangePinController;
use App\Http\Controllers\Settings\settingsController;
use App\Http\Controllers\TradeFinance\TradeFinanceController;
use App\Http\Controllers\transferController;
use App\Http\Controllers\Transfers\BulkUpload\BulkUploadsController as BulkUploadBulkUploadsController;
use App\Http\Controllers\Transfers\LocalBankController;
use App\Http\Controllers\Transfers\MultipleTransfersController;
use App\Http\Controllers\Transfers\OwnAccountController;
use App\Http\Controllers\Transfers\SameBankController;
use App\Http\Controllers\Transfers\InternationalBankController;
use App\Http\Controllers\Transfers\SchedulePayment\SchedulePaymentController;
use App\Http\Controllers\Transfers\StandingOrderController;
use App\Http\Controllers\Transfers\TransferStatusController;
use App\Http\Controllers\SelfEnrollController;
use App\Http\Controllers\Transfers\BollorieController;
use App\Http\Controllers\Transfers\SwiftMT101Controller;

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

// --- AUTHENTICATION
Route::get('/', [AuthenticationLoginController::class, 'login']);
Route::post('/login-api', [AuthenticationLoginController::class, 'loginApi']);
Route::get('/login', [AuthenticationLoginController::class, 'login']);
Route::post('/validate-customer', [SelfEnrollController::class, 'validateCustomer']);
Route::post('/confirm-customer', [SelfEnrollController::class, 'confirmCustomer']);
Route::post('/register-customer', [SelfEnrollController::class, 'registerCustomer']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'email_reset_password']);
Route::get('/change-password', [ResetPasswordController::class, 'change_password']);


Route::get('/multiple-transfers', [MultipleTransfersController::class, 'index'])->name('multiple-transfers');
Route::post('upload_', [BulkUploadBulkUploadsController::class, 'upload_'])->name('upload_');
// Route::post('/bulk-file-upload', [BulkUploadBulkUploadsController::class, 'bulk_file_upload']);
Route::post('/submit-kyc', [KycController::class, 'submit_kyc'])->name('submit-kyc');

// Route::get('/approved-transaction', [PendingController::class, 'approved_transaction'])->name('approved-transaction');
// Route::get('/approvals-pending/{request_id}/{customer_no}', [PendingController::class, 'approvals_pending'])->name('approvals-pending/request_id/customer_no');
Route::get('/get-pending-requests', [GeneralFunctionsFunctionsController::class, 'get_pending_requests'])->name('get-pending-requests');
Route::get('/get-transfer-status', [GeneralFunctionsFunctionsController::class, 'get_transfer_requests']);
// Route::get('/approvals-pending-transfer-details', [PendingController::class, 'approvals_pending_transfer_details']);
Route::get('/approvals-pending-transfer-details/{request_id}/{customer_no}', [PendingController::class, 'approvals_pending_transfer_details']);
Route::post('/approved-pending-request', [ApprovedRequestController::class, 'approved_request'])->name('approved-pending-request');
Route::post('/reject-pending-request', [ApprovedRequestController::class, 'reject_request'])->name('reject-pending-request');
Route::get('/account-creation', [accountCreationController::class, 'account_creation'])->name('account-creation');
Route::get('/account-creation/savings-account-creation', [accountCreationController::class, 'savings_account_creation'])->name('account-creation/savings-account-creation');
Route::get('/branches', [BranchesController::class, 'branches'])->name('branches');
Route::get('/faq', [FAQController::class, 'index'])->name('faq');
Route::get('/enquiry', [EnquiryController::class, 'index'])->name('enquiry');

//route to control the accountEnquiry screen
Route::get('print-account-statement', [AccountEnquiryController::class, 'print_account_statement'])->name('print-account-statement');
Route::get('print-account-statement-history', [AccountEnquiryController::class, 'print_account_statement_history'])->name('print-account-statement-history');
Route::post('account-transaction-history', [AccountEnquiryController::class, 'account_transaction_history'])->name('account-transaction-history');
Route::get('list-of-accounts', [AccountEnquiryController::class, 'list_of_accounts'])->name('list-of-accounts');
Route::post('get-account-description', [GetAccountDescription::class, 'get_account_description'])->name('get-account-description');
Route::post('validate-account-no', [FunctionsController::class, 'validate_account_no'])->name('validate-account-no');
Route::post('bulkupload.import', [BulkUploadsController::class, 'import'])->name('bulkupload.import');
Route::get('pay-again', [paymentController::class, 'pay_again_payment'])->name('pay-again');
Route::get('manage-cards', [CardsController::class, 'block_debit_card'])->name('manage-cards');
Route::get('replace-card', [CardsController::class, 'replace_card'])->name('replace-card');
Route::get('biometric-setup', [settingsController::class, 'biometric_setup'])->name('biometric-setup');
Route::get('/logout', [LogoutController::class, 'logout']);
Route::get('/session-logout', [LogoutController::class, 'session_logout']);
Route::get('/send-email', [MaileController::class, 'send_email'])->name('send-email');

//route to display the stop fd screen

//route to display the biometric setup screen


// Route::middleware(['userAuth'])->group(function () {

// });
Route::get('currency-converter', [transferController::class, 'forex_request'])->name('currency-converter');

Route::group(['middleware' => ['userAuth']], function () {

    // --- Home ---------------
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // --- ACCOUNTS
    Route::get('account-enquiry', [AccountEnquiryController::class, 'account_enquiry']);
    Route::get('my-accounts', [AccountEnquiryController::class, 'my_accounts']);
    Route::get('accounts-statement', [AccountEnquiryController::class, 'accounts_statement']);

    // --- TRANSFERS
    Route::get('/transfer-status', [TransferStatusController::class, 'transfer_status']);
    Route::get('/international-bank', [transferController::class, 'international_bank_']);
    Route::get('/beneficiary-list', [transferController::class, 'beneficiary_list']);
    Route::get('/same-bank', [SameBankController::class, 'same_bank']);
    Route::get('/local-bank', [LocalBankController::class, 'local_bank']);
    Route::get('/own-account', [OwnAccountController::class, 'own_account']);
    Route::get('bollore-link', [BollorieController::class, 'view_bollorie']);
    Route::get('/standing-order', [StandingOrderController::class, 'display_standing_order']);
    Route::get('/standing-order-status', [StandingOrderController::class, 'display_standing_order_status']);
    Route::get('/bulk-transfer', [BulkUploadBulkUploadsController::class, 'index']);
    Route::post('/update-upload', [BulkUploadBulkUploadsController::class, 'updaate_upload']);
    Route::post('bollore-tranfer', [BollorieController::class, 'bollore_transfer']);
<<<<<<< HEAD
    Route::get('/swift_mt101', [SwiftMT101Controller::class, 'view_swift'])->name('swift_mt101');
=======
    // Route::get('/swift_mt101', [SwiftMT101Controller::class, 'view_swift'])->name('swift_mt101');
>>>>>>> c5876533a83de9aa4b90bde63a909719613ea497
    // Route::post('/swift_mt101', [SwiftMT101Controller::class, 'upload_mt101'])->name('swift_mt101');


    // --- PAYMENTS
    Route::get('/payments', [PaymentsController::class, 'paymentTypes'])->name('payment-type');
    Route::get('/mobile-money', [MobileMoneyController::class, 'index'])->name('mobile-money');
    Route::get('qr-payment', [paymentController::class, 'qr_payment']);
    Route::get('cardless-payment', [paymentController::class, 'cardless_payment']);
    Route::get('airtime-payment', [paymentController::class, 'airtime_payment'])->name('airtime-payment');
    Route::get('/bulk-salone-link', [KorporController::class, 'bulk_korpor'])->name('bulk-salone-link');
    Route::get('/utility-payment', [paymentController::class, 'utilities'])->name('utility-payment');
    Route::get('salone-link', [paymentController::class, 'e_korpor'])->name('salone-link');
    Route::get('bulk-upload-payment', [paymentController::class, 'bulk_upload_payment'])->name('bulk-upload-payment');
    Route::get('payment-beneficiary', [paymentController::class, 'payment_beneficiary_list'])->name('payment-beneficiary');
    Route::get('payment-beneficiary-list', [paymentController::class, 'beneficiary_list'])->name('payment-beneficiary-list');
    Route::get('schedule-payment', [paymentController::class, 'schedule_payment'])->name('schedule-payment');
    Route::get('/saved-beneficiary', [paymentController::class, 'saved_beneficiary'])->name('saved-beneficiary');
    Route::get('/saved-beneficiary/mobile-money-payment', [paymentController::class, 'mobile_money_payment'])->name('saved-beneficiary-mobile-money-payment');
    Route::get('/saved-beneficiary/utility-payment', [paymentController::class, 'utility_payment'])->name('saved-beneficiary/utility-payment');
    Route::get('/one-time-payment', [paymentController::class, 'one_time'])->name('one-time-payment');
    Route::get('/payment-add-beneficiary', [paymentController::class, 'add_beneficiary'])->name('payment-add-beneficiary');
    Route::get('/payment-add-beneficiary/mobile-money-beneficiary', [paymentController::class, 'mobile_money_beneficiary'])->name('mobile-money-beneficiary');
    Route::get('/payment-add-beneficiary/utility-payment-beneficiary', [paymentController::class, 'utility_payment_beneficiary'])->name('utility-payment-beneficiary');
    Route::post('/korpor_upload_', [BulkUploadBulkUploadsController::class, 'bulk_korpor_upload_'])->name('korpor_upload_');
    Route::get('/download_same_bank_file', [BulkUploadBulkUploadsController::class, 'download_same_bank'])->name('download-same-bank-file');
    Route::get('/download_other_bank_file', [BulkUploadBulkUploadsController::class, 'download_other_bank'])->name('download-other-bank-file');
    // Route::get('/download_bulk_korpor_file', [BulkUploadBulkUploadsController::class, 'download_bulk_korpor']);
    // Route::get('/bulk_korpor_file_download', [BulkUploadBulkUploadsController::class, 'bulk_korpor_download'])->name('bulk-korpor-file-download');
    Route::get('/korpor_file_download', [BulkUploadBulkUploadsController::class, 'korpor_file_download']);
    // Route::get('/download_other_bank_file', [BulkUploadBulkUploadsController::class, 'download_other_bank'])->name('download-other-bank-file');
    Route::get('/view-bulk-korpor-transfer', [BulkUploadBulkUploadsController::class, 'view_bulk_korpor_transfer'])->name('view-bulk-korpor-transfer');
    Route::get('/view-bulk-transfer', [BulkUploadBulkUploadsController::class, 'view_bulk_transfer'])->name('view-bulk-transfer');
    Route::get('/delete-bulk-transfer', [BulkUploadBulkUploadsController::class, 'delete_bulk_transfer'])->name('delete-bulk-transfer');
    Route::get('/delete-bulk-upload-file', [BulkUploadBulkUploadsController::class, 'delete_bulk_upload_file'])->name('delete-bulk-upload-file');
    Route::get('/view-bulk-transfer-korpor', [BulkUploadBulkUploadsController::class, 'view_bulk_transfer_korpor'])->name('view-bulk-transfer-korpor');
    Route::get('/view-error-bulk-transfer', [BulkUploadBulkUploadsController::class, 'view_error_bulk_transfer'])->name('view-error-bulk-transfer');
    Route::get('/bulk-korpor-error-transfer', [BulkUploadBulkUploadsController::class, 'bulk_korpor_error_transfer'])->name('bulk-korpor-error-transfer');
    Route::get('/bulk-korpor_detail', [KorporController::class, 'bulk_korpor_detail'])->name('bulk-korpor_detail');
    Route::get('/get-bulk-korpor-upload-list', [BulkUploadBulkUploadsController::class, 'get_bulk_korpor_upload_list'])->name('get-bulk-korpor-upload-list');
    Route::get('/get-bulk-korpor-upload-detail-list', [BulkUploadBulkUploadsController::class, 'get_bulk_korpor_file_details'])->name('get-bulk-korpor-upload-detail-list');
    Route::post('/corporate-reverse-korpor', [BulkUploadCorporateKorporController::class, 'corporate_reverse_korpor'])->name('corporate-reverse-korpor');
    Route::post('/corporate-initiate-korpor', [BulkUploadCorporateKorporController::class, 'corporate_initiate_korpor'])->name('corporate-initiate-korpor');
    Route::post('/get-bulk-detail-list-for-approval', [PendingController::class, 'get_bulk_detail_list_for_approval'])->name('get-bulk-detail-list-for-approval');
    Route::post('/corporate-initiate-cardless', [CardlessController::class, 'corporate_cardless_transfer'])->name('corporate-initiate-cardless');



    // --- LOANS
    Route::get('/loan-request', [LoansController::class, 'loan_request'])->name('loan-request');
    // Route::get('/loan-quotation', [LoansController::class, 'loan_request'])->name('loan-quotation');


    Route::get('request-statement', [AccountServicesController::class, 'request_statement'])->name('request-statement');
    Route::get('close-account', [AccountServicesController::class, 'close_account'])->name('close-account');
    // Route::get('budgeting-spending-statics', [SpendingStaticsController::class, 'spending_statics'])->name('budgeting-spending-statics');
    Route::get('request-blink', [paymentController::class, 'request_blink_payment'])->name('request-blink');
    Route::get('order-blink-payment', [paymentController::class, 'order_blink_payment'])->name('order-blink-payment');
    Route::get('fd-creation', [AccountServicesController::class, 'fd_creation'])->name('fd-creation');
    Route::get('stop-fd', [AccountServicesController::class, 'stop_fd'])->name('stop-fd');
    Route::get('lc-origination', [TradeFinanceController::class, 'lc_origination'])->name('lc-origination');
    Route::get('cheque-services', [AccountServicesController::class, 'chequeServices']);
    Route::get('activate-cheque-book', [AccountServicesController::class, 'activate_cheque_book'])->name('activate-cheque-book');
    // Route::get('salary-advance', [AccountServicesController::class, 'salary_advance'])->name('salary-advance');
    // Route::get('cheque-approvals-approved', [ChequesApprovedController::class, 'cheques_approved'])->name('cheque-approval-approved');
    // Route::get('cheque-approvals-rejected', [ChequesRejectedController::class, 'cheques_rejected'])->name('cheques-approvals-rejected');
    Route::get('stop-cheque', [AccountServicesController::class, 'stop_cheque'])->name('stop-cheque');
    Route::get('request-atm', [AccountServicesController::class, 'request_atm'])->name('request-atm');
    Route::get('block-debit-card', [AccountServicesController::class, 'block_atm'])->name('block-debit-card');
    Route::get('card-services', [CardsController::class, 'cardServices']);
    Route::get('requests', [AccountServicesController::class, 'requests']);
    Route::get('open-additional-account', [AccountServicesController::class, 'open_additional_acc'])->name('open-additional-account');
    Route::get('request-draft', [AccountServicesController::class, 'request_draft'])->name('request-draft');
    Route::get('add-signature', [AccountServicesController::class, 'add_signature'])->name('add-signature');
    Route::get('remove-signature', [AccountServicesController::class, 'remove_signature'])->name('remove-signature');
    Route::get('kyc-update', [AccountServicesController::class, 'kyc_update'])->name('kyc-update');
    Route::get('complaint', [AccountServicesController::class, 'make_complaint'])->name('complaint');

    //APPROVALS
    Route::get('/approvals-pending', [PendingController::class, 'approvals_pending'])->name('approvals-pending');
    Route::get('approvals-approved', [ApprovedController::class, 'approvals_approved'])->name('approvals-approved');
    Route::get('approvals-rejected', [RejectedController::class, 'approvals_rejected'])->name('approvals-rejected');

    Route::get('create-originator', [settingsController::class, 'create_originator'])->name('create-originator');
    Route::get('update-company-info', [settingsController::class, 'update_company_info'])->name('update-company-info');
    Route::get('forgot-transaction-pin', [settingsController::class, 'forgot_transaction_pin'])->name('forgot-transaction-pin');
    Route::get('change-pin', [settingsController::class, 'change_pin'])->name('change-pin');
    Route::get('branch-locator', [branchLocatorController::class, 'branch_locator'])->name('branch-locator');
    //Middleware closing tag below
    // SETTINGS
    Route::get('/settings', [settingsController::class, 'settings'])->name('settings');
    Route::post('post-change-password', [ChangePasswordController::class, 'post_chnage_password']);
});

// Route::get('/get-expenses', [HomeController::class, 'get_expenses'])->name('get-expenses');




// >>>>>>>>>>>>>>>>>>>>>>>>> API ROUTES <<<<<<<<<<<<<<<<<<<<<<<<<<
Route::post('create-originator-api', [settingsController::class, 'create_originator_api'])->name('create-originator-api');
Route::get('set-transaction-limits-api', [settingsController::class, 'set_transaction_limits_api'])->name('set-transaction-limits-api');
Route::get('/get-bulk-upload-list-api', [BulkUploadBulkUploadsController::class, 'get_bulk_upload_list'])->name('get-bulk-upload-list-api');
Route::get('/get-bulk-upload-detail-list-api', [BulkUploadBulkUploadsController::class, 'get_bulk_upload_file_details'])->name('get-bulk-upload-detail-list-api');
Route::get('/post-bulk-transaction-api', [BulkUploadBulkUploadsController::class, 'post_bulk_transaction'])->name('post-bulk-transaction-api');
Route::get('/post-bulk-korpor-transaction-api', [BulkUploadBulkUploadsController::class, 'post_bulk_korpor_transactions'])->name('post-bulk-korpor-transaction-api');
Route::get('/reject-bulk-transaction-api', [BulkUploadBulkUploadsController::class, 'reject_bulk_transaction'])->name('reject-bulk-transaction-api');
// Route::get('/post-bulk-korpor-transaction-api', [BulkUploadBulkUploadsController::class, 'post_bulk_korpor_transaction'])->name('post-bulk-korpor-transaction-api');
Route::get('/get-bulk-korpor-upload-list-api', [BulkKorporController::class, 'get_bulk_korpor_upload_list'])->name('get-bulk-korpor-upload-list-api');
Route::get('/get-bulk-korpor-upload-detail-list-api', [BulkKorporController::class, 'get_bulk_korpor_upload_detail_list'])->name('get-bulk-korpor-upload-detail-list-api');
Route::post('/update-korpor-upload-detail-list-api', [BulkKorporController::class, 'update_bulk_korpor_upload_detail_list'])->name('update-korpor-upload-detail-list-api');
Route::post('account-balance-info-api', [AccountEnquiryController::class, 'account_balance_info'])->name('account-balance-info-api');
Route::post('account-trans-document-api', [AccountEnquiryController::class, 'accountTransDocument']);
Route::get('get-branches-api', [branchLocatorController::class, 'get_branches_api'])->name('get-branches-api');
Route::get('/pending-request-details-api', [PendingController::class, 'pending_request_details'])->name('pending-request-details-api');
Route::post('complaint-api', [ComplaintController::class, 'make_complaint_api'])->name('complaint-api');
Route::get('get-service-type-api', [ComplaintController::class, 'getServiceType']);


//korpor payment
Route::post('/initiate-korpor', [KorporController::class, 'initiate_korpor']);
Route::post('/korpor-otp', [KorporController::class, 'korpor_otp']);
Route::post('/redeem-korpor', [KorporController::class, 'redeem_korpor']);
Route::post('/redeemed-korpor', [KorporController::class, 'send_redeemed_request']);
Route::get('korpor-history-api', [KorporController::class, 'getKorporHistoryByType']);
Route::post('reversed-korpor-request', [KorporController::class, 'send_reversed_request'])->name('reversed-korpor-request');
Route::post('reverse-korpor', [KorporController::class, 'reverse_korpor'])->name('reverse-korpor');

//cardless payment
Route::post('/initiate-cardless', [CardlessController::class, 'initiate_cardless']);
Route::post('/cardless-otp', [CardlessController::class, 'cardless_otp']);
Route::post('/redeem-cardless', [CardlessController::class, 'redeem_cardless']);
Route::post('/redeemed-cardless', [CardlessController::class, 'send_redeemed_request']);
Route::get('/cardless-history-api', [CardlessController::class, 'getCardlessHistoryByType']);
Route::post('reversed-cardless-request', [CardlessController::class, 'send_reversed_request']);
Route::post('reverse-cardless', [CardlessController::class, 'reverse_cardless']);



Route::get('post-security-question-api/{user_id}', [FunctionsController::class, 'reset_security_question'])->name('post-security-question-api');
Route::post('forgot-password-api', [AuthenticationLoginController::class, 'forgot_password'])->name('forgot-password-api');
// GENERAL FUNCTIONS
Route::get('get-currency-list-api', [FunctionsController::class, 'currency_list'])->name('get-currency-list-api');
Route::get('get-bank-list-api', [FunctionsController::class, 'bank_list'])->name('get-bank-list-api');
Route::get('get-countries-list-api', [FunctionsController::class, 'getCountries']);
Route::get('get-international-bank-list-api', [FunctionsController::class, 'international_bank_list']);
Route::get('get-security-question-api', [FunctionsController::class, 'security_question'])->name('get-security-question-api');
Route::get('get-accounts-api', [FunctionsController::class, 'get_accounts'])->name('get-accounts-api');
Route::get('get-expenses', [FunctionsController::class, 'get_expenses'])->name('get-expenses');
Route::post('get-transaction-fees', [FunctionsController::class, 'get_transaction_fees'])->name('get-transaction-fees');
Route::get('get-fx-rate-api', [FunctionsController::class, 'get_fx_rate'])->name('get-fx-rate-api');
Route::get('get-correct-fx-rate-api', [FunctionsController::class, 'get_correct_fx_rate'])->name('get-correct-fx-rate-api');
Route::get('get-lovs-list-api', [FunctionsController::class, 'lovs_list'])->name('get-lovs-list-api');
Route::post('corporate-international-bank-transfer-api', [InternationalBankController::class, 'corporate_international_bank']);


Route::get('/get-my-account', [OwnAccountController::class, 'get_my_accounts']);

// Transfers
Route::get('get-transfer-beneficiary-api', [FunctionsController::class, 'get_transfer_beneficiary'])->name('get-transfer-beneficiary-api');
Route::post('same-bank-transfer-api', [SameBankController::class, 'sameBankTransfer']);
Route::post('local-bank-transfer-api', [LocalBankController::class, 'localBankTransfer']);
Route::post('international-bank-transfer-api', [InternationalBankController::class, 'internationalBankTransfer'])->name('international-bank-transfer-api');
Route::post('own-account-transfer-api', [OwnAccountController::class, 'own_account_transfer']);
Route::post('standing-order-transfer-api', [StandingOrderController::class, 'standingOrderTransfer']);
Route::post('get-standing-order-status-api', [StandingOrderController::class, 'getStandingOrderStatus']);
Route::post('cancel-standing-order-api', [StandingOrderController::class, 'cancelStandingOrder']);

//CORPORATE transfer
Route::post('/corporate-own-account-transfer-api', [OwnAccountController::class, 'corporate_own_account_transfer']);
Route::post('/corporate-same-bank-transfer-api', [SameBankController::class, 'corporate_same_bank']);
Route::post('/corporate-local-bank-transfer-api', [LocalBankController::class, 'corporateLocalBankTransfer']);
Route::post('/corporate-onetime-local-bank-transfer-api', [APITransferLocalBankController::class, 'corporate_onetime_beneficiary']);
Route::post('corporate-standing-order-transfer-api', [StandingOrderController::class, 'corporate_standing_order_request']);
// Transfers Add Beneficiary
Route::post('save-transfer-beneficiary-api', [TransferBeneficiaryController::class, 'saveBeneficiary']);
Route::delete('delete-transfer-beneficiary-api', [TransferBeneficiaryController::class, 'deleteBeneficiary']);
Route::get('transfer-beneficiary-list', [transferController::class, 'transferBeneficiaryList']);

// Payment
Route::post('/save-payment-beneficiary-api', [PaymentBeneficiaryController::class, 'savePaymentBeneficiary']);
Route::delete('/delete-payment-beneficiary-api', [PaymentBeneficiaryController::class, 'deletePaymentBeneficiary']);
Route::get('payment-beneficiary-list-api', [paymentController::class, 'paymentBeneficiaries']);
Route::post('schedule-payment-api', [SchedulePaymentController::class, 'schedule_payment']);
Route::get('get-payment-types-api', [FunctionsController::class, 'payment_types']);
Route::post('payment-name-enquiry-api', [FunctionsController::class, 'recipientNameEnquiry']);
Route::post('make-payment-api', [PaymentsController::class, 'makePayment']);


//route for cheque book request api
Route::post('cheque-book-request-api', [AccountServicesChequeBookRequestController::class, 'cheque_book_request']);
Route::post('cheque-book-block-api', [AccountServicesChequeBookRequestController::class, 'cheque_book_block']);
Route::post('submit-cheque-book-request', [AccountServicesChequeBookRequestController::class, 'cheque_book_request'])->name('submit-cheque-book-request');
Route::post('submit-stop-cheque-book-request', [StopChequeController::class, 'submit_stop_cheque_book_request'])->name('submit-stop-cheque-book-request');

// Corporate chequebook request
Route::post('corporate-chequebook-request', [AccountServicesChequeBookRequestController::class, 'corporate_cheque_book_request'])->name('corporate-chequebook-request');
Route::post('corporate-chequebook-block', [AccountServicesChequeBookRequestController::class, 'corporate_cheque_book_block'])->name('corporate-chequebook-block');


// KYC EDIT
Route::get('get-kyc-details', [KycController::class, 'kyc_update']);
Route::get('validate-kyc-api', [KycController::class, 'validateKyc']);

//route for atm card
Route::post('atm-card-request-api', [AtmCardRequestController::class, 'atm_card_request'])->name('atm-card-request-api');
Route::post('atm-card-block-api', [AtmCardRequestController::class, 'atm_card_block'])->name('atm-card-block-api');
Route::post('corporate-atm-card-request-api', [AtmCardRequestController::class, 'corporate_atm_card_request'])->name('corporate-atm-card-request-api');
Route::post('corporate-block-card-request-api', [AtmCardRequestController::class, 'corporate_bloack_card_request'])->name('corporate-block-card-request-api');
//Activate  Card
Route::post('activate-card-request-api', [AtmCardRequestController::class, 'activate_card_request'])->name('activate-card-request-api');

//Block Card
Route::post('block-card-request-api', [AtmCardRequestController::class, 'block_card_request'])->name('block-card-request-api');

//SALARY ADVANCE
Route::post('get-salary-advance-fee', [SalaryAdvanceController::class, 'salary_advance_fee'])->name('get-salary-advance-fee');
// Route::post('salary-advance', [SalaryAdvanceController::class, 'salary_advance'])->name('salary-advance');
Route::get('corportate-salary-advance', [SalaryAdvanceController::class, 'salary_advance_deposit'])->name('corportate-salary-advance');




// ROUTE FOR ACCOUNT CREATION
Route::post('savings-account-creation-api', [SavingsAccountCreationController::class, 'savings_account_creation'])->name('savings-account-creation-api');

// FIXED DEPOSIT ACCOUNT
Route::get('fixed-deposit-account-api', [FixedDepositAccountController::class, 'fixed_deposit_account'])->name('fixed-deposit-account-api');
Route::get('fixed-deposit', [FixedDepositAccountController::class, 'fixed_deposit'])->name('fixed-deposit');


//route for statement request
Route::post('statement-request-api', [StatementRequestController::class, 'statement_request'])->name('statement-request-api');
Route::post('corporate-statement-request-api', [StatementRequestController::class, 'corporate_statement_request'])->name('corporate-statement-request-api');

//route for change-pin-api
Route::post('change-pin-api', [ChangePinController::class, 'change_pin'])->name('change-pin-api');


//Route for change-password-api
Route::post('change-password-api', [ChangePasswordController::class, 'change_password'])->name('change-password-api');



Route::get('get-card-types-api', [CardsController::class, 'getCardTypes']);



//route to return interest rate types


//route to return loan purposes
Route::get('get-interest-types-api', [LoansController::class, 'get_Interest_Types'])->name('get-interest-types-api');
Route::get('get-loan-frequencies-api', [LoansController::class, 'get_loan_frequencies']);
Route::get('get-loan-purpose-api', [LoansController::class, 'getLoanPurpose']);
Route::get('get-loan-intro-source-api', [LoansController::class, 'getLoanIntroSource']);
Route::get('get-loan-sectors-api', [LoansController::class, 'getLoanSectors']);
Route::get('get-loan-sub-sectors-api', [LoansController::class, 'getLoanSubSectors']);
Route::get('get-loan-products-api', [LoansController::class, 'get_Loan_products']);
Route::post('loan-request-details', [LoansController::class, 'send_loan_request']);
Route::post('loan-quotation-details', [LoansController::class, 'sendLoanRequestQuote']);
Route::post('loan-origination-api', [LoansController::class, 'postLoanOrigination']);
Route::get('get-loan-accounts-api', [LoansController::class, 'get_my_loans_accounts']);
Route::get("get-loan-details-api", [LoansController::class, 'getLoanDetails']);
Route::get("get-loan-types-api", [LoansController::class, 'getLoanTypes']);
Route::get("get-loan-tracking-api", [LoansController::class, 'getLoanTracking']);

//route to return standing order frequencies
Route::get('get-standing-order-frequencies-api', [FunctionsController::class, 'get_standing_order_frequencies'])->name('get-standing-order-frequencies-api');

// transaction receipt
Route::get('transaction-receipt', [AccountEnquiryController::class, 'transaction_receipt']);
