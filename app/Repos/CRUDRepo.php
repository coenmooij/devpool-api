<?php
/**
 * Created by PhpStorm.
 * User: kev_barasa
 * Date: 3/6/18
 * Time: 4:07 PM
 */

namespace App\Repos;


 abstract class CRUDRepo implements CRUDInterface
{
     /**
      * @return \Illuminate\Database\Eloquent\Collection|static[]
      */
     public function all()
     {
         return $this->model->get();
     }
     /**
      * @param int $perPage
      * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
      */
     public function paginate($perPage = 15)
     {
         return $this->model->paginate($perPage);
     }
     /**
      * @param array $data
      * @return $this|\Illuminate\Database\Eloquent\Model
      */
     public function create(array $data)
     {
         return $this->model->create($data);
     }
     /**
      * @param array $data
      * @param $id
      * @return bool
      */
     public function update(array $data, $id)
     {
         return $this->find($id)->update($data);
     }
     /**
      * @param $id
      * @return int
      */
     public function delete($id)
     {
         return $this->model->destroy($id);
     }
     /**
      * @param $id
      * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
      */
     public function find($id)
     {
         return $this->model->find($id);
     }
     /**
      * @param $field
      * @param $value
      * @param $id
      * @return \Illuminate\Database\Eloquent\Model|null|static
      */
     public function findBy($field, $value, $id=null)
     {
         return $this->model->where($field,$value);
     }

}