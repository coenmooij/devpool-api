<?php
/**
 * Created by PhpStorm.
 * User: kev_barasa
 * Date: 3/6/18
 * Time: 4:05 PM
 */

namespace App\Repos;


interface CRUDInterface
{
    public function all();
    public function paginate($perPage = 15);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
    public function findBy($field, $value, $id);

}