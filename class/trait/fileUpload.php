<?php

trait FileUpload
{
    public $tmp_name = "";
    public $image = "";
    public $type;
    public $size = 0;
    public $errors = array();
    abstract protected function upload_directory(): string;
    public string $placeholder = "https://cdn-icons-png.flaticon.com/512/428/428573.png";
    protected $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    protected $allowed_mime_types = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    );
    public array $upload_errors_array = [
        UPLOAD_ERR_OK         => 'File uploaded successfully.',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
        UPLOAD_ERR_PARTIAL   => 'The file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write the file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    ];
    public function ensure_directory_exists($path)
    {
        if (!is_dir($path)) {
            return mkdir($path, 0777, true);
        }
        return true;
    }
    public function image_or_placeholder()
    {
        if (empty($this->image)) {
            return $this->placeholder;
        }
        return rtrim($this->upload_directory(), DS) . DS . $this->image;
    }
    public function set_file($file)
    {
        if (empty($file) || !is_array($file)) {
            $this->errors[] = "File Is NOT avialable";
            return false;
        }
        if (isset($file['error']) && $file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        }
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowed_extensions, true)) {
            $this->errors[] = "Invalid file extension. Allowed: "  . implode(", ", $this->allowed_extensions);
            return false;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime_type, $this->allowed_mime_types, true)) {
            $this->errors[] = "Invalid FIle Type";
            return false;
        }
        $this->tmp_name = $file['tmp_name'];
        $this->image = bin2hex(random_bytes(16)) . "." . $extension;
        $this->type = $mime_type;
        $this->size = (int)$file['size'];
        return true;
    }
    public function save_with_photo()
    {
        if (!empty($this->errors)) {
            return false;
        }
        if (empty($this->tmp_name) || empty($this->image)) {
            $this->errors[] = "The FIle is not Avialable";
            return false;
        }
        $target_dir = SITE_ROOT . DS . $this->upload_directory();
        $this->ensure_directory_exists($target_dir);
        $target_path = $target_dir . DS . $this->image;

        if (file_exists($target_path)) {
            $this->errors[] = "The File {$this->image} Already Exists";
            return false;
        }
        if (move_uploaded_file($this->tmp_name, $target_path)) {
            return true;
        }
        $this->errors[] = "Failed To move uploaded FIle";
        return false;
    }
    public function delete_with_photo()
    {
        $target_path = SITE_ROOT . DS . $this->upload_directory() . DS . $this->image;
        if (method_exists($this, 'delete') && !$this->delete()) {
            return false;
        }
        if (file_exists($target_path) && is_file($target_path)) {
            return unlink($target_path);
        }
        return true;
    }
}
