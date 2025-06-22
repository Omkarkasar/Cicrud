<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Student;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function index()
    {
        $model = new Student();
        $data['students'] = $model->paginate(2);
        $data['pager'] = $model->pager;             
        return view('index', $data);
    }

    public function storestudent()
    {
        $model = new Student();
        $data = $this->request->getPost();  
        if (
            !$this->validate([                           
                'name' => 'required|min_length[2]'             
            ])
        )                                                   
        {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);   

        }
        $model->save($data);
        return $this->response->setJSON(['success' => 'Data is Saved']);
    }
    public function editstudent($id)
    {
        $model=new Student();
        return $this->response->setJSON($model->find($id));  
    }

       public function updatestudent($id)
    {
        $model = new Student();
        $data = $this->request->getPost();  
        if (
            !$this->validate([                           
                'name' => 'required|min_length[2]'             
            ])
        )                                                   
        {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);   

        }
        $data['id']=$id;     
        $model->save($data);
        return $this->response->setJSON(['success' => 'Data is Updated']);
    }

     public function deletestudent($id)
    {
        $model=new Student();
        $model->delete($id);
        return $this->response->setJSON(['success' => 'Data is Deleted']);  
    }

}
