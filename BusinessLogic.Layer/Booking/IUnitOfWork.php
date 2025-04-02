<?php

interface IUnitOfWork {
    public function getContext();
    public function getRepository($entity);
    public function saveChanges();
    public function saveChangesAsync();
    public function dispose();
}

?>