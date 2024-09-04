<?php
    class Todo {
        public $name;
        public $thing;
        public $date;
        public $spec_details;
        private $data;
        public $id;

        public function checklen($thing) {        
            if (strlen($thing) < 5) {
                return false;
            }
            else {
                return true;
            }
        }

        function __construct() {
            $this->data = json_decode(file_get_contents('todos.json'));
            // $this->data['task'] = ...;
        }
        public function set_values($thing, $name, $date, $spec_details) {
            $this->thing = $thing;
            $this->name = $name;
            $this->date = $date;
            $this->spec_details = $spec_details;
            $this->id = uniqid();
        }

        public function addtodo() {
            if ($this->thing != null) {
                $this->data[] = ['ID'=>$this->id,'task'=> $this->thing, 'name' => $this->name,
                'date'=> $this->date, 'other' => $this->spec_details];
                $this->save();
            }
            // $this->id++;
        }

        private function save() {
            file_put_contents('todos.json', json_encode($this->data));
        }

        public function clear() {
            file_put_contents('todos.json', json_encode([]));
        }

        public function done($id) {
            // echo $this->id;
           echo ' <div>
                    <form action="" method="post">
                        <input type="hidden" name="klar" value=' . $id. '>
                        <input type="submit" value="Klar">
                    </form>
                </div>';
                        
            if (isset($_POST['klar'])) {
                $id = $_POST['klar'];
                $todos = json_decode(file_get_contents('todos.json'));
            
                foreach ($todos as $index => $todo) {
                    if ($todo->ID == $id) {
                        unset($todos[$index]);
                    }
                }
            
                $todos = array_values($todos);
                file_put_contents('todos.json', json_encode($todos));
                header("Location: ".$_SERVER['REQUEST_URI']);
                exit;
            } 
        }
    }
