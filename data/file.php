<?php
class file{
    private $file_name;
    private $file_dir;
    private $file_content;
    public function __construct($file_name, $file_dir){
        $this->file_name = $file_name;
        setDir($file_dir);
    }
    public function getFileContent(){
        if($this->checkFileExists())
            $this->file_content = file_get_contents($this->file_dir . "/" . $this->file_name);
        else echo "File doesn't exist file_get_content aborted.";
    }
    public function renameFile($new_file_name, $new_dir){
        $this->getFileContent();
        $this->fileDelete();
        $this->setDir($new_dir);
        $this->file_name = $new_file_name;
        $this->createFile();
        $this->writeFile($this->file_content);
    }
    public function deleteFile(){
        $file_pointer = $this->file_dir . "/" . $this->file_name; 
   
        // Use unlink() function to delete a file 
        if (!unlink($file_pointer)) { 
            echo ("$file_pointer cannot be deleted due to an error"); 
        } 
        else { 
            echo ("$file_pointer has been deleted"); 
        } 
    }
    public function writeFile(){
        $this->createFile();
        file_put_contents($this->file_dir . "/" . $this->file_name, $this->file_content, FILE_APPEND | LOCK_EX);
    }
    public function createFile(){
        if(!$this->checkFileExists()){
            file_put_contents($this->file_dir . "/" . $this->file_name);
            echo "File created";
            return true;
        }else{
            echo "File already exists thus file not created";
            return false;
        }
    }
    public function checkFileExists(){
        return file_exists($this->file_dir . "/" . $this->file_name);
    }
    public function setDir($file_dir){
        $this->file_dir = $file_dir;
    }
}