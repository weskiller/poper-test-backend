<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\School\Approve;
use App\Constants\SchoolStatus;
use App\Models\School;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SchoolController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Example controller';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new School());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('status', __('status'))->display(fn($status) => SchoolStatus::description((int)$status));
        $grid->column('name', __('name'));
        $grid->column('founder.email', __('founder'));
        $grid->column('created_at', __('Created at'))->display(fn($createdAt) => Carbon::make($createdAt)?->format('Y-m-d H:i'));
        $grid->column('updated_at', __('Updated at'))->display(fn($updatedAt) => Carbon::make($updatedAt)?->format('Y-m-d H:i'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
            $actions->add(new Approve);
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
        $show = new Show(School::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('status', __('status'));
        $show->field('name', __('name'));
        $show->field('founder.email', __('founder'));
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
        $form = new Form(new School);

        $form->display('id', __('ID'))->setDisplay(false);
        $form->display('status', __('status'));
        $form->display('founder.email', __('founder'))->disable();
        $form->display('name', __('name'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
