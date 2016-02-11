<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class Video extends AppModel {
    
    public $belongsTo = array('VideoAlbum');

    //public $validate = array(
    //    'photo' => array(
    //        'rule' => array('isValidMimeType', array('video/mpeg', 'video/avi', 'video/quicktime', 'image/x-flv', 'image/mp4')),
    //        'message' => 'File is not allowed image type (mpeg, mp4, avi, mov, x-flv)'
    //    )
    //);
    
    protected $__directory;
    
    protected $__tmpFile;
    
    public function beforeSave() {
        if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
            $this->__directory = String::uuid();
            $this->__tmpFile = $this->data['Video']['video'];
            $this->data['Video']['video_dir'] = $this->__directory;
            $this->data['Video']['video'] = $this->data['Video']['video']['name'];
        }
        return true;
    }
    
    public function afterSave($created) { 
        if ($created) {
            $dir = new Folder(WWW_ROOT . DS . 'files' . DS . 'video' . DS . 'video' . DS . $this->__directory, true, 0777);
            $file = new File($this->__tmpFile['tmp_name']);
            if (!$file->copy($dir->path . DS . $this->__tmpFile['name'] , true)) {
                $this->delete($this->getLastInsertId());
                $dir->delete();
            } else {
                $filename = pathinfo($this->__tmpFile['name']);
                $this->id = $this->getLastInsertId();
                $this->saveField('video', $filename['filename'] . '.mp4');
                chdir($dir->path);
                exec('/opt/local/bin/ffmpeg -i ' . $this->__tmpFile['name'] . ' -vcodec copy -acodec copy ' . $dir->path . DS . $filename['filename'] . '.mp4 2>&1');
                exec('/opt/local/bin/ffmpeg -itsoffset -1 -i ' . $this->__tmpFile['name'] . ' -vcodec mjpeg -vframes 1 -an -f rawvideo -s 150x150 ' . $dir->path . DS . $filename['filename'] . '.jpg 2>&1');
            }
        }
    }
        
}

?>