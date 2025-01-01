<?php
namespace App\Commands\Files;

class SaveFileCommand
{
    private string $path;
    private string $originalName;
    private string $ext;
    private string $fileName;
    private string $url;
    private string $uploadBy;

    public function __construct($path, $originalName, $ext, $fileName, $url, $uploadBy)
    {
        $this->path = $path;
        $this->originalName = $originalName;
        $this->ext = $ext;
        $this->fileName = $fileName;
        $this->url = $url;
        $this->uploadBy = $uploadBy;
    }

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the value of originalName
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Get the value of ext
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the value of uploadBy
     */
    public function getUploadBy()
    {
        return $this->uploadBy;
    }
}
