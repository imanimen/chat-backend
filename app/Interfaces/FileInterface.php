<?php

namespace App\Interfaces;

interface FileInterface
{
    public function upload($file);
    public function delete($fileId);
}