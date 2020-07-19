<?php
$log_path = "data/log/";
define("LOG_PATH", $log_path);
define("BACKUP_PATH", LOG_PATH. "backup/");

class Logger{

  /**
   * Method that allow the user to write data into a log file.
   * 
   * @param string $data is the data that you want to put into the log file.
   * @param string $type is the type of the data. |LOG|INFO|WARN|ERROR|
   * @param string $file is the concerned file. Default = main.log
   * @param bool $flush is true or false. If true then the content will be erase after else it will not. Default = false.
   * 
   * @return bool if the content has been writed into the file then return true, else return false.
   */
  public static function log($data, $type="INFO", $file="main" , $flush = false){
    //todo parse la data si celle ci est un tableau ou du json ou quoi.
    $log_path = strpos("$file",".log") ? LOG_PATH . $file : LOG_PATH . $file . ".log";
    if(file_exists($log_path)){
      $current_file = fopen($log_path, 'a');
      $final_data = "[".date("d/m/Y H:i:s")."][$type] : $data";
      return(fwrite($current_file,"$final_data\n") > 0);
    }
    return(false);
  }

  /**
   * Method that allow the user to flush a log file data.
   * 
   * @param string $file is the name of the log file.
   * @return bool return true if the file has been erased else false.
   */
  public static function flush($file){
    $log_path = strpos($file, ".log") ? LOG_PATH . $file : LOG_PATH . $file . ".log";
    if(file_exists($log_path)){
      file_put_contents($log_path,"");
      return(empty(file_get_contents($log_path)));
    }
    return false;
  }

  /**
   * Method that allow the user to save a log file.
   * 
   * @param string $file is the name of the log file.
   * @param bool $fileTime is to define if the timestamp will be the actual timestamp or the timestamp of the file's last edit.
   * 
   * @return bool return true if the file has been save else return false.
   */
  public static function save($file, $fileTime = true){
    $log_path = strpos($file, ".log") ? LOG_PATH . $file : LOG_PATH . $file . ".log";
    $backup_path = $fileTime ? (strpos($file,".log") ? BACKUP_PATH.substr($file,0,-3)."_".filemtime($log_path).".log" : BACKUP_PATH.$file."_".filemtime($log_path).".log") : (strpos($file,".log") ? BACKUP_PATH.substr($file,0,-3)."_".time().".log" : LOG_PATH . "backup/".$file."_".time().".log");
    if(file_exists($log_path)){
      if(file_exists(BACKUP_PATH)){
        file_put_contents($backup_path,file_get_contents($log_path));
      }
    }
  }
}
?>