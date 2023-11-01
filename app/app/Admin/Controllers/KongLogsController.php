<?php
namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\KongLogs;

class KongLogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'KongLogs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new KongLogs());

        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('ip_sender', __('Ip sender'))->sortable();        
        $grid->column("consumer->username", __('Consumer'));
        $grid->column("service->name", __('Service name'));
        $grid->column("request->headers->user-agent", __('User agent'));
        $grid->column("request->url", __('Request URL'));
        $grid->column('agent_sender', __('Agent sender'));
        //$grid->column('log_detail', __('Log detail'));
        $grid->column('create_datetime', __('Create datetime'))->sortable();

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();        
            // Add a column filter
            $filter->like("consumer->username", 'consumer');
        });
        
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
        $show = new Show(KongLogs::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('agent_sender', __('Agent sender'));
        $show->field('ip_sender', __('Ip sender'));
        $show->field('consumer', __('Consumer'))->json();
        $show->field('service', __('Service'))->json();
        $show->field('request', __('Request'))->json();
        $show->field('upstream_uri', __('Upstream URI'));
        $show->field('log_detail', __('Log detail'))->json();
        $show->field('create_datetime', __('Create datetime'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new KongLogs());

        $form->text('agent_sender', __('Agent sender'));
        $form->text('ip_sender', __('Ip sender'));
        $form->textarea('consumer', __('Consumer'));
        $form->textarea('service', __('Service'));
        $form->textarea('request', __('Request'));
        $form->textarea('upstream_uri', __('Upstream URI'));
        $form->textarea('log_detail', __('Log detail'));

        $form->datetime('create_datetime', __('Create datetime'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
