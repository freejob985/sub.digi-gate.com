<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('project_cat_index', function($user){
            if (in_array('88', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('project_cat_create', function($user){
            if (in_array('1', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('project_cat_edit', function($user){
            if (in_array('2', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('project_cat_delete', function($user){
            if (in_array('3', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('cancel_project_request_list', function($user){
            if (in_array('4', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('cancel_project_request_show', function($user){
            if (in_array('89', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('cancel_project_request_delete', function($user){
            if (in_array('90', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('verification_index', function($user){
            if (in_array('5', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('single_verification_details', function($user){
            if (in_array('6', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('user_chat_index', function($user){
            if (in_array('7', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('single_user_chat_details', function($user){
            if (in_array('8', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancers_index', function($user){
            if (in_array('9', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('single_freelancer_details', function($user){
            if (in_array('10', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('pay_to_freelancer', function($user){
            if (in_array('91', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_delete', function($user){
            if (in_array('92', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        //blade baki ase code boshano
        $gate->define('freelancer_package_index', function($user){
            if (in_array('11', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_package_create', function($user){
            if (in_array('12', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_package_edit', function($user){
            if (in_array('13', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_package_delete', function($user){
            if (in_array('14', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_skill_index', function($user){
            if (in_array('15', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_skill_create', function($user){
            if (in_array('16', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_skill_edit', function($user){
            if (in_array('17', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_skill_delete', function($user){
            if (in_array('18', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_badge_index', function($user){
            if (in_array('19', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_badge_create', function($user){
            if (in_array('20', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_badge_edit', function($user){
            if (in_array('21', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_badge_delete', function($user){
            if (in_array('22', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('withdraw_request_index', function($user){
            if (in_array('23', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('withdraw_request_details', function($user){
            if (in_array('24', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_package_index', function($user){
            if (in_array('25', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_package_create', function($user){
            if (in_array('26', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_package_edit', function($user){
            if (in_array('27', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_package_delete', function($user){
            if (in_array('28', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_badge_index', function($user){
            if (in_array('29', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_badge_create', function($user){
            if (in_array('30', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_badge_edit', function($user){
            if (in_array('31', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_badge_delete', function($user){
            if (in_array('32', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_list_index', function($user){
            if (in_array('33', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('single_client_details', function($user){
            if (in_array('34', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_review_index', function($user){
            if (in_array('35', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_review_details', function($user){
            if (in_array('36', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_review_index', function($user){
            if (in_array('37', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_review_details', function($user){
            if (in_array('38', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_category_create', function($user){
            if (in_array('39', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_category_edit', function($user){
            if (in_array('40', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_category_index', function($user){
            if (in_array('41', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_category_delete', function($user){
            if (in_array('42', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_default_assigned_ticket_index', function($user){
            if (in_array('43', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_active_ticket_index', function($user){
            if (in_array('44', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_ticket_delete', function($user){
            if (in_array('45', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_my_ticket_index', function($user){
            if (in_array('46', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_my_ticket_reply', function($user){
            if (in_array('47', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_solved_ticket_index', function($user){
            if (in_array('48', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('support_solved_ticket_reply', function($user){
            if (in_array('49', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('accounting_summary_index', function($user){
            if (in_array('50', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('project_payment_history_index', function($user){
            if (in_array('51', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('project_payment_history_details', function($user){
            if (in_array('52', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('client_package_payment_history', function($user){
            if (in_array('53', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_package_payment_history', function($user){
            if (in_array('54', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('milestone_payment_request_index', function($user){
            if (in_array('55', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('milestone_payment_details', function($user){
            if (in_array('56', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('freelancer_payment_index', function($user){
            if (in_array('57', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('wallet_recharge_index', function($user){
            if (in_array('58', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('role_index', function($user){
            if (in_array('59', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('role_create', function($user){
            if (in_array('60', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('role_edit', function($user){
            if (in_array('61', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('role_delete', function($user){
            if (in_array('62', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('system_configuration', function($user){
            if (in_array('63', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('activation_configuration', function($user){
            if (in_array('64', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('payment_gateway_configuration', function($user){
            if (in_array('65', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('social_media_and_3rd_party_configuration', function($user){
            if (in_array('66', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('currency_index', function($user){
            if (in_array('67', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('currency_create', function($user){
            if (in_array('68', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('currency_edit', function($user){
            if (in_array('69', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('currency_delete', function($user){
            if (in_array('70', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('currency_configuration', function($user){
            if (in_array('71', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('country_index', function($user){
            if (in_array('72', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('country_create', function($user){
            if (in_array('73', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('country_edit', function($user){
            if (in_array('74', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('country_delete', function($user){
            if (in_array('75', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('state_index', function($user){
            if (in_array('76', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('state_create', function($user){
            if (in_array('77', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('state_edit', function($user){
            if (in_array('78', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('state_delete', function($user){
            if (in_array('79', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('policy_index', function($user){
            if (in_array('80', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('policy_update', function($user){
            if (in_array('81', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });
        
        $gate->define('employee_create', function($user){
            if (in_array('85', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('employee_edit', function($user){
            if (in_array('86', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });

        $gate->define('employee_delete', function($user){
            if (in_array('87', json_decode($user->userRoles->first()->permissions))) {
                return true;
            }
        });
    }
}
