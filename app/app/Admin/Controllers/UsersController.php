<?php
namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\User;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Users';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();        
        $grid->column("email", __('Email'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email Verified'));
        $show->field('remember_token', __('Remember Token'));
        $show->field('uid', __('UID'));
        $show->field('create_at', __('Create at'));
        $show->field('update_at', __('Update at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('id', __('Id'));
        $form->text('name', __('Name'));
        $form->text('email', __('Email'));
        $form->text('email_verified_at', __('Email Verified'));
        $form->text('remember_token', __('Remember Token'));
        $form->text('uid', __('UID'));

        $form->datetime('create_at', __('Create at'))->default(date('Y-m-d H:i:s'))->readonly(); 
        $form->datetime('update_at', __('Update at'))->default(date('Y-m-d H:i:s'))->readonly();

        return $form;
    }
}
