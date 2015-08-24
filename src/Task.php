<?php
class Task
{
    private $description;
    private $category_id;
    private $id;
    private $date;


    //Constructors
    function __construct($description, $id = null, $category_id, $date)
    {
        $this->description = $description;
        $this->id = $id;
        $this->category_id = $category_id;
        $this->date = $date;
    }

    //Setters
    function setDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function setDate($new_date)
    {
        $this->date = (string) $new_date;
    }

    //Getters
    function getDescription()
    {
        return $this->description;
    }

    function getId()
    {
      return $this->id;
    }

    function getCategoryId()
    {
        return $this->category_id;
    }

    function getDate()
    {
        return $this->date;
    }

    //Save function
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO tasks (description, category_id, date) VALUES ('{$this->getDescription()}', {$this->getCategoryId()}, '{$this->getDate()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    //Get All function
    static function getAll()
    {
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks ORDER BY date;");
        $tasks = array();
        foreach($returned_tasks as $task) {
          $description = $task['description'];
          $id = $task['id'];
          $category_id = $task['category_id'];
          $new_task = new Task($description, $id, $category_id);
          array_push($tasks, $new_task);
        }
        return $tasks;
    }

    //Delete ALl function
    static function deleteAll()
    {
      $GLOBALS ['DB']->exec("DELETE FROM tasks;");
    }


    //Find function
    static function find($search_id)
    {
      $found_task = null;
      $tasks = Task::getAll();
      foreach($tasks as $task) {
        $task_id = $task->getId();
        if ($task_id == $search_id) {
          $found_task = $task;
        }
      }
      return $found_task;
    }
}

?>
