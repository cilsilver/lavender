<?php
namespace App\Http\Controllers\Backend\Catalog;

use App\Http\Controller\BackendEntity;
use Illuminate\Http\Request;

class CategoryController extends BackendEntity
{

    public function __construct()
    {
        $this->loadLayout();
    }

	public function getEdit($id)
    {
        if($model = $this->validateEntity('category', $id)){

            $tabs[] = [
                'label' => "General",
                'content' => workflow('edit_category', ['entity' => $model]),
            ];

            if($model->exists){

                //

            }

            return view('backend.tabs')
                ->with('title', $model->getEntityName())
                ->with('tabs', $tabs);
        }

        return redirect('backend');
    }

	public function getIndex()
	{
        if($model = $this->validateEntity('category')){

            $columns =  [
                'Id'            => 'id',
                'Category Name' => 'name',
                'Last Updated'  => 'updated_at'
            ];

            $new_button = url('backend/category/edit/new');

            compose_section(
                'backend.grid',
                'new_button',
                "<button onclick=\"window.location='{$new_button}';\">Add new category</button>"
            );

            compose_section(
                'backend.grid',
                'mass_actions',
                "<select><option>Action</option></select>"
            );

            return view('backend.grid')
                ->with('title',    'category')
                ->with('edit_url', 'backend/category/edit')
                ->with('rows',      $model->whereNotNull('category_id')->get($columns))
                ->with('headers',   $this->tableHeaders($model, $columns));
        }

        return redirect('backend');
	}


    /**
     * Update a category model
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEdit(Request $request, $id)
    {
        if($model = $this->validateEntity('category', $id)){

            $new = !$model->exists;

            workflow('edit_category', ['entity' => $model])->handle($request->all());

            if($new && $model->exists) return redirect()->to('backend/category/edit/'.$model->id);

        }

        return redirect()->back();
    }

}