<?php


    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;
    use function PHPUnit\Framework\throwException;


    abstract class  CoreRepository
    {

        /**
         * @var Model
         */
        protected $model;

        public function  __construct() {
            $this->model = app($this->getModelClass());
        }

        abstract protected function  getModelClass();

        protected function statrConditions(){
            return clone $this->model;
        }
    }