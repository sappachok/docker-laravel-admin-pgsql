<?php
namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\OAuthClient;

class OAuthClientsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OAuth Clients';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OAuthClient());

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('user_id', __('User ID'))->sortable();        
        $grid->column("name", __('Name'));

        $grid->column("provider", __('Provider'));
        //$grid->column("redirect", __('Redirect'));
        //$grid->column("personal_access_client", __('Personal Access Client'));
        $grid->column("revoked", __('Revoked'));

        //$grid->column('log_detail', __('Log detail'));
        $grid->column('create_at', __('Create at'))->sortable();
        $grid->column('update_at', __('Update at'))->sortable();

        /*
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();        
            // Add a column filter
            $filter->like("consumer->username", 'consumer');
        });*/
        
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(OAuthClient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('provider', __('Provider'));
        $show->field('redirect', __('Redirect'));

        $show->field('revoked', __('Revoked'));

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OAuthClient());

        $form->text('id', __('Id'));
        $form->text('name', __('Name'));
        $form->text('provider', __('Provider'));
        $form->text('redirect', __('Redirect'));
        //$form->text('revoked', __('Revoked'));
        //$form->text('email_verified_at', __('Email Verified'));
        //$form->text('remember_token', __('Remember Token'));
        $form->text('user_id', __('User ID'));

        $form->datetime('created_at', __('Create at'))->default(date('Y-m-d H:i:s'))->readonly();
        $form->datetime('updated_at', __('Update at'))->default(date('Y-m-d H:i:s'))->readonly();

        return $form;
    }
}
