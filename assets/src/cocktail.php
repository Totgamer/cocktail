<?php


class Cocktail {
    /* 
        variables of class Cocktail
    */
    // public variables
    public $con;
    public $id;
    public $name;
    public $img;
    public $alcohol;
    public $glas;
    public $ingredients = array();

    // private variables
    private $liked;
    private $likes;
    private $get_cocktail;
    private $cur_cocktail;
    
    /*
        contruct function
        $url is the given url for a random cocktail
    */
    public function __construct($url) {
        include_once 'assets/config/connect.php';
        // gets data from api en converts to php array
        $json = file_get_contents($url);
        $data = json_decode($json,true);
        
        // variables
        $this->con = $conn;
        $this->id = $data['drinks'][0]['idDrink'];
        $this->name = $data['drinks'][0]['strDrink'];
        $this->img = $data['drinks'][0]['strDrinkThumb'];
        $this->alcohol = $data['drinks'][0]['strAlcoholic'];
        $this->glas = $data['drinks'][0]['strGlass'];

        // variables based on GET method
        if(isset($_GET['cocktail_id']) && $_GET['cocktail_id'] != ''){
            $this->get_cocktail = mysqli_real_escape_string($this->con, $_GET['cocktail_id']);

            $json = file_get_contents('https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $this->get_cocktail);
            $single_data = json_decode($json,true);

            $this->cur_cocktail = $single_data['drinks'][0]['strDrink'];
            $this->likes = $this->requestId();
        }

        /* 
            checks if strIngredientxx is empty or not 
            if strIngredientxx is filled adds to $this->ingredients array
        */
        $x = 1;

        for($x; $x <= 15; $x++) {
            $ingredient = "strIngredient" . $x;
            if($data['drinks'][0][$ingredient] != NULL) {
                array_push($this->ingredients, $data['drinks'][0][$ingredient]);
            }
        }
    }

    /* 
        Gets executed when user clicks on the +
        adds to list if amout of likes is 0
        else updates amount of likes by +1    
    */
    public function swipe() {

        if($this->likes == 0){

            $sql = "INSERT INTO cocktail_list (`cocktail_id`, `name`, `liked`)
            VALUES ('" . $this->get_cocktail . "','" . mysqli_real_escape_string($this->con, $this->cur_cocktail) . "',1)";

            if ($this->con->query($sql) === TRUE) {
            } else {
            echo "Error: " . $sql . "<br>" . $this->con->error;
            }

            $this->con->close();

        } else {

            $cocktail_likes = $this->requestId();
            $cocktail_likes++;
            $sql = "UPDATE cocktail_list SET liked=" . $cocktail_likes . " WHERE cocktail_id=" . mysqli_real_escape_string($this->con, $this->get_cocktail);

            if ($this->con->query($sql) === TRUE) {
            } else {
            echo "Error: " . $sql . "<br>" . $this->con->error;
            }

            $this->con->close();

        }

    }

    
    /* 
        Checks if cocktail is already liked
        @return $this->liked - amount of likes
    */
    public function requestId() {
        
        $sql = "SELECT `cocktail_id`, `liked` FROM cocktail_list WHERE `cocktail_id` = " . $this->get_cocktail . " LIMIT 1";

        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this->liked = $row['liked'];
            }
        } else {
            $this->liked = 0;
        }
        return $this->liked;
    }
}

?>