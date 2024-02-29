<?php
interface IRepository
{
    function getAll();
    function getByPK($pk);
    function update($data);
    function create($data);
} 